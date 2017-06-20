<?php

class Route
{
    private static $routing_variable = '';

    static function start()
    {
        //controller and default actions
        $controller_name = 'user';
        $action_name = 'index';

        $routes = explode('/', str_replace(chr(0), '', $_SERVER['REQUEST_URI']));

        //get controller name
        if (!empty($routes[1])) {
            $controller_name = $routes[1];
        }

        //get action name
        if (!empty($routes[2])) {
            $action_name = $routes[2];
        }
        if (!empty($routes[3])) {
            $finish_params = '"' . htmlentities(trim(stripslashes($routes[3])), ENT_QUOTES) . '"';
        } else {
            $finish_params = 'null';
        }
        self::$routing_variable = $controller_name . '/' . $action_name;//SET ROUTING VARIABLE
        for ($i = 4; $i < count($routes); ++$i) {
            if (!empty($routes[$i])) {
                $finish_params = $finish_params . ',"' . htmlentities(trim(stripslashes($routes[$i])), ENT_QUOTES) . '"';
            }
        }
        //add prefix
        $model_name = 'Model_' . $controller_name;
        $controller_name_back = $controller_name;
        $controller_name = 'Controller_' . $controller_name;
        $action_name = 'action_' . $action_name;

        /*
        echo "Model: $model_name <br>";
        echo "Controller: $controller_name <br>";
        echo "Action: $action_name <br>";
        */

        $model_file = strtolower($model_name) . '.php';//connect model class (if exist)
        $model_path = "application/models/" . $model_file;
        if (file_exists($model_path)) {
            include_once "application/models/" . $model_file;
        }

        $controller_file = strtolower($controller_name) . '.php';//get controller class
        $controller_path = "application/controllers/" . $controller_file;
        if (file_exists($controller_path)) {
            include_once "application/controllers/" . $controller_file;
        } else {
            //Hack for alert messages:
            include_once "application/models/model_alert.php";
            include_once "application/controllers/controller_alert.php";

            $controller = new Controller_alert;
            $action = 'action_' . $controller_name_back;

            if (method_exists($controller, $action)) {
                eval("\$controller->\$action();");
                die();
            } else {
                Route::ErrorPage404();//EXCEPTION
                die();
            }
        }

        $controller = new $controller_name;
        $action = $action_name;

        if (method_exists($controller, $action)) {
            eval("\$controller->\$action($finish_params);");
        } else {
            Route::ErrorPage404();//EXCEPTION
            die();
        }

    }

    public static function get_routing_variable()
    {
        return self::$routing_variable;
    }

    function ErrorPage404()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:' . $host . '404');
    }

}
