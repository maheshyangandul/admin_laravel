<?php

use App\Http\Controllers\admincontroller;
use App\Http\Controllers\availabilitycontroller;
use App\Http\Controllers\billingcontroller;
use App\Http\Controllers\bookingcontroller;
use App\Http\Controllers\categorycontroller;
use App\Http\Controllers\hotel_admincontroller;
use App\Http\Controllers\hotelcontroller;
use App\Http\Controllers\vendorcontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserrolesController;
use App\Http\Controllers\HoteSectorController;
use App\Http\Controllers\RoomController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::middleware('auth-sanctum')->group(function(){
//       Route::apiResource('user_roles',UserrolesController::class);
// });

// Route::middleware('auth:sanctum')->get('/user_roles', function (Request $request) {
//     return $request->user();
//     //Route::apiResource('user_roles',UserrolesController::class);
// });
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('category', categorycontroller::class);
    Route::apiResource('vendor', vendorcontroller::class);
    Route::apiResource('hotel_admin', hotel_admincontroller::class);
    Route::apiResource('hotel_sector', HoteSectorController::class);
    Route::apiResource('room', RoomController::class);
    Route::apiResource('hotel', hotelcontroller::class);
});

// Route::post('loginadmin',[admincontroller::class,'logincheck']);
Route::post('register', [admincontroller::class, 'store_register']);
Route::apiResource('availability', availabilitycontroller::class);
Route::apiResource('booking', bookingcontroller::class);
Route::apiResource('bill', billingcontroller::class);
Route::apiResource('user_roles', UserrolesController::class);

Route::get('hotelget', [hotelcontroller::class, 'index']);
Route::get('hotelgetroom/{id}', [hotelcontroller::class, 'show']);

Route::get('hotelsectorget', [hotelcontroller::class, 'hotelsectorget']);
Route::get('hotelsectorgetid', [RoomController::class, 'hotelsectorgetid']);
Route::get('hotelgetid', [RoomController::class, 'hotelgetid']);
Route::get('roomtypegetid/{id}', [RoomController::class, 'roomtypegetid']);
Route::get('hotelid', [hotel_admincontroller::class, 'hotelid']);
Route::get('vendorid', [hotel_admincontroller::class, 'vendorid']);
Route::get('hotelrooms/{id}', [hotelcontroller::class, 'hotelrooms']);

Route::get('searchHotels', [hotelcontroller::class, 'searchHotels']);

Route::post('login', [admincontroller::class, 'login']);
Route::post('logout', [admincontroller::class, 'logout']);

Route::post('searchdata',[hotelcontroller::class,'searchdata']);
Route::get('view_booking',[bookingcontroller::class,'view_booking']);
