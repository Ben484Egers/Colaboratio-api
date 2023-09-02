<?php

// header('Access-Control-Allow-Origin: http://localhost:3000');
// header('Access-Control-Allow-Methods : POST, GET, OPTIONS, PUT, DELETE, HEAD');
// header('Allow: POST, GET, OPTIONS, PUT, DELETE, HEAD');
// header('Access-Control-Allow-Headers : X-Requested-With, Content-Type');

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ResourcesController;
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
Route::post('/users/register', [AuthController::class, 'store']);

Route::get('/hello', function () {
    return 'Hello world';
});


//Login/ Authenticate User
Route::post('/users/authenticate', [AuthController::class, 'authenticate'])->name('login');



// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    
    Route::get('/users/check', [AuthController::class, 'check']);
    
    //User routes
    //Get all users
    Route::get('/users', [UserController::class, 'index']);

    //Get one user
    Route::get('/users/{id}', [UserController::class, 'show']);

    //Get info loggedin user
    Route::get('/user/info', [AuthController::class, 'info']);
    
    //Project routes
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

    //Get all tasks
    Route::get('/tasks/all', [TaskController::class, 'all']);

    //Create new task
    Route::post('/tasks', [TaskController::class, 'store']);

    //Get single task
    Route::get('/tasks/{id}', [TaskController::class, 'show']);

    //Get all tasks of project
    Route::get('/project/{id}/tasks', [TaskController::class, 'projectTasks']);

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
