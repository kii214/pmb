<?php

use App\Http\Middleware\EnsureUserIsAdmin;
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
            'admin' => EnsureUserIsAdmin::class,
        ]);

        $middleware->redirectUsersTo(function (\Illuminate\Http\Request $request) {
            return $request->user()->role === 'admin' ? '/admin' : '/dashboard';
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, \Illuminate\Http\Request $request) {
            if ($request->is('login') || $request->is('login/*')) {
                return redirect()->route('login')->with('status', 'Sesi telah diperbarui, silakan masukkan kembali kata sandi Anda.');
            }
            return redirect()->back()->withInput()->with('status', 'Sesi form Anda telah diperbarui, silakan ulangi kembali.');
        });
    })->create();
