<?php

//This is the gateway to the controller class.
//It is the first page that is loaded.
try {
$url        = $_SERVER['REQUEST_URI'];

$resource   = str_replace('/medi/', '', $url);

$split_url  = explode('/', $resource);

$controller = $split_url[0]."Controller";

$action     = $split_url[1].'Action';

if ($split_url[0] == "") {
    $controller = "IndexController";
}

if ($split_url[1] == "") {
    $action = "indexAction";
}

//get all the arguments passed the $split_url[1]
$args       = array_slice($split_url, 2);

if (!isset($args[0]) || $args[0] == '') {
    $args = array();
}

//check if controller exists within the controllers folder

if (file_exists('controllers/'.$controller.'.php')) {
        
    //if it does, include it
    require_once('controllers/'.$controller.'.php');
        
    //create a new instance of the controller class
    $controller = new $controller();
        
    //check if the method exists within the controller class
    if (method_exists($controller, $action)) {
            
        //if it does, call the method
        //split arguments into individual variables
        call_user_func_array(array($controller, $action), $args);

        if (method_exists($controller, "afterExecute")) {
            $controller->afterExecute();
        }
    } else {
            
        //if it doesn't, set the error
        $error = 'Method does not exist';
    }
} else {
        
    //if it doesn't, set the error
    $error = 'Controller does not exist';
}

//if there is an error, display it
if (isset($error)) {
    echo $error;
}

} catch (Exception $e) {
    header("Content Type: text/plain");
    echo "Message: ".$e->getMessage();
    echo "File: ".$e->getFile();
    echo "Line: ".$e->getLine();
    exit;
}
