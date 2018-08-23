<?php

namespace App\Social\Providers;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Social\Contracts\SocialProvider;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Http\Request;

class Twitter implements SocialProvider
{
    const CONSUMER_KEY = 'twitter_consumer_id';

    const CONSUMER_SECRET = 'twitter_consumer_secret';

    const SESSION_ACCESS_TOKEN = 'twitter_access_token';

    const SESSION_ACCESS_TOKEN_SECRET = 'twitter_access_token_secret';

    const SESSION_REQUEST_TOKEN = 'twitter_request_token';

    public function __construct()
    {
        if ($this->isInitialized()) {
            $access_token = null;
            $access_token_secret = null;

            if ($this->isLoggedIn()) {
                list($access_token, $access_token_secret) = $this->getAccessToken();
            }

            $this->tw = new TwitterOAuth(
                Settings::get(self::CONSUMER_KEY),
                Settings::get(self::CONSUMER_SECRET),
                $access_token,
                $access_token_secret
            );

            $this->tw->get('account/verify_credentials');
        }

    }

    public function callback(Request $request)
    {
        $request_token = Settings::get(self::SESSION_REQUEST_TOKEN);

        Settings::forget(self::SESSION_REQUEST_TOKEN);

        if (
            $request->has('oauth_token') &&
            $request_token['oauth_token'] !== $request->get('oauth_token')
        ) {
            return false;
        }

        $tw = new TwitterOAuth(
            Settings::get(self::CONSUMER_KEY),
            Settings::get(self::CONSUMER_SECRET),
            $request_token['oauth_token'],
            $request_token['oauth_token_secret']
        );

        $access_token = $tw->oauth('oauth/access_token', [
            'oauth_verifier' => $request->get('oauth_verifier'),
        ]);

        Settings::set(self::SESSION_ACCESS_TOKEN, $access_token['oauth_token']);
        Settings::set(self::SESSION_ACCESS_TOKEN_SECRET, $access_token['oauth_token_secret']);

        return true;
    }

    public function getAccessToken()
    {
        return [
            Settings::get(self::SESSION_ACCESS_TOKEN),
            Settings::get(self::SESSION_ACCESS_TOKEN_SECRET),
        ];
    }

    public function getLoginUrl()
    {
        $request_token = $this->tw->oauth(
            'oauth/request_token',
            [
                'oauth_callback' => route('social.callback', ['twitter']),
            ]
        );

        Settings::set(self::SESSION_REQUEST_TOKEN, $request_token);

        $url = $this->tw->url(
            'oauth/authorize',
            [
                'oauth_token' => $request_token['oauth_token'],
            ]
        );

        return $url;
    }

    public function getName()
    {
        return 'Twitter';
    }

    public function getRequiredSettings()
    {
        return [
            'title' => 'Twitter',
            'settings' => [
                [
                    'title' => trans('settings.twitter_consumer_id'),
                    'id' => self::CONSUMER_KEY,
                ],
                [
                    'title' => trans('settings.twitter_consumer_secret'),
                    'id' => self::CONSUMER_SECRET,
                ],
            ],
        ];
    }

    public function isInitialized()
    {
        return Settings::hasKey(self::CONSUMER_KEY) &&
        Settings::hasKey(self::CONSUMER_SECRET) &&
        !empty(Settings::get(self::CONSUMER_KEY)) &&
        !empty(Settings::get(self::CONSUMER_SECRET));
    }

    public function isLoggedIn()
    {
        return Settings::hasKey(self::SESSION_ACCESS_TOKEN) &&
        Settings::hasKey(self::SESSION_ACCESS_TOKEN_SECRET);
    }

    public function logout()
    {
        Settings::forget(self::SESSION_ACCESS_TOKEN);
        Settings::forget(self::SESSION_ACCESS_TOKEN_SECRET);
        return true;
    }

    public function post($data = [])
    {
        if (!isset($data['message'])) {
            \Log::error('[Social][Twitter] missing $data[message]', $data);
            return (Object) [
                'success' => false,
                'message' => trans('social.twitter.error.tweet'),
            ];
        }

        $message = $data['message'];
        if (!$this->isLoggedIn()) {
            return (Object) [
                'success' => false,
                'message' => trans('social.twitter.byadmin'),
            ];
        }

        $this->tw->post('statuses/update', [
            'status' => $message,
        ]);

        if ($this->tw->getLastHttpCode() !== 200) {
            return (Object) [
                'success' => false,
                'message' => trans('social.twitter.error.tweet'),
            ];
        }

        return true;
    }
}
