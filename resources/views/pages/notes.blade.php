@extends('layouts.app')

@section('title', 'Заметки')
    
@section('header')
    <header class="header">
        <h1>Заметки</h1>
        <p class="header__paragraph">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. 
            Voluptas natus laboriosam a rerum facere maiores nobis dolor, alias praesentium qui incidunt 
            vitae eius ratione sit maxime nemo quas. Nulla, voluptatem!
        </p>
    </header>
@endsection

@section('content')
    <section class="container">
        <div class="notes-list">
            @foreach ($notes as $note)
            <button class="notes-list__item" data-note-id="{{ $note->id }}">
                {{ $note->name }}
            </button>
            @endforeach
        </div>
    </section>
@endsection