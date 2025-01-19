<?php 

class Debug
{

public static function dd(...$elements){
    foreach($elements as $element){
        echo "<pre>";
        var_dump($element);
        echo "</pre>";
        echo "<br>-------------------------------------------------<br>";
    }
    die();

}

public static function pd(...$elements){
    foreach($elements as $element){
        echo "<pre>";
        print_r($element);
        echo "</pre>";
        echo "<br>-------------------------------------------------<br>";
    }
    die();

}
public static function echoo($element){
    echo "<pre>";
    echo $element ;
    echo "</pre>";
    die();

}
}