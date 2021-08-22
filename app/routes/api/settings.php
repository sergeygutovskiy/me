<?php

use App\Core\Api;
use App\Core\Settings;
use App\Models\Setting;

// Index

$router->get('/api/settings', function() {
    $settings = Settings::all();

    echo Api::good_response( ['settings' => array_values($settings)] );
});

// Update

$router->post('/api/settings/{id}', function($id) {
    $setting = Setting::id($id);

    if ($setting === null) 
    {
        echo Api::bad_response();
        return;
    }

    $postData = file_get_contents('php://input');
    $data = json_decode($postData, true);
    
    $updated = $setting->update([
        'value' => $data['value'],
    ]);

    if (!$updated) 
    {
        echo Api::bad_response();
        return;
    }

    echo Api::good_response();
});