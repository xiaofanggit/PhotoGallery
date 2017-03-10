<?php

/**
 * Created by PhpStorm.
 * Core class to do initialization, load and dispatch
 * User: xiaof
 * Date: 2017-03-9
 * Time: 4:39 PM
 */
class Core
{
    public function __construct()
    {

    }

    public static function run($params)
    {
        self::init();
        self::load();
        self::dispatch($params);

    }

    private static function init()
    {
        session_start();
        //Define main path
        define('DS', DIRECTORY_SEPARATOR);
        define('ROOT', getcwd() . DS . 'www' . DIRECTORY_SEPARATOR);
        //application
        define('CORE', ROOT . 'core' . DS);
        define('CONTROLLER', ROOT . 'controller' . DS);
        define('MODEL', ROOT . 'model' . DS);
        define('VIEW', ROOT . 'view' . DS);
        define('CONFIG', ROOT . 'config' . DS);
        define('ROOT_URL', 'HTTP://'.$_SERVER['HTTP_HOST']);
    }

    private static function load()
    {
        spl_autoload_register(function ($classes) {
            if (file_exists(CORE  . 'helper.class.php')) {
                require_once(CORE . 'helper.class.php');
            }

            if (file_exists(CONTROLLER . $classes . '.php')) {
                require_once(CONTROLLER . $classes . '.php');
            }
            if (file_exists(MODEL . $classes . '.php')) {
                require_once(MODEL . $classes . '.php');
            }
            if (file_exists(VIEW . $classes . '.php')) {
                require_once(VIEW . $classes . '.php');
            }
        });
    }


    private static function dispatch($params)
    {
        //Default controller
        $controller = 'GalleriesController';
        if (!empty($params[0])) {
            //load controller
            $controller = $params[0] . 'Controller';
        }
        if (file_exists(CONTROLLER . $controller . '.php')) {

            require_once CONTROLLER . $controller . '.php';
            $controllerObj = new $controller();
            //params[1] is an action with or without parameters.
            if (!empty($params[1])) {
                $firstParaValues = explode('?', $params[1]);
                $functionName = $firstParaValues[0];
                $requestParam = (!empty($firstParaValues[1])) ? $firstParaValues[1] : array_slice($params, 2);
                $controllerObj->$functionName($requestParam);
            }else{
                $controllerObj->display();
            }
        } else {
            header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
            die("The page $controller NOT found.");
        }

    }
}