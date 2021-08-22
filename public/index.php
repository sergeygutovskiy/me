<?php

use \Bramus\Router\Router;
use Jenssegers\Blade\Blade;

use App\Core\DB;
use App\Core\Settings;
use App\Core\View;
use App\Core\Auth;

require_once '../vendor/autoload.php';

require_once '../app/core/DB.php';
require_once '../app/core/Api.php';
require_once '../app/core/View.php';
require_once '../app/core/Model.php';
require_once '../app/core/Settings.php';
require_once '../app/core/Auth.php';
require_once '../app/core/Storage.php';

require_once '../app/models/Note.php';
require_once '../app/models/NoteLink.php';
require_once '../app/models/Project.php';
require_once '../app/models/Setting.php';

// 

session_start();

// 

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '\..');
$dotenv->load();

//

DB::connect(
    $_ENV['MYSQL_HOST'],
    $_ENV['MYSQL_USER'],
    $_ENV['MYSQL_PASSWORD'],
    $_ENV['MYSQL_DB']
);

// 

Settings::init();

// 

Auth::check();

//

View::init( new Blade('../resources/views', 'cache') );

//

$router = new Router();

require_once '../app/routes/web.php';
require_once '../app/routes/api/storage/notes.php';
require_once '../app/routes/api/storage/portfolio.php';
require_once '../app/routes/api/notes.php';
require_once '../app/routes/api/portfolio.php';
require_once '../app/routes/api/settings.php';

$router->run();