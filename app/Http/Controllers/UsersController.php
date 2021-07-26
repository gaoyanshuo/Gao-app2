<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',[
            'except' => ['create','show','store','index','confirmEmail']
        ]);

        $this->middleware('guest',[
           'only' => ['create']
        ]);

        // 限流 一个小时内只能提交 10 次请求；
        $this->middleware('throttle:10,60', [
            'only' => ['store']
        ]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function index()
    {
        $users = User::paginate(6);
        return view('users.index',['users' => $users]);
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
        $this->sendEmailConfirmationTo($user);
        session()->flash('success','新規登録できました、確認メールをチェック上で、ログインして下さい');
        return redirect('/');
    }

    protected function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $from = 'gaoyanshuo9388@yahoo.com';
        $name = 'Gao';
        $to = $user->email;
        $subject = '確認メールをチェックして下さい';

        Mail::send($view,$data,function ($message) use ($from,$name,$to,$subject) {
            $message->from($from,$name)->to($to)->subject($subject);
        });
    }

    public function confirmEmail($token)
    {
        $user = User::where('activation_token',$token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;
        $user->save();
        Auth::login($user);
        session()->flash('success','確認できました');
        return redirect()->route('users.show',[$user]);
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

    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success','削除出来ました');
        return redirect()->back();
    }

}
