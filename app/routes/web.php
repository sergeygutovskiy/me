<?php

use App\Core\Auth;
use App\Core\View;
use App\Models\Note;
use App\Models\Project;
use App\Models\Post;

$router->get('/', function() {
    View::render('pages.home', [
        'route' => $_SERVER["REQUEST_URI"],
    ]);
});

$router->get('/notes', function() {
    $notes = Note::all();
    
    usort($notes, array( 'App\Models\Note', 'sort_by_created_at_date') );

    View::render('pages.notes', [
        'notes' => $notes,
        'route' => $_SERVER["REQUEST_URI"],
    ]);
});

$router->get('/portfolio', function() {
    $projects = Project::all();
    
    usort($projects, array( 'App\Models\Project', 'sort_by_published_at_date') );

    View::render('pages.portfolio', [
        'projects' => $projects,
        'route' => $_SERVER["REQUEST_URI"],
    ]);
});

$router->get('/for-developers', function() {
    $posts = Post::all();
    
    View::render('pages.for-developers', [
        'posts' => $posts,
        'route' => $_SERVER["REQUEST_URI"],
    ]);
});


$router->get('/posts/{key}', function(string $key) {
    if (is_numeric($key)) 
        $post = Post::id($key);
    else 
        $post = Post::slug($key);
    
    if ($post === null) return;

    View::render('pages.posts.show', [
        'post' => $post,
        'route' => $_SERVER["REQUEST_URI"],
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