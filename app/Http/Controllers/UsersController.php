<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function create()
    {
        return view('users.create');
    }

    public function show(User $user)
    {
        return view('users.show',[
            'user' => $user
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required | unique:users | min:3 |max:50',
            'email' => 'email | required | unique:email |max:255',
            'password' => 'min:6 | required | confirmed',
        ]);
        return;
    }
}
