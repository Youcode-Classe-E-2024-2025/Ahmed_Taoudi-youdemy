<?php

$router->register('/login', 'AuthController', 'login');
$router->register('/logout', 'AuthController', 'logout');
$router->register('/register', 'AuthController', 'register');