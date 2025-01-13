<?php 

class Debug
{

public static function dd($element){
    echo "<pre>";
    var_dump($element);
    echo "</pre>";
    die();

}

public static function pd($element){
    echo "<pre>";
    print_r($element);
    echo "</pre>";
    die();

}
public static function echoo($element){
    echo "<pre>";
    echo $element ;
    echo "</pre>";
    die();

}
}