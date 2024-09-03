<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;
use App\Http\Middleware\LogRequestMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'log' => LogRequestMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // 401 Unauthorized durumunu özelleştiriyoruz
        $exceptions->map(AuthenticationException::class, function (AuthenticationException $exception) {
            return new class($exception) extends \Exception {
                public function render($request)
                {
                    return response()->json([
                        'success' => false,
                        'data' => null,
                        'message' => 'Yetkisiz işlem.',
                        'errors' => 'Yetkisiz işlem.',
                    ], 401);
                }
            };
        });
        // ThrottleRequestsException için özelleştirme
        $exceptions->map(\Illuminate\Http\Exceptions\ThrottleRequestsException::class, function ($exception) {
            return new class($exception) extends \Exception {
                public function render($request)
                {
                    return response()->json([
                        'success' => false,
                        'data' => null,
                        'message' => 'Çok fazla istek yaptınız. Lütfen birkaç dakika sonra tekrar deneyin.',
                        'errors' => 'Çok fazla istek yaptınız.',
                    ], 400);
                }
            };
        });
    })->create();
