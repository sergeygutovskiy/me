<?php

use App\Core\Api;
use App\Models\Project;

// Show

$router->get('/api/portfolio/{id}', function(int $id) {
    $project = Project::id($id);

    if ($project === null) {
        echo Api::bad_response();
        return;
    }

    echo Api::good_response( ['project' => $project] );
});

// Index

$router->get('/api/portfolio/', function() {
    $projects = Project::all();
    echo Api::good_response( ['projects' => $projects] );
});

// Store

$router->post('/api/portfolio', function() {
    $postData = file_get_contents('php://input');
    $data = json_decode($postData, true);

    $project = Project::create([
        'name' => $data['name'],
        'description' => $data['description'],
        'link' => $data['link'],
        'source_link' => $data['source_link'],
        'pc_image_path' => $data['pc_image_path'] ? 
            '/images/storage/portfolio/' . $data['pc_image_path'] 
            : null,
        'mobile_image_path' => $data['mobile_image_path'] ? 
            '/images/storage/portfolio/' . $data['mobile_image_path'] 
            : null,
    ]);

    echo Api::good_response();
});

// Update

$router->post('/api/portfolio/{id}', function(int $id) {    
    $project = Project::id($id);

    if ($project === null) 
    {
        echo Api::bad_response();
        return;
    }

    $postData = file_get_contents('php://input');
    $data = json_decode($postData, true);

    $updated = $project->update([
        'name' => $data['name'],
        'description' => $data['description'],
        'link' => $data['link'],
        'source_link' => $data['source_link'],
        'pc_image_path' => $data['pc_image_path'] ? 
            '/images/storage/portfolio/' . $data['pc_image_path'] 
            : null,
        'mobile_image_path' => $data['mobile_image_path'] ? 
            '/images/storage/portfolio/' . $data['mobile_image_path'] 
            : null,
    ]);

    if (!$updated) 
    {
        echo Api::bad_response();
        return;
    }

    echo Api::good_response();
});

// Delete

$router->delete('/api/portfolio/{id}', function(int $id) {
    $project = Project::id($id);

    if ($project === null) 
    {
        echo Api::bad_response();
        return;
    }

    if (!$project->delete()) 
    {
        echo Api::bad_response();
        return;
    }

    echo Api::good_response();
});