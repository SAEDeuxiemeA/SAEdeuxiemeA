<?php

Class autoloader{
    public static  function register(){
        spl_autoload_register(function($class) {
            $file = __DIR__ . '/application/' . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
            if (file_exists($file)) {
                require $file;
                return true;
            }
            return false;
        });
    }
}