<?php
session_start();

require_once "core/Debug.php";
require_once "core/Router.php";
require_once "core/Database.php";
require_once "core/Security.php";
require_once 'core/Validator.php';

require_once 'app/controllers/BaseController.php';

require_once "app/enums/Role.php";
require_once "app/enums/UserStatus.php";

require_once "app/interfaces/UserCourses.php";

require_once "app/models/Course.php";
require_once "app/models/Teacher.php";
require_once "app/models/Student.php";
require_once "app/models/Category.php";
require_once "app/models/Tag.php";
require_once "app/models/File.php";
require_once "app/models/User.php";


// CSRF
Security::generateCSRFToken();
// $password="Password123";
// Debug::dd(password_hash($password, PASSWORD_BCRYPT));
// $db = Database::getInstance();
// 

if(isset($_POST['createdb'])){ 

    if(isset($_POST['checkbox']) && $_POST['checkbox'] == 'on' ){
        Database::createDatabase(DBNAME,true);
        // dd(33);
    }else{
        Database::createDatabase(DBNAME,false);
        // dd(22);
    }
    
}

$router = new Router();

require "routes.php";

$router->resolve($_SERVER['REQUEST_URI']);
