<?php

use App\Core\Api;
use App\Core\Storage;

// Index

$router->get('/api/files/portfolio', function() {
    $files = Storage::get('portfolio');

    echo Api::good_response([
        'files' => $files
    ]);
});

// Store

$router->post('/api/files/portfolio', function() {
    $saved = Storage::save($_FILES['file'], 'portfolio');

    if (!$saved)
    {
        echo Api::bad_response();
        return;
    }

    echo Api::good_response();
});

// Delete

$router->delete('/api/files/portfolio', function() {
    $postData = file_get_contents('php://input');
    $data = json_decode($postData, true);

    $deleted = Storage::delete('portfolio', $data['name']);

    if (!$deleted)
    {
        echo Api::bad_response();
        return;
    }

    echo Api::good_response();
});