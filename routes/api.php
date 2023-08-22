<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ResourcesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Public routes

//Register User
Route::post('/users', [AuthController::class, 'store']);

//Login/ Authenticate User
Route::post('/users/authenticate', [AuthController::class, 'authenticate'])->name('login');


// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    
    //Project routes

    //User routes
    //Get all users
    Route::get('/users', [UserController::class, 'index']);

    //Show all projects.
    Route::get('/projects', [ProjectController::class, 'index']);

    //Create new project
    Route::post('/projects', [ProjectController::class, 'store']);

    //Get a single project
    Route::get('/projects/{id}', [ProjectController::class, 'show']);

    //Update project
    Route::put('/projects/{id}', [ProjectController::class, 'update']);

    //Delete project
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);
    
    //Task routes
    //Get all tasks of signed in user
    Route::get('/tasks', [TaskController::class, 'index']);

    //Create new task
    Route::post('/tasks', [TaskController::class, 'store']);

    //Get single task
    Route::get('/tasks/{id}', [TaskController::class, 'show']);

    //Update task
    Route::put('/tasks/{id}', [TaskController::class, 'update']);

    //Delete task
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);

    //Resources routes
    //Get resources of single project
    Route::get('/resources/{project_id}', [ResourcesController::class, 'index']);
    
    //Create new resource
    Route::post('/resources', [ResourcesController::class, 'store']);
    
    //Get single resource
    Route::get('/resource/{id}', [ResourcesController::class, 'show']);
    
    //Delete resource
    Route::delete('/resources/{id}', [ResourcesController::class, 'destroy']);
    
    //Search for term matching various criteria
    Route::get('/projects/search/{term}', [ProjectController::class, 'search']);
    Route::get('/tasks/search/{term}', [TaskController::class, 'search']);
    
    //Log user out
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
