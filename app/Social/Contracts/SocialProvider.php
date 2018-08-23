<?php

namespace App\Social\Contracts;

use Illuminate\Http\Request;

interface SocialProvider
{
    public function callback(Request $request);

    public function getAccessToken();

    public function getLoginUrl();

    public function getName();

    public function getRequiredSettings();

    public function isInitialized();

    public function logout();

    public function post($data = []);
}
