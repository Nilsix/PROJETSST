<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    public function register()
    {
        $this->renderable(function (\Throwable $e, $request) {
            if (
                $e instanceof \Illuminate\Auth\Access\AuthorizationException ||
                ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException && $e->getStatusCode() === 403)
            ) {
                return redirect('/')->with('error', "Vous n'avez pas accès à cette page");
            }
        });
    }
    public function render($request, Throwable $exception)
{
    if (
        $exception instanceof AuthorizationException ||
        ($exception instanceof HttpException && $exception->getStatusCode() === 403)
    ) {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        return redirect()->back()->with('error', "Vous n'avez pas accès à cette page");
    }

    return parent::render($request, $exception);
}
    
}