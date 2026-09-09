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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
        'user' => \App\Http\Middleware\UserMiddleware::class,
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
        'verify' => \App\Http\Middleware\EmailVerificationMidddleware::class,
        'teacher' => \App\Http\Middleware\TeacherMidddleware::class,
        'PTA' => \App\Http\Middleware\PTA::class,
        'DC' => \App\Http\Middleware\DC::class,
        'HouseMaster' => \App\Http\Middleware\HouseMaster::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
