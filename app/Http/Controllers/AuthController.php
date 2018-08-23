<?php

namespace App\Http\Controllers;

use App\Helpers\Thumbnail;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\PasswordConfirmRequest;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\StaffRequest;
use App\Http\Requests\UserRequest;
use App\Models\Email;
use App\Models\InviteUser;
use App\Models\User;
use App\Models\UserLogin;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Mail\Message;
use Flash;
use Sentinel;
use Session;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AuthController extends Controller
{

    use ResetsPasswords;

    protected $redirectTo = '/';

    public function index()
    {
        if (Sentinel::check()) {
            return redirect("/");
        }
        return view('login');
    }

    /**
     * Account sign in.
     *
     * @return View
     */
    public function getSignin()
    {
        if (Sentinel::check()) {
            if (Sentinel::getUser()->inRole('admin') || Sentinel::getUser()->inRole('staff')) {
                return redirect("/");
            } else {
                return redirect("customers");
            }
        }
        return view('login');
    }

    /**
     * Account sign up.
     *
     * @return View
     */
    public function getSignup($code)
    {
        $inviteUser = InviteUser::where('code', $code)->whereNull('claimed_at')->first();
        if (Sentinel::check() || !isset($inviteUser)) {
            return redirect("/");
        }

        return view('invite', compact('inviteUser'));
    }
    /**
     * Account sign in form processing.
     *
     * @return Redirect
     */
    public function postSignin(LoginRequest $request)
    {
        try {
            if ($user = Sentinel::authenticate($request->only('email', 'password'), $request->has('remember'))) {
                Flash::success(trans('auth.signin_success'));

                $userLogin = new UserLogin();
                $userLogin->user_id = $user->id;
                $userLogin->ip_address = $request->ip();
                $userLogin->save();

                //redirect depending on logged in user role
                if ($user->inRole('admin') || $user->inRole('staff')) {
                    return redirect("/");
                } else {
                    return redirect("customers");
                }
            }
            Flash::error(trans('auth.login_params_not_valid'));
        } catch (NotActivatedException $e) {
            Flash::error(trans('auth.account_not_activated'));
        } catch (ThrottlingException $e) {
            $delay = $e->getDelay();
            Flash::error(trans('auth.account_suspended') . $delay . trans('auth.second'));
        }
        return back()->withInput();
    }

    /**
     * Account sign up form processing.
     *
     * @param UserRequest $request
     * @param $code
     * @return Redirect
     */
    public function postSignup(UserRequest $request, $code)
    {
        $inviteUser = InviteUser::where('code', $code)->whereNull('claimed_at')->first();
        if (isset($inviteUser)) {

            $staff = Sentinel::registerAndActivate(
                array(
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $inviteUser->email,
                    'password' => $request->password,
                )
            );
            $role = Sentinel::findRoleBySlug('staff');
            $role->users()->attach($staff);

            $user = User::find($staff->id);
            $user->user_id = $inviteUser->user_id;
            $user->phone_number = $request->phone_number;
            $user->save();

            $inviteUser->claimed_at = Carbon::now();
            $inviteUser->save();

            return redirect('/');
        } else {
            return back()->withInput();
        }
    }
    /**
     * Account forgot password.
     *
     * @return View
     */
    public function getForgotPassword()
    {
        if (Sentinel::check()) {
            return redirect("/");
        }
        return view('forgot');
    }

    /**
     * Forgot password form processing page.
     *
     * @return Redirect
     */
    public function postForgotPassword(PasswordResetRequest $request)
    {
        if (!filter_var(Settings::get('site_email'), FILTER_VALIDATE_EMAIL) === false) {
            $response = Password::sendResetLink(
                $request->only('email'),
                function (Message $message) {
                    $message->subject(trans('auth.account_password_recovery'));
                }
            );
            switch ($response) {
                case Password::RESET_LINK_SENT:
                    Flash::success(trans($response));

                    return redirect()->back();
                case Password::INVALID_USER:
                    Flash::error(trans($response));

                    return redirect()->back();
            }
        } else {
            return redirect()->back();
        }
    }

    /**
     * Forgot Password Confirmation page.
     *
     * @param  string $passwordResetCode
     * @return View
     */
    public function getForgotPasswordConfirm($token = null)
    {
        if (is_null($token)) {
            throw new NotFoundHttpException;
        }
        return view('reset')->with('token', $token);
    }

    /**
     * Forgot Password Confirmation form processing page.
     *
     * @param  string $passwordResetCode
     * @return Redirect
     */
    public function postForgotPasswordConfirm(PasswordConfirmRequest $request, $passwordResetCode = null)
    {
        try {
            $user = Sentinel::getUserProvider()->findByResetPasswordCode($passwordResetCode);
            if ($user->attemptResetPassword($passwordResetCode, $request['password'])) {
                Flash::success(trans('auth.forgot-password-confirm-success'));
                return redirect()->route('signin');
            } else {
                Flash::error(trans('auth.forgot-password-confirm-error'));
                return redirect()->route('signin');
            }
        } catch (UserNotFoundException $e) {
            Flash::error(trans('auth.account_not_found'));
            return redirect()->route('forgot-password');
        }
    }

    /**
     * Logout page.
     *
     * @return Redirect
     */
    public function getLogout()
    {
        Sentinel::logout(null, true);
        Flash::success(trans('auth.successfully_logout'));
        return redirect('signin');
    }

    /**
     * Profile page.
     *
     * @return Redirect
     */
    public function getProfile()
    {
        if (!Sentinel::check()) {
            return redirect("/");
        }

        $this->generateMessagesFields();

        $title = trans('auth.user_profile');
        $user_data = User::find(Sentinel::getUser()->id);
        return view('profile', compact('title', 'user_data'));
    }

    public function getAccount()
    {
        if (!Sentinel::check()) {
            return redirect("/");
        }
        $title = trans('auth.edit_profile');
        $user_data = User::find(Sentinel::getUser()->id);

        $this->generateMessagesFields();

        return view('account', compact('title', 'user_data'));
    }

    public function postAccount(StaffRequest $request)
    {
        if (!Sentinel::check()) {
            return redirect("/");
        }

        $user = User::find(Sentinel::getUser()->id);
        if ($request->hasFile('user_avatar_file') != "") {
            $file = $request->file('user_avatar_file');
            $extension = $file->getClientOriginalExtension();
            $picture = str_random(10) . '.' . $extension;

            $destinationPath = public_path() . '/uploads/avatar/';
            $file->move($destinationPath, $picture);
            Thumbnail::generate_image_thumbnail($destinationPath . $picture, $destinationPath . 'thumb_' . $picture);
            $user->user_avatar = $picture;
        }
        if ($request->password != "") {
            $user->password = bcrypt($request->password);
        }
        $user->phone_number = $request->phone_number;
        $user->update($request->except('user_avatar_file', 'password', 'password_confirmation'));
        Flash::success(trans('auth.successfully_change_profile'));
        return redirect('profile');
    }

    public function generateMessagesFields()
    {
        $this->non_read_meeages = Email::where('to', Sentinel::getUser()->id)->where('read', '0')->count();
        view()->share('non_read_meeages', $this->non_read_meeages);
        $this->last_meeages = Email::where('to', Sentinel::getUser()->id)->limit(5)->get();
        view()->share('last_meeages', $this->last_meeages);
    }

}
