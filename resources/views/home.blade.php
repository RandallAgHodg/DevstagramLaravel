@extends('layouts.app')

@section('titulo')
Pagina Principal
@endsection

@section('contenido')
@forelse ($posts as $post)
<div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @foreach ($posts as $post)
    <div class="">
        <a href="{{ route('post.show', ['user' => $post->user, 'post' => $post ]) }}">
            <img src="{{ asset('uploads').'/'.$post->imagen }}" alt="Imagen del post {{ $post->titulo }}" />
        </a>
    </div>
    @endforeach
</div>
@empty
<p class="text-center">No Hay Posts, sigue a alguien para poder mostrar sus posts</p>
@endforelse
@endsection