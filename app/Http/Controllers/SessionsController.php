<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $credentials = $this->validate($request,[
            'email' => 'email|required|max:255',
            'password' => 'required'
        ]);
        if (Auth::attempt($credentials)) {
            session()->flash('success','ようこそ');
            return redirect()->route('users.show',[Auth::user()]);
        } else {
            session()->flash('danger','メールアドレスまたパスワードが一致しません');
            return redirect()->back()->withInput();
        }
    }

    public function logout()
    {
        Auth::logout();
        session()->flash('success','ログアウトできました');
        return redirect()->route('login');
    }
}
