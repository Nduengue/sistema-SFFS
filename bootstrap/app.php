<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckAccountStatus;
use App\Http\Middleware\CheckUserPrivileges;
use App\Http\Middleware\VerifyStudentToken;
use Illuminate\Http\Middleware\HandleCors;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->use([
            HandleCors::class,
            CheckAccountStatus::class,
        ]);

        $middleware->alias([
            'check.status' => CheckAccountStatus::class,
            'check.privileges' => CheckUserPrivileges::class,
            'verify.student.token' => VerifyStudentToken::class,
        ]);
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();