<?php

namespace App\Models;
use App\Core\Model;

class Note extends Model 
{
    public static string $table = 'notes';
    private string $storage_path;

    function __construct() 
    {
        $this->storage_path = '/public/storage/notes/';
    }

    public function links() 
    {
        return NoteLink::foreign_children('note_id', $this->id); 
    }

    public function update_image(array $file) : bool 
    {    
        $name = $this->id . '-' . basename($file['name']);

        $this->save_image_to_storage($file, $name);

        return $this->update([
            'image_path' => $this->storage_path . $name,
        ]);
    }

    public function delete_image() : bool 
    {
        $this->delete_image_from_storage();

        return $this->update([
            'image_path' => null
        ]);
    }

    public function save_image_to_storage($file, string $name) : bool 
    {
        return move_uploaded_file(
            $file['tmp_name'], 
            $_SERVER['DOCUMENT_ROOT'] . $this->storage_path . $name
        );
    }

    public function delete_image_from_storage() : bool 
    {
        return unlink(
            $_SERVER['DOCUMENT_ROOT'] . $this->image_path
        );
    }
}
