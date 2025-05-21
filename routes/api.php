<?php

// use App\Http\Controllers\AuthController;
// use App\Http\Controllers\AdminController;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;

// /*
// |--------------------------------------------------------------------------
// | API Routes
// |--------------------------------------------------------------------------
// |
// | Here is where you can register API routes for your application. These
// | routes are loaded by the RouteServiceProvider and all of them will
// | be assigned to the "api" middleware group. Make something great!
// |
// */

// Route::group(["prefix"=> "public"], function () {
//     Route::post("/registration",[AuthController::class ,"register"]);
//     Route::post("/login",[AuthController::class ,"login"]);

// });

// Route::group(["prefix"=> "protected"], function () {
//     // Route::post("/registration",[AuthController::class ,"register"]);
//      Route::get("/getprofile",[AuthController::class ,"getprofile"]);
//      Route::post("/updateprofile",[AuthController::class ,"updateprofile"]);

// });


// Route::middleware(['auth:sanctum', 'is_admin','prefix' => 'private'])->group(function () {
//     Route::post('/add_category', [AdminController::class, 'insert']);
//     Route::put('/update_category/{id}', [AdminController::class, 'update']);
//     Route::get('/get_all_category', [AdminController::class, 'fetchall']);
//     Route::delete('/delete_category/{id}', [AdminController::class, 'delete']);
// });

// // Route::group(["prefix"=> ""], function () {
// //     Route::post("/registration",[AuthController::class ,"register"]);

// // });

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });








use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| API route definitions.
|
*/

// Public routes
Route::group(["prefix" => "public"], function () {
    Route::post("/registration", [AuthController::class, "register"]);
    Route::post("/login", [AuthController::class, "login"])->name('login');
});

// Protected routes (logged-in users)
Route::group(["prefix" => "protected", "middleware" => ['jwt.auth']], function () {
    Route::get("/getprofile", [AuthController::class, "getprofile"]);
    Route::post("/updateprofile", [AuthController::class, "updateprofile"]);
    Route::post("/createpost", [PostController::class, "create_post"]);
    Route::put("/updatepost", [PostController::class, "update_post"]);
    Route::delete("/deletepost", [PostController::class, "delete_post"]);
    Route::get("/getallpost", [PostController::class, "get_post"]);
});

// Admin-only private routes
Route::group(['prefix' => 'private', 'middleware' => ['is_admin', 'jwt.auth']], function () {
    Route::post('/add_category', [AdminController::class, 'insert']);
    Route::put('/update_category/{id}', [AdminController::class, 'update']);
    Route::get('/get_all_category', [AdminController::class, 'fetchall']);
    Route::delete('/delete_category/{id}', [AdminController::class, 'delete']);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
