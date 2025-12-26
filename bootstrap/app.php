<?php

use App\Http\Middleware\HandleInertiaRequests;
use App\Providers\AuthServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withProviders([
        // ... proveedores existentes
        AuthServiceProvider::class, // Tu proveedor aquí
    ])
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'http://127.0.0.1:8000/api/v1/login',
            'http://127.0.0.1:8000/api/v1/logout',
            'http://127.0.0.1:8000/api/v1/sessions/*',
            'http://127.0.0.1:8000/api/v1/*',

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (ValidationException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => [
                        //'id' => (string) Str::uuid(),
                        'type' => 'Validation Error',
                        'status' => 422,
                        'detail' => 'One or more fields are invalid.',
                        'errors' => $e->errors(),
                        'path' => $request->path(),
                        'timestamp' => now()->toISOString(),
                    ],
                ], 422);
            }
        });

        $exceptions->render(function (HttpExceptionInterface $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => [
                        //  'id' => (string) Str::uuid(),
                        'type' => $e->getStatusCode() == 404 ? 'Not Found' : class_basename($e),
                        'status' => $e->getStatusCode(),
                        'detail' => $e->getStatusCode() == 404 ? 'Route or Resource Not Found ' : $e->getMessage(),
                        'path' => $request->path(),
                        'timestamp' => now()->toISOString(),
                    ],
                ], $e->getStatusCode());
            }
        });

        $exceptions->render(function (AuthorizationException $e, Request $request) {
            if (! $request->expectsJson()) {
                return null;
            }

            return response()->json([
                'error' => [
                    'type'      => 'Authorization Error',
                    'status'    => Response::HTTP_FORBIDDEN,
                    'detail'   => $e->getMessage() ?: 'This action is unauthorized.',
                    'path'      => $request->path(),
                    'timestamp' => now()->toISOString(),
                ],
            ], Response::HTTP_FORBIDDEN);
        });
    })->create();
