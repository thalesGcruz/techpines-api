<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
    
        $exceptions->renderable(function (Throwable $e, $request) {
            if ($request->is('api/*') || $request->wantsJson()) {

                if ($e instanceof ModelNotFoundException) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Recurso não encontrado',
                    ], Response::HTTP_NOT_FOUND);
                }

                if ($e instanceof NotFoundHttpException) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Rota não encontrada',
                    ], Response::HTTP_NOT_FOUND);
                }

                if ($e instanceof ValidationException) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Erro de validação',
                        'errors' => $e->errors(),
                    ], Response::HTTP_UNPROCESSABLE_ENTITY);
                }

                if ($e instanceof AuthenticationException) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Não autenticado',
                    ], Response::HTTP_UNAUTHORIZED);
                }

                if ($e instanceof AuthorizationException) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Acesso negado',
                    ], Response::HTTP_FORBIDDEN);
                }
                

                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage() ?: 'Erro interno do servidor',
                ], method_exists($e, 'getStatusCode') ? $e->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            return null;
        });

    })->create();
