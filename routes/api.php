<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BilletController;
use App\Http\Controllers\DocController;
use App\Http\Controllers\FoundAndLostController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WallController;
use App\Http\Controllers\WarningController;

Route::get('/ping', function() {
    return ['pong'=>true];
});

Route::get('/401', [AuthController::class, 'unauthorized'])->name('login');

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::post('/auth/validate', [AuthController::class, 'validateToken']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // Mural de avisos
    Route::get('/walls', [WallController::class, 'getAll']);
    Route::post('/wall/{id}/like', [WallController::class, 'like']);

    // Documentos
    Route::get('/docs', [DocController::class, 'getAll']);

    // Livro de ocorrências
    Route::get('/warnings', [WarningController::class, 'getMyWarnings']);
    Route::post('/warnings', [WarningController::class, 'setWarning']);
    Route::post('/warnings/file', [WarningController::class, 'addWarningFile']);

    // Boletos
    Route::get('/billets', [BilletController::class, 'getAll']);

    // Achados e Perdidos
    Route::get('/found-and-lost', [FoundAndLostController::class, 'getAll']);
    Route::post('/found-and-lost', [FoundAndLostController::class, 'insert']);
    Route::put('/found-and-lost/{id}', [FoundAndLostController::class, 'update']);

    // Unidade
    Route::get('/units/{id}', [UnitController::class, 'getInfo']);
    Route::post('/units/{id}/addperson', [UnitController::class, 'addPerson']);
    Route::post('/units/{id}/addvehicle', [UnitController::class, 'addVehicle']);
    Route::post('/units/{id}/addpet', [UnitController::class, 'addPet']);
    Route::post('/unit/{id}/removeperson', [UnitController::class, 'removePerson']);
    Route::post('/unit/{id}/removevehicle', [UnitController::class, 'removeVehicle']);
    Route::post('/unit/{id}/removepet', [UnitController::class, 'removePet']);

    // Reservas
    Route::get('/reservations', [ReservationController::class, 'getReservations']);
    Route::post('/reservations{id}', [ReservationController::class, 'setReservation']);

    Route::get('/reservations/{id}/disableddates', [ReservationController::class, 'getDisabledDate']);
    Route::get('/reservations/{id}/times', [ReservationController::class, 'getTimes']);

    Route::get('/myreservations', [ReservationController::class, 'getMyReservation']);
    Route::delete('/reservations/{id}', [ReservationController::class, 'delMyReservation']);

});

