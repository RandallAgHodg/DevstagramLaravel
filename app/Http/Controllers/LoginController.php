<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $req)
    {
        $this->validate($req, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);


        if (!auth()->attempt($req->only('email', 'password'), $req->remember)) {
            return back()->with('mensaje', 'Credenciales Incorrectas');
        }

        return redirect()->route('post.index', auth()->user()->username);
    }
}
