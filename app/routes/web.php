<?php

use App\Core\Auth;
use App\Core\View;
use App\Models\Note;
use App\Models\Project;

$router->get('/', function() {
    View::render('pages.home');
});

$router->get('/notes', function() {
    $notes = Note::all();
    
    View::render('pages.notes', [
        'notes' => $notes
    ]);
});

$router->get('/portfolio', function() {
    $projects = Project::all();
    
    View::render('pages.portfolio', [
        'projects' => $projects
    ]);
});

$router->get('/login', function() {
    if (Auth::is_auth())
    {
        header('Location: /admin');
        return;
    }
    
    View::render('pages.login');
});

$router->post('/login', function() {
    $password = $_POST['password'];

    if ( Auth::login($password) ) {
        header('Location: /admin');
        return;
    }

    View::render('pages.login');
});

$router->get('/admin.*', function() {
    if (Auth::is_quest())
    {
        header('Location: /login');
        return;
    }

    View::render('pages.admin');
});