<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserController extends Controller
{
    public function byNameOrEmail($name)
    {
        return
        User::where('id', '<>', Auth::id())
        ->where(function ($query) use ($name) {
            $query->where('name', 'like', '%'.$name.'%')
                  ->orWhere('email', 'like', '%'.$name.'%');
        })->get();
    }
}
