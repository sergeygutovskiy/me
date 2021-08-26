@extends('layouts.app')

@section('title', 'Для разработчиков')
    
@section('header')
    <?php use App\Core\Settings; ?>

    <header class="header">
        <h1>Для разработчиков</h1>
        <p class="header__paragraph">
            {!! Settings::get('page_for_developers_text') !!}
        </p>
    </header>
@endsection

@section('content')
    <section class="container">
        <div class="for-developers-posts">
            @foreach ($posts as $post)                
                <article class="post" style="--background-image: url('{{ $post->preview_image_path }}')">
                    <a class="post__content" href="/posts/{{ $post->slug }}">
                        <h2 class="post__title">
                            {{ $post->title }}
                        </h2>
                    </a>
                </article>
            @endforeach
        </div>
    </section>
@endsection