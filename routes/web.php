<?php

use Illuminate\Support\Facades\Route;
use App\Models\Course;
use App\Models\Registration;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\CourseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::get('/', [CourseController::class, 'index']);
Route::post('/register/{course}', [CourseController::class, 'register']);