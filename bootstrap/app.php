<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        then: function () {
            Route::middleware('web')
                ->group(base_path('routes/admin.php'));
            
            Route::middleware('web')
                ->group(base_path('routes/client.php'));
            
            Route::middleware('web')
                ->group(base_path('routes/trainer.php'));
        },
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'trainer' => \App\Http\Middleware\TrainerMiddleware::class,
            'admin' => \App\Http\Middleware\AdminMiddlewareNew::class,
            'admin.session' => \App\Http\Middleware\AdminSessionTimeout::class,
            'nocache' => \App\Http\Middleware\NoCacheHeaders::class,
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'registration.limit' => \App\Http\Middleware\RegistrationRateLimiter::class,
            'ensure.onboarding.completed' => \App\Http\Middleware\EnsureOnboardingCompleted::class,
        ]);

        // Exclude Stripe webhook from CSRF protection
        $middleware->validateCsrfTokens(except: [
            'stripe/webhook',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
