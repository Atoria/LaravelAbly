<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::middleware([\Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class])->group(function () {
    Route::group(['middleware' => 'auth:sanctum'], function (\Illuminate\Routing\Router $router) {
        Route::group(['prefix' => 'message'], function (\Illuminate\Routing\Router $router) {
            $router->post('/send', [\App\Http\Controllers\ChatController::class, 'send']);
            $router->get('/getToken', [\App\Http\Controllers\ChatController::class, 'getToken']);
        });
        Route::group(['prefix' => 'user'], function (\Illuminate\Routing\Router $router) {
            $router->get('/', [\App\Http\Controllers\UserController::class, 'me']);
        });
    });
});


Route::post('/webhooks/ably', [\App\Http\Controllers\WebhookController::class, 'storeMessage']);
