<?php

use \Illuminate\Support\Facades\Route;
Auth::routes(['register'=>false]);

//this routes for auth users only ,, every name of route will start with backend
Route::middleware(['auth'])->name('backend.')->prefix('dashboard')->group(function(){
// dashboard route
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
// users route
    Route::resource('users',\App\Http\Controllers\Backend\UserController::class )->except(['create','show']);
// countries route
    Route::resource('countries',\App\Http\Controllers\Backend\CountryController::class );
// states route
    Route::resource('states',\App\Http\Controllers\Backend\StateController::class );
// cities route
    Route::resource('cities',\App\Http\Controllers\Backend\CityController::class );
// departments route
    Route::resource('departments',\App\Http\Controllers\Backend\DepartmentController::class );
// employees route
    Route::resource('employees',\App\Http\Controllers\Backend\EmployeesController::class );

//    exporting data
    Route::get('/users/export/{format}',[\App\Http\Controllers\Backend\UserController::class,'export'] )->where('format','(csv|pdf|xlsx)')->name('users.export');
    Route::get('/cities/export/{format}',[\App\Http\Controllers\Backend\CityController::class,'export'] )->where('format','(csv|pdf|xlsx)')->name('cities.export');
    Route::get('/countries/export/{format}',[\App\Http\Controllers\Backend\CountryController::class,'export'] )->where('format','(csv|pdf|xlsx)')->name('countries.export');
    Route::get('/states/export/{format}',[\App\Http\Controllers\Backend\StateController::class,'export'] )->where('format','(csv|pdf|xlsx)')->name('states.export');
    Route::get('/employees/export/{format}',[\App\Http\Controllers\Backend\EmployeesController::class,'export'] )->where('format','(csv|pdf|xlsx)')->name('employees.export');
    Route::get('/departments/export/{format}',[\App\Http\Controllers\Backend\DepartmentController::class,'export'] )->where('format','(csv|pdf|xlsx)')->name('departments.export');
});
Route::any('/{route?}',function (){
    return redirect()->route('backend.dashboard');
});
