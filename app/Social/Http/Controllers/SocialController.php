<?php

namespace App\Social\Http\Controllers;

use App\Http\Controllers\UserController;
use App\Social\SocialManager;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class SocialController extends UserController
{
    protected $manager;

    public function __construct(SocialManager $manager)
    {
        parent::__construct();

        view()->share('title', trans('social.title'));
        $this->manager = $manager;
    }

    public function getCallback(Request $request, $provider)
    {
        $provider = $this->manager->getProvider($provider);
        if (!$provider->callback($request)) {
            Flash::error(trans('social.twitter.failed.login', ['provider' => $provider->getName()]));
            return redirect()->action('\App\Http\Controllers\Users\SettingsController@index');
        }
        Flash::success(trans('social.success.login', ['provider' => $provider->getName()]));
        return redirect()->action('\App\Http\Controllers\Users\SettingsController@index');
    }

    public function getIndex()
    {
        $providers = $this->manager->getProviders();
        return view('user.social.index', compact('providers'));
    }

    public function getLogout($provider)
    {
        $provider = $this->manager->getProvider($provider);
        if (!$provider->logout()) {
            Flash::error(trans('social.failed.logout', ['provider' => $provider->getName()]));
            return redirect()->action('\App\Http\Controllers\Users\SettingsController@index');
        }
        Flash::success(trans('social.success.logout', ['provider' => $provider->getName()]));
        return redirect()->action('\App\Http\Controllers\Users\SettingsController@index');
    }

    public function postPosting(Request $request)
    {
        $providers = collect();

        foreach ($request->get('provider') as $providerKey) {
            $providers->push($this->manager->getProvider($providerKey));
        }

        $data = $request->only(['message']);
        $message = [];
        $providers = $providers->each(function ($provider) use ($message, $data) {
            $response = $provider->post($data);
            $message[$provider->getName()] = $response;
        });

        if (count($message) > 0) {
            Flash::error($message);
        } else {
            Flash::success(trans('social.success.post', [
                'providers' => $providers->map(function ($p) {
                    return $p->getName();
                })->implode(', '),
            ]));
        }
        return redirect()->back();
    }
}
