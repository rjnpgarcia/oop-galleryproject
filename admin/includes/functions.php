<?php

// Safety Net - load class definitions that may not have been included
function classAutoloader($class)
{
    $class = strtolower($class);
    $path = "includes/$class.php";
    if (is_file($path) && !class_exists($class)) {
        include $path;
    }
}
spl_autoload_register('classAutoloader');

// Redirect to location
function redirect($location)
{
    header("Location: $location");
}
