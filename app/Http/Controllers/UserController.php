<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function byNameOrEmail($name)
    {
        return User::where('name', 'like', '%'.$name.'%')->orWhere('email', 'like', '%'.$name.'%')->get();
    }
}
