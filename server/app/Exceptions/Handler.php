<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Laravel\Sanctum\Exceptions\MissingAbilityException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof ModelNotFoundException) 
        {
            $model = $e->getModel();
            $model = explode('\\', $model)[2];
            $model = strtolower($model);
            return response()->json([
                'message' => $model . " not found",
            ], 404);
        }
        
        if ($e instanceof AuthenticationException)
        {
            return response()->json([
                'message' => 'unauthenticated'  
                
            ], 401);
        }

        if ($e instanceof MissingAbilityException) 
        {
            return response()->json([
                'message' => 'unauthorized'
            ], 403);
        }
        
        dd($e);
        
        parent::render($request, $e);
    }
}
