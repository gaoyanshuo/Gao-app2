<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',[
            'except' => ['create','show','store']
        ]);

        $this->middleware('guest',[
           'only' => ['create']
        ]);
    }

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
            'name' => 'required|unique:users|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);
        $user = new User();
        $user->name = $request->post('name');
        $user->email = $request->post('email');
        $user->password = bcrypt($request->post('password'));
        $user->save();
        Auth::login($user);
        session()->flash('success','新規登録できました');
        return redirect()->route('users.show',['user' => $user]);
    }

    public function edit(User $user)
    {
        $this->authorize('update',$user);
        return view('users.edit',['user' => $user]);
    }

    public function update(User $user,Request $request)
    {
        $this->authorize('update',$user);
        $this->validate($request,[
            'name' => 'required|min:3|max:50',
            'password' => 'nullable|confirmed|min:6'
            ]);

        $data = [];
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $data['name'] = $request->name;
        $user->update($data);
        session()->flash('success','更新できました');
        return redirect()->route('users.show',[$user->id]);
    }
}
