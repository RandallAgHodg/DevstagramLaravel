<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function store(Request $req, User $user, Post $post)
    {
        $this->validate($req, [
            'comentario' => 'required|max:255'
        ]);

        Comentario::create(
            [
                'comentario' => $req->comentario,
                'post_id' => $post->id,
                'user_id' => auth()->user()->id
            ]
        );

        return back()->with('mensaje', 'Comentario Realizado Correctamente');
    }
}
