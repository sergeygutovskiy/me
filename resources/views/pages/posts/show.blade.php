@extends('layouts.app')

@section('title', $post->title)
    
@section('header')
    <header class="header">
        <h1>{{ $post->title }}</h1>
        <p class="header__paragraph">
            {{ $post->description }}
        </p>
    </header>
@endsection

@section('content')
    <section class="post-viewer">
        <article class="post-viewer__content">
            {!! $post->body !!}
        </article>
    </section>
@endsection