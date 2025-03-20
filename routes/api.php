<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AgentController;
use App\Http\Controllers\Api\ContenirController;
use App\Http\Controllers\Api\CultureController;
use App\Http\Controllers\Api\ParcelleController;
use App\Http\Controllers\Api\ProducteurController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');
/*
Route::apiResource('producteurs', ProducteurController::class);
Route::apiResource('parcelles', ParcelleController::class);
Route::apiResource('cultures', CultureController::class);
Route::apiResource('admins', AdminController::class);
Route::apiResource('agents', AgentController::class);

*/

//Route Producteurs 
Route::get('producteurs', [ProducteurController::class, 'index']); // Ajout d'un producteur sans authentification
Route::get('producteurs/{id}', [ProducteurController::class, 'show']);
Route::post('producteurs', [ProducteurController::class, 'store']); 
Route::post('producteurs/{id}', [ProducteurController::class, 'update']); // Mise à jour d'un producteur sans authentification
Route::delete('producteurs/{id}', [ProducteurController::class, 'destroy']); // Suppression d'un producteur sans authentification

// Route Parcelles
Route::get('parcelles', [ParcelleController::class, 'index']); // 
Route::get('parcelles/{id}', [ParcelleController::class, 'show']);
Route::post('parcelles', [ParcelleController::class, 'store']); 
Route::post('parcelles/{id}', [ParcelleController::class, 'update']); // 
Route::delete('parcelles/{id}', [ParcelleController::class, 'destroy']); // 

// Route Agents
Route::get('agents', [AgentController::class, 'index']); // 
Route::get('agents/{id}', [AgentController::class, 'show']);
Route::post('agents', [AgentController::class, 'store']); 
Route::post('agents/{id}', [AgentController::class, 'update']); // 
Route::delete('agents/{id}', [AgentController::class, 'destroy']); // 


// Route Culture
Route::get('cultures', [CultureController::class, 'index']); // 
Route::get('cultures/{id}', [CultureController::class, 'show']);
Route::post('cultures', [CultureController::class, 'store']); 
Route::post('cultures/{id}', [CultureController::class, 'update']); // 
Route::delete('cultures/{id}', [CultureController::class, 'destroy']); // 

// Route Admin
Route::get('admins', [AdminController::class, 'index']); // 
Route::get('admins/{id}', [AdminController::class, 'show']);
Route::post('admins', [AdminController::class, 'store']); 
Route::post('admins/{id}', [AdminController::class, 'update']); // 
Route::delete('admins/{id}', [AdminController::class, 'destroy']); // 



Route::post('/parcelle/culture/attach', [ContenirController::class, 'attachCulture']);
Route::post('/parcelle/culture/detach', [ContenirController::class, 'detachCulture']);
Route::get('/parcelle/{parcelle_id}/cultures', [ContenirController::class, 'getCulturesByParcelle']);
Route::get('/culture/{culture_id}/parcelles', [ContenirController::class, 'getParcellesByCulture']);