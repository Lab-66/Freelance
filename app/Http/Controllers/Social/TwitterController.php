<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\UserController;
use App\Repositories\Social\Twitter;
use Illuminate\Http\Request;

class TwitterController extends UserController
{
    protected $twitter;

    public function __construct(Twitter $tw)
    {
        $this->twitter = $tw;
        parent::__construct();

        view()->share('type', 'social');
        view()->share('title', trans('social.twitter.title'));
        view()->share('twitter', $this->twitter);
    }

    public function getCallback(Request $request)
    {
        return $this->twitter->callback($request);
    }

    public function getIndex()
    {
        return view('user.social.twitter.index');
    }

    public function getLogin()
    {
        return $this->twitter->login();
    }

    public function postTweet(Request $request)
    {
        return $this->twitter->post($request->get('message'));
    }
}
