<?php

use App\Core\Api;
use App\Models\Note;

/*
 /
 /  Notes: Show
 /   
 */

$router->get('/api/notes/{id}', function(int $id) {
    $note = Note::id($id);

    if ($note === null) {
        echo Api::bad_response();
        return;
    }

    $note->links = $note->links();
    echo Api::good_response( ['note' => $note] );
});

/*
 /
 /  Notes: Index
 /   
 */

$router->get('/api/notes', function() {
    $notes = Note::all();
    echo Api::good_response( ['notes' => $notes] );
});

/*
 /
 /  Notes: Update
 /   
 */

// $router->post('/api/notes/{id}', function(int $id) {
//     $name = $_POST['name'];
//     $description = $_POST['description'];
//     $is_image = $_POST['is_image'];
//     $new_image = isset( $_FILES['new_image'] ) ? $_FILES['new_image'] : null;
    
//     $note = Note::id($id);

//     if ($note === null) 
//     {
//         echo Api::bad_response();
//         return;
//     }

//     if ($new_image) 
//     {
//         if ($note->image_path) $note->delete_image();
//         $note->update_image($new_image);
//     } 
//     else if ($is_image == 'false' && $note->image_path) 
//     {
//         $note->delete_image();
//     }

//     $updated = $note->update([
//         'name' => $name,
//         'description' => $description,
//     ]);

//     if (!$updated) 
//     {
//         echo Api::bad_response();
//         return;
//     }

//     echo Api::good_response();
// });

// /*
//  /
//  /  Notes: Delete
//  /   
//  */

// $router->delete('/api/notes/{id}', function(int $id) {
//     $note = Note::id($id);

//     if ($note === null) 
//     {
//         echo Api::bad_response();
//         return;
//     }

//     if ($note->image_path) $note->delete_image_from_storage();
    

//     if (!$note->delete()) 
//     {
//         echo Api::bad_response();
//         return;
//     }

//     echo Api::good_response();
// });

// /*
//  /
//  /  Notes: New
//  /   
//  */

// $router->post('/api/notes', function() {
//     $name = $_POST['name'];
//     $description = $_POST['description'];
//     $is_image = $_POST['is_image'];
//     $image = isset( $_FILES['image'] ) ? $_FILES['image'] : null;

//     $note = Note::create([
//         'name' => $name,
//         'description' => $description,
//         'image_path' => null,
//     ]);

//     if ($is_image == 'true') $note->update_image($image);

//     echo Api::good_response();
// });
