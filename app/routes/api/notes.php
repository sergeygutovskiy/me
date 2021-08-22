<?php

use App\Core\Api;
use App\Models\Note;

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