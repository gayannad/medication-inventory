<?php

use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\MedicationController;
use Illuminate\Support\Facades\Route;

//Route::get('medications', [\App\Http\Controllers\API\MedicationController::class, 'index']);

Route::group(['prefix' => 'v1'], function () {
    //login
    Route::post('login', [\App\Http\Controllers\API\AuthController::class, 'login']);

    //register
    Route::post('register', [\App\Http\Controllers\API\AuthController::class, 'register']);

    Route::middleware(['auth:sanctum'])->group(function () {

        //owner actions
        Route::middleware(['role:owner'])->group(function () {
            Route::post('/medications', [MedicationController::class, 'store']);
            Route::delete('/medications/{id}', [MedicationController::class, 'destroy']);

            Route::post('/customers', [CustomerController::class, 'store']);
            Route::delete('/customers/{id}', [CustomerController::class, 'destroy']);
        });

        //owner,manager,cashier actions
        Route::middleware(['role:owner,manager,cashier'])->group(function () {

            Route::get('/medications', [MedicationController::class, 'index']);
            Route::get('/medications/{id}', [MedicationController::class, 'show']);

            Route::get('/customers', [CustomerController::class, 'index']);
            Route::get('/customers/{id}', [CustomerController::class, 'show']);
        });

        //owner,manager actions
        Route::middleware(['role:owner,manager'])->group(function () {

            Route::put('/medications/{id}', [MedicationController::class, 'update']);
            Route::put('/customers/{customer}', [CustomerController::class, 'update']);
        });

    });

});
