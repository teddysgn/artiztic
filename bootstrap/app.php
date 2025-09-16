<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'check.login'           => App\Http\Middleware\CheckLogin::class,
            'permission.admin'      => App\Http\Middleware\PermissionAdmin::class,
            'auth.login'            => App\Http\Middleware\AuthLogin::class,
            'check.online'          => App\Http\Middleware\CheckUserOnline::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
