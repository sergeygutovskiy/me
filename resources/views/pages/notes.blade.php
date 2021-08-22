@extends('layouts.app')

@section('title', 'Заметки')
    
@section('header')
    <header class="header">
        <h1>Заметки</h1>
        <p class="header__paragraph">
            {{ App\Core\Settings::get('page_notes_text') }}
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