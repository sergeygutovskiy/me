<?php

use App\Core\Api;
use App\Models\Post;

// Show

$router->get('/api/posts/{key}', function(string $key) {
    if (is_numeric($key)) {
        $post = Post::id($key);
    } else {
        $post = Post::slug($key);
    }
    
    if ($post === null) {
        echo Api::bad_response();
    }

    echo Api::good_response( ['post' => $post] );
});

// Index

$router->get('/api/posts', function() {
    $posts = Post::all();
    echo Api::good_response( ['posts' => $posts] );
});

// Store

$router->post('/api/posts', function() {
    $postData = file_get_contents('php://input');
    $data = json_decode($postData, true);

    $note = Post::create([
        'title' => $data['title'],
        'description' => $data['description'],
        'body' => $data['body']
    ]);

    echo Api::good_response();
});

// Links: Update

$router->post('/api/posts/{id}', function(int $id) {    
    $post = Post::id($id);

    if ($post === null) 
    {
        echo Api::bad_response();
        return;
    }

    $postData = file_get_contents('php://input');
    $data = json_decode($postData, true);

    $updated = $post->update([
        'title' => $data['title'],
        'slug' => $data['slug'],
        'description' => $data['description'],
        'body' => $data['body']
    ]);

    if (!$updated) 
    {
        echo Api::bad_response();
        return;
    }

    echo Api::good_response();
});