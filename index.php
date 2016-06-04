<?php
    ob_start();
    session_start();
    ini_set("display_errors", 1);
    ini_set("memory_limit",-1);

    define('__APPLICATION_PATH',(__DIR__));
    define('__APPLICATION_FOLDER_VIEW', 'Applications/View');
    define('__APPLICATION_FOLDER_MODEL', 'Applications/Model');
    define('__APPLICATION_FOLDER_CONTROLLER', 'Applications/Controller');


    require_once "Spry/Spry.Configure.php";

    require_once "Public/layout.php";