<?php

use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeudaController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('welcome');

Auth::routes();

//Borrar ruta
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// theme routes
// Route::view('blank', 'webkit')->name('webkit');
// Route::view('mazer','mazer')->name('mazer');

Route::group([
    'as' => 'frontend.'
], function () {
    Route::get('blogs', [BlogController::class, 'index'])->name('blogs.index');
});

Route::group([
    'middleware' => 'auth'
], function () {
    // Admin Routes
    Route::group([
        'prefix' => 'admin',
        'as' => 'admin.',
        'middleware' => ['auth']
    ], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::get('/deuda', [DeudaController::class, 'index'])->name('deuda.index');

        // Rutas del ShoppingCart
        Route::post('/confirm', [ShoppingCartController::class,'generar_liquidacion'])->name('confirm.generar_liquidacion');
        Route::post('/visa',[DeudaController::class,'post_visa'])->name('visa.post_visa');
        
        //Route::get('/confirm', [ShoppingCartController::class,'rediccion'])->name('confirm.rediccion');
        //Route::post('/deleteitem', [ShoppingCartController::class,'deleteitem'])->name('confirm.deleteitem');        
        //Route::get('/viewer', [DeudaController::class,'postPayments'])->name('viewer.postPayments');
        //Route::get('/visa',[DeudaController::class,'post_visa'])->name('visa.post_visa');
        
        Route::get('/historial',[DeudaController::class,'historial'])->name('historial.constancias');
        Route::get('/pdfrecibo/{coderecibo}',[DeudaController::class,'pdfrecibo'])->name('pdfrecibo.recibo_pago');
        Route::get('/listar_liquidacion_detalle/{codliquidacion}',[DeudaController::class,'listar_liquidacion_detalle'])
            ->name('listar_liquidacion_detalle.detallepagos')
            ->where('codliquidacion', '[A-Za-z0-9\-]+');

        Route::get('/formulario',[DeudaController::class,'formulario'])->name('formulario.formulario');
        Route::post('/formulario',[DeudaController::class,'formulario_send'])->name('formulario.formulario_send');

        Route::get('/resultado',[DeudaController::class,'resultado_recibo'])->name('resultado.resultado_recibo');

        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
        Route::resource('users', UserController::class);
        Route::resource('blogs', AdminBlogController::class);
    });
    // User routes

    // Common routes
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/{user}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/{user}', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/{user}/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
});