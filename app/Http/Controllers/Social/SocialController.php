<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\UserController;
use App\Repositories\Social\SocialManager;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class SocialController extends UserController
{
    public function __construct()
    {
        parent::__construct();

        view()->share('title', trans('social.title'));
    }

    public function getCallback(Request $request, $provider)
    {
        SocialManager::getProvider($provider)->callback($request);
        return redirect()->action('\App\Http\Controllers\Users\SettingsController@index');
    }

    public function getIndex()
    {
        return view('user.social.index');
    }

    public function getLogin()
    {}

    public function getLogout($provider)
    {
        if (!SocialManager::getProvider($provider)->logout()) {
            Flash::error(trans('social.failed.logout', ['provider' => $provider]));
        }
        return redirect()->back();
    }

    public function postPosting(Request $request)
    {
        $providers = SocialManager::getActiveProviders();
        $data = $request->only(['message']);
        $message = [];
        $providers = $providers->each(function ($provider) use ($message, $data) {
            if ($reponse = $provider->post($data) !== true) {
                $message[] = $reponse->message;
            }
        });

        if (count($message) > 0) {
            Flash::error($message);
        } else {
            Flash::success(trans('social.success.post'));
        }
        return redirect()->back();
    }
}
