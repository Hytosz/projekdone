<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions; // <--- INI YANG SEBELUMNYA HILANG (Penyebab Error Terminal)
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\IsAdmin; // <--- INI PENTING (Penyebab Error Browser)

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Mendaftarkan alias middleware 'admin'
        $middleware->alias([
            'admin' => IsAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();