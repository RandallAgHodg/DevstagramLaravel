<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $req)
    {
        $req->request->add(['username' => Str::slug($req->username)]);
        $this->validate($req, [
            'name' => 'required|max:30',
            'username' => "required|unique:users|min:3|max:20",
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|confirmed|min:6'
        ]);
        User::create([
            'name' => $req->name,
            'username' => $req->username,
            'email' => $req->email,
            'password' => Hash::make($req->password)
        ]);

        auth()->attempt([
            'email' => $req->email,
            'password' => $req->password
        ]);

        return redirect()->route('post.index', auth()->user());
    }
}
