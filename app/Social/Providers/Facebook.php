<?php

namespace App\Social\Providers;

use App\Social\Contracts\SocialProvider;
use Efriandika\LaravelSettings\Facades\Settings;
use Facebook\Exceptions\FacebookSDKException;
use Illuminate\Http\Request;
use Illuminate\Log\Writer as Log;
use Illuminate\Session\Store;
use Laracasts\Flash\Flash;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;
use SammyK\LaravelFacebookSdk\LaravelPersistentDataHandler;

class Facebook implements SocialProvider
{
    const APP_KEY = 'fb_app_id';

    const APP_SECRET = 'fb_app_secret';

    const SESSION_ACCESS_TOKEN = 'fb_user_access_token';

    const SESSION_PAGES = 'fb_page';

    /**
     * @var SammyK\LaravelFacebookSdk\LaravelFacebookSdk
     */
    protected $fb;

    /**
     * @var Illuminate\Log\Writer
     */
    protected $log;

    /**
     * @var Illuminate\Session\Store
     */
    protected $settings;

    /**
     * @return mixed
     */
    public function IsLoggedIn()
    {
        return $this->getAccessToken();
    }

    /**
     * @param Efriandika\LaravelSettings\Settings $session
     * @param Illuminate\Log\Writer $log
     */
    public function __construct(Log $log)
    {
        $this->fb = $this->newInstance();
        $this->log = $log;
    }

    public function callback(Request $request)
    {
        $helper = $this->fb->getRedirectLoginHelper();

        try {
            $token = $this->fb->getAccessTokenFromRedirect();
        } catch (FacebookSDKException $e) {
            $this->log->error('[Social Error][Facebook]' . $e->getMessage());
            return false;
        }

        if (!$token) {
            $helper = $this->fb->getRedirectLoginHelper();

            if ($helper->getError()) {
                $error = sprintf("[%s] %s - %s",
                    $helper->getErrorCode(),
                    $helper->getErrorReason(),
                    $helper->getErrorDescription());
            }
            $this->log->error('[Social Error][Facebook] Token has not been set on callback. ' . $error);
            Flash::error('Something went wrong while getting the Facebook access token. ' . $error);
            return false;
        }

        $this->makeTokenLongLived($token);

        // Save for later
        Settings::set(self::SESSION_ACCESS_TOKEN, (string) $token);
        return true;
    }

    /**
     * @return mixed
     */
    public function getAccessToken()
    {
        if (!Settings::hasKey(self::SESSION_ACCESS_TOKEN)) {
            return false;
        }

        $token = Settings::get(self::SESSION_ACCESS_TOKEN);
        \Session::put(self::SESSION_ACCESS_TOKEN, $token);
        $this->fb->setDefaultAccessToken($token);
        return $token;
    }

    /**
     * @return mixed
     */
    public function getLoginUrl()
    {
        if ($this->IsLoggedIn()) {
            return false;
        }
        return $this->fb->getLoginUrl($this->getRequiredPermission());
    }

    public function getName()
    {
        return 'Facebook';
    }

    /**
     * @return mixed
     */
    public function getPages()
    {
        $pages = $this->getLoginUrl();

        if ($this->IsLoggedIn()) {
            $pages = $this->getPagesFromRemote();
        }

        return $pages;
    }

    public function getRequiredSettings()
    {
        return [
            'title' => 'Facebook',
            'settings' => [
                [
                    'title' => trans('settings.facebook_app_id'),
                    'id' => self::APP_KEY,
                ],
                [
                    'title' => trans('settings.facebook_app_secret'),
                    'id' => self::APP_SECRET,
                ],
            ],
        ];
    }

    public function isInitialized()
    {
        return Settings::hasKey(self::APP_KEY) &&
        Settings::hasKey(self::APP_SECRET) &&
        !empty(Settings::get(self::APP_KEY)) &&
        !empty(Settings::get(self::APP_SECRET));
    }

    public function logout()
    {
        Settings::forget(self::SESSION_ACCESS_TOKEN);
        Settings::forget(self::SESSION_PAGES);

        return true;
    }

    public function post($data = [])
    {
        if (!$this->IsLoggedIn()) {
            return (Object) [
                'success' => false,
                'message' => trans('social.login.byadmin', ['social' => 'Facebook']),
            ];
        }

        $page = $this->getPage(Settings::get(self::SESSION_PAGES));
        return $this->postToPage($page, $data);
    }

    protected function getPage($pageId)
    {
        return $this->getPages()->where('id', $pageId)->first();
    }

    /**
     * @param $page
     * @return mixed
     */
    protected function getPageAccessToken($page)
    {
        return $this->getPage($page)->access_token;
    }

    protected function getPagesFromRemote()
    {
        if (isset($this->remotePages)) {
            return $this->remotePages;
        }

        $this->remotePages = collect(
            $this->fb->get('/me/accounts', $this->getAccessToken())
                ->getDecodedBody()['data']
        )
            ->map(function ($page) {
                return (Object) $page;
            });
        return $this->remotePages;
    }

    /**
     * Returns all permission to request from facebook
     * @return [type] [description]
     */
    protected function getRequiredPermission()
    {
        return ['manage_pages', 'publish_pages'];
    }

    /**
     * Makes the $token long lived
     * @param $token
     */
    protected function makeTokenLongLived($token)
    {
        if (!$token->isLongLived()) {
            $oauth_client = $this->fb->getOAuth2Client();
            try {
                $token = $oauth_client->getLongLivedAccessToken($token);
            } catch (FacebookSDKException $e) {
                $this->log->error('[Social Error][Facebook] Couldn\' create long lived access token. ' . $e->getMessage());
            }
        }
    }

    /**
     * Creates a new instance of the laravel-facebook-sdk
     * @return SammyK\LaravelFacebookSdk\LaravelFacebookSdk
     */
    protected function newInstance()
    {
        $app_id = Settings::get('facebook_app_id');
        $app_secret = Settings::get('facebook_app_secret');
        $config = [
            'app_id' => $app_id ?: env('FACEBOOK_APP_ID'),
            'app_secret' => $app_secret ?: env('FACEBOOK_APP_SECRET'),
            'default_graph_version' => 'v2.5',
            'persistent_data_handler' => new LaravelPersistentDataHandler(app('session.store')),
        ];

        return new LaravelFacebookSdk(app('config'), app('url'), $config);
    }

    protected function postToPage($page, $data)
    {
        if (isset($page->access_token)) {
            $pageAccessToken = $page->access_token;
        }

        try {
            $this->fb->post("/$page->id/feed", $data, $pageAccessToken);
        } catch (FacebookSDKException $e) {
            return (Object) [
                'success' => false,
                'message' => trans(
                    'social.facebook.error.post',
                    [
                        'page' => $page->name,
                        'fberror' => $e->getMessage(),
                    ]
                ),
            ];
        }

        return true;

    }
}
