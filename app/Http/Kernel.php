<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\VerifyInstallation::class,
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'admin' => \App\Http\Middleware\Admin::class,
        'customer' => \App\Http\Middleware\Customer::class,
        'sentinel' => \App\Http\Middleware\SentinelAuth::class,
        'authorized' => \App\Http\Middleware\Authorized::class,
        'jwt' => \Dingo\Api\Auth\Provider\JWT::class,
        'jwt.auth' => \Tymon\JWTAuth\Middleware\GetUserFromToken::class,
        'jwt.refresh' => \Tymon\JWTAuth\Middleware\RefreshToken::class,
        'api.user.staff' => \App\Http\Middleware\ApiUserStaff::class,
        'api.customer' => \App\Http\Middleware\ApiCustomer::class,
        'enabled' => \App\Http\Middleware\AvailableModules::class,
        'xss_protection' => \App\Http\Middleware\XSSProtection::class
    ];
}
