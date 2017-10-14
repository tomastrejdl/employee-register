<?php

namespace Evizam;

class Router {

     public static $validRoutes = array();

     public static function set($route, $function, $view) {
        self::$validRoutes[] = $route;

        if ($_GET['url'] == $route) 
            $function->__invoke($view);
     }
    
}

?>