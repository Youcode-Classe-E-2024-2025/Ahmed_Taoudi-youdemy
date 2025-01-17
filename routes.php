<?php

$router->register('/login', 'AuthController', 'login');
$router->register('/logout', 'AuthController', 'logout');
$router->register('/register', 'AuthController', 'register');

// dashboard 
$router->register('/admin/dashboard', 'AdminController', 'index');

$router->register('/teacher/dashboard', 'TeacherController', 'index');

$router->register('/student/dashboard', 'StudentController', 'index');


$router->register('/', 'HomeController', 'index');
$router->register('/courses', 'HomeController', 'courses');

// admin pages

$router->register('/admin/courses', 'AdminController', 'courses');
$router->register('/admin/tags', 'AdminController', 'tags');
$router->register('/admin/statistics', 'AdminController', 'statistics');
$router->register('/admin/users', 'AdminController', 'users');
$router->register('/admin/categories', 'AdminController', 'categories');



