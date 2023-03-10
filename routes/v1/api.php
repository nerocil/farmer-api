<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\VersionOne\DashboardController;
use App\Http\Controllers\VersionOne\GroupController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
 *
 * See rout service provider for config api versioning ....
 * */
Route::post('/login',[AuthenticationController::class,'onUserAttemptLogin'])->name('login');

Route::middleware(['auth:sanctum'])->group(function(){

    Route::controller(DashboardController::class)
        ->prefix('dashboard')
        ->group(function (){
        Route::get('/','dashboard')->name('dashboard');
    });

    Route::controller(GroupController::class)->prefix('group')
        ->group(function (){
        Route::get('/','index')->name('group.index');
        Route::get('group_avatars/{profile_icon}','index')->name('group.avatar');
    });

    Route::post('/logout',[AuthenticationController::class,'onUserAttemptLogout'])
        ->name('logout')->middleware('auth:sanctum');

});

