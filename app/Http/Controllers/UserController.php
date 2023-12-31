<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{

    // Show all users
    public function index() {
        return User::all();
    }
    public function show($id) {
        return User::find($id);;
    }
}
