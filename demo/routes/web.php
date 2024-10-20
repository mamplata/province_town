<?php

use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/address_picker', [AddressController::class, 'showAddressPicker']);
Route::get('/get_cities/{provinceName}', [AddressController::class, 'getCities']);
