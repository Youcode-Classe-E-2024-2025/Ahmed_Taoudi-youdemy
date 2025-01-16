<?php 

class HomeController extends BaseController
{
    public function index(){
        require_once "app/views/home.php";
    }
    public function courses(){
        require_once "app/views/courses.php";
    }
    

}