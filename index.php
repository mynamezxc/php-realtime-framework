<?php
    date_default_timezone_set("Asia/Ho_Chi_Minh");
    $actualLink = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    /* DEFINED ENVIROMENT ZXC */
    /*
        Define ENVIROMENT to help you check an error code with value development
        and disabled show error when ENVIROMENT = production
    */
    define('ENVIRONMENT', 'development');
    switch (ENVIRONMENT)
    {
        case 'development':
            error_reporting(-1);
            ini_set('display_errors', 1);
        break;

        case 'testing':
        case 'production':
            ini_set('display_errors', 0);
            if (version_compare(PHP_VERSION, '5.3', '>='))
            {
                error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
            }
            else
            {
                error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
            }
        break;

        default:
            header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
            echo 'The application environment is not set correctly.';
            exit(1);
    }
    /*
        each $_SERVER['path']'s element is a default folder to config,
        the real folder is $_SERVER['path']'s element remove `Folder`
        please change the path if you was changed one of each.
        WARNING: default folder value is not using `/` just like
        a folder named you see
    */
    $_SERVER['path'] = [
        "applicationFolder" => "application",
        "controllerFolder"  => "controllers",
        "modelFolder"       => "models",
        "viewFolder"        => "views",
        "libraryFolder"     => "libraries",
        "helperFolder"      => "helper",
        "diskFolder"        => "disk",
        "baseUrl"           => "http://framework.test",
        "indexPath"         => "/"
    ];

    define('APPPATH', $_SERVER['path']['applicationFolder']);
    define('EXT', '.php');

    require_once(APPPATH . '/config/config' . EXT);
    require_once(APPPATH . '/config/database' . EXT);
    require_once(APPPATH . '/core/ZXC_controller' . EXT);
    require_once(APPPATH . '/core/ZXC_model' . EXT);

    $config = new config($_SERVER['path']);
    define("SEGMENTS", indexPath !== "/" ? str_replace(indexPath , "", $_SERVER['REQUEST_URI']) : $_SERVER['REQUEST_URI']);
    $temp = explode("/", SEGMENTS);

    $temp_controller = isset($temp[0]) && $temp[0] != "" ? $temp[0] : null;
    $temp_controller = isset($temp[0]) && isset($temp[1]) && $temp[0] == "" ? $temp[1] : $temp_controller;
    $temp_method     = isset($temp[1]) ? $temp[1] : "index";
    $temp_method     = isset($temp[2]) && $temp[0] == "" ? $temp[2] : $temp_method;

    require_once(APPPATH . '/config/route.php');

    $temp_route_result = isset($routes[$temp_controller]) && $temp_controller !== null ? $routes[$temp_controller] : $temp_controller;
    $temp = explode("/", $temp_route_result);

    $temp_controller = isset($temp[0]) && $temp[0] != "" ? $temp[0] : $config->default_controller;
    $temp_method     = isset($temp[1]) ? $temp[1] : $temp_method;

    defined('CONTROLLER') OR define('CONTROLLER', $temp_controller);
    if(!empty($temp_method)) {
        $method = $temp_method;
    } else {
        $method = "index";
    }

    if($method == CONTROLLER) {
        define("METHOD", "index");
    } else {
        define("METHOD", $method);
    }
    
    $temp_c = CONTROLLER;
    $temp_m = defined('METHOD') ? METHOD : null;

if(file_exists(APPPATH . '/' . $_SERVER['path']['controllerFolder'] . '/'.CONTROLLER.EXT)) {
    require_once(APPPATH . '/' . $_SERVER['path']['controllerFolder'] . '/'.CONTROLLER.EXT);
    $controller = new $temp_c();
    if($temp_m !== null) {
        try {
            $controller->$temp_m();
        } catch (ZXCException $e) {
            echo $e->getMessage();
        }
    }
} else {
    try {
        $error = "Unable to load class " . CONTROLLER;
        throw new ZXCException($error, 1);
    } catch (ZXCException $e) {
        echo "Error: Code({$e->getCode()}) File({$e->getFile()}) Error message :" . $e->getMessage(), "\n";
    }
}