<?php
// Directory Paths
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
defined('SITE_ROOT') ? null : define('SITE_ROOT', $_SERVER['DOCUMENT_ROOT'] . DS . 'oop' . DS . 'oop-galleryproject');
defined('INCLUDES_PATH') ? null : define('INCLUDES_PATH', SITE_ROOT . DS . 'admin' . DS . 'includes');


// Functions
require_once "functions.php";

// Database
require_once "config.php";

// Classes
require_once "database.php";
require_once "db_object.php";
require_once "user.php";
require_once "session.php";
require_once "photo.php";
require_once "comment.php";
require_once "pagination.php";
