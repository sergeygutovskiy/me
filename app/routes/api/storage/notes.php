<?php

use App\Core\Api;
use App\Core\Storage;

// Index

$router->get('/api/files/notes', function() {
    $files = Storage::get('notes');

    echo Api::good_response([
        'files' => $files
    ]);
});

// Store

$router->post('/api/files/notes', function() {
    $saved = Storage::save($_FILES['file'], 'notes');

    if (!$saved)
    {
        echo Api::bad_response();
        return;
    }

    echo Api::good_response();
});

// Delete

$router->delete('/api/files/notes', function() {
    $postData = file_get_contents('php://input');
    $data = json_decode($postData, true);

    $deleted = Storage::delete('notes', $data['name']);

    if (!$deleted)
    {
        echo Api::bad_response();
        return;
    }

    echo Api::good_response();
});