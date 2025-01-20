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
$router->register('/course', 'HomeController', 'courseDetails');

// admin pages

$router->register('/admin/courses', 'AdminController', 'courses');
$router->register('/admin/tags', 'AdminController', 'tags');
$router->register('/admin/statistics', 'AdminController', 'statistics');
$router->register('/admin/users', 'AdminController', 'users');
$router->register('/admin/categories', 'AdminController', 'categories');


// teacher pages 

$router->register('/teacher/courses', 'TeacherController', 'courses');
$router->register('/teacher/course/add', 'TeacherController', 'add');
$router->register('/teacher/course/create', 'CourseController', 'create');
$router->register('/teacher/course/edit', 'CourseController', 'edit');
$router->register('/teacher/course/delete', 'TeacherController', 'delete');



$router->register('/admin/category/create', 'CategoryController', 'create');
$router->register('/admin/category/edit', 'CategoryController', 'edit');
$router->register('/admin/category/delete', 'CategoryController', 'delete');

$router->register('/admin/tag/create', 'TagController', 'create');
$router->register('/admin/tag/edit', 'TagController', 'edit');
$router->register('/admin/tag/delete', 'TagController', 'delete');

$router->register('/admin/user/create', 'AdminController', 'create');
$router->register('/admin/user/update-status', 'AdminController', 'updateStatus');



$router->register('/student/my-courses', 'StudentController', 'myCourses');
$router->register('/student/courses', 'StudentController', 'courses');


$router->register('/enroll', 'CourseController', 'enroll');



