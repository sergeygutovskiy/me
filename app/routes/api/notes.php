<?php

use App\Core\Api;
use App\Models\Note;
use App\Models\NoteLink;

// Links: Index

$router->get('/api/notes/{id}/links', function(int $id) {
    $note = Note::id($id);

    if ($note === null) {
        echo Api::bad_response();
        return;
    }

    echo Api::good_response( ['links' => $note->links()] );
});

// Links: Store

$router->post('/api/notes/{id}/links', function(int $id) {
    $postData = file_get_contents('php://input');
    $data = json_decode($postData, true);

    $link = NoteLink::create([
        'note_id' => $id,
        'link' => $data['link'],
        'text' => $data['text'],
    ]);

    echo Api::good_response();
});

// Links: Update

$router->post('/api/notes/{id}/links/{id}', function(int $note_id, int $link_id) {    
    $link = NoteLink::id($link_id);

    if ($link === null) 
    {
        echo Api::bad_response();
        return;
    }

    $postData = file_get_contents('php://input');
    $data = json_decode($postData, true);

    $updated = $link->update([
        'link' => $data['link'],
        'text' => $data['text'],
    ]);

    if (!$updated) 
    {
        echo Api::bad_response();
        return;
    }

    echo Api::good_response();
});

// Links: Delete

$router->delete('/api/notes/{id}/links/{id}', function(int $note_id, int $link_id) {
    $link = NoteLink::id($link_id);

    if ($link === null) 
    {
        echo Api::bad_response();
        return;
    }

    if (!$link->delete()) 
    {
        echo Api::bad_response();
        return;
    }

    echo Api::good_response();
});





// Show

$router->get('/api/notes/{id}', function(int $id) {
    $note = Note::id($id);

    if ($note === null) {
        echo Api::bad_response();
        return;
    }

    $note->links = $note->links();
    echo Api::good_response( ['note' => $note] );
});

// Index

$router->get('/api/notes', function() {
    $notes = Note::all();
    echo Api::good_response( ['notes' => $notes] );
});

// Store

$router->post('/api/notes', function() {
    $postData = file_get_contents('php://input');
    $data = json_decode($postData, true);

    $note = Note::create([
        'name' => $data['name'],
        'description' => $data['description'],
    ]);

    echo Api::good_response();
});

// Update

$router->post('/api/notes/{id}', function(int $id) {    
    $note = Note::id($id);

    if ($note === null) 
    {
        echo Api::bad_response();
        return;
    }

    $postData = file_get_contents('php://input');
    $data = json_decode($postData, true);

    $updated = $note->update([
        'name' => $data['name'],
        'description' => $data['description'],
        'image_path' => $data['image_path']? '/images/storage/notes/' . $data['image_path'] : null,
    ]);

    if (!$updated) 
    {
        echo Api::bad_response();
        return;
    }

    echo Api::good_response();
});

// Delete

$router->delete('/api/notes/{id}', function(int $id) {
    $note = Note::id($id);

    if ($note === null) 
    {
        echo Api::bad_response();
        return;
    }

    if (!$note->delete()) 
    {
        echo Api::bad_response();
        return;
    }

    echo Api::good_response();
});