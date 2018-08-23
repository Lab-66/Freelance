<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\UserController;
use App\Repositories\Social\Facebook;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class FacebookController extends UserController
{
    protected $fb;

    public function __construct(Facebook $fb)
    {
        $this->fb = $fb;
        parent::__construct();

        view()->share('type', 'social');
        view()->share('title', trans('social.facebook.title'));
    }

    public function getCallback(Request $request)
    {
        $this->fb->saveAccessToken();
        return redirect()->route('social.facebook.index');
    }

    public function getDebug()
    {
        return [
            'user_access_token' => $this->fb->getAccessToken(),
            'user_pages' => $this->fb->getPages(),
        ];
    }

    public function getIndex()
    {
        $fbLoginUrl = $this->fb->getLoginUrl();
        $pages = $this->fb->getPages();

        return view('user.social.facebook.index', compact('fbLoginUrl', 'pages'));
    }

    public function getLogout()
    {
        $this->fb->logout();
        return redirect()->route('social.facebook.index');
    }

    public function postPosting(Request $request)
    {
        $pages = $request->get('pages');

        $data = [];

        $this->validate($request, [
            'pages' => 'required',
            'message' => 'required_without:link',
            'link' => 'required_without:message',
            //'place' => 'required_without_all:link,message'
        ]);

        if ($request->has('message')) {
            $data['message'] = $request->get('message');
        }

        if ($request->has('link')) {
            $data['link'] = $request->get('link');
        }
        $rtn = null;
        foreach ($pages as $page) {
            $rtn = $this->fb->postToPageFeed($page, $data);

            if ($rtn !== null) {
                return $rtn;
            }
        }

        Flash::info(trans('social.facebook.success.post'));
        return redirect()->route('social.facebook.index');
    }
}
