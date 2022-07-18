<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $req)
    {
        $req->request->add(['username' => Str::slug($req->username)]);

        $this->validate($req,  [
            "username" => ['required', 'unique:users,username,' . auth()->user()->id, 'min:3', 'max:20']
        ]);
        if ($req->imagen) {
            $imagen = $req->file('imagen');
            $nombreImagen = Str::uuid() . "." .  $imagen->extension();
            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000, 1000);
            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
            $imagenServidor->save($imagenPath);
        }

        $usuario = User::find(auth()->user()->id);
        $usuario->username = $req->username;
        $usuario->imagen =  $nombreImagen ?? auth()->user()->imagen ?? '';
        $usuario->save();

        return redirect()->route('post.index', $usuario->username);
    }
}
