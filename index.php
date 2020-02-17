<?php

require "config.php";
//$url = isset($_GET["url"]) ? $_GET["url"]:"Index/index";
$url = $_GET["url"] ?? "Index/index";
//echo $url;
//Quedaria a si la ruta array [0][1] = [1]=PDHN, [2]=Clientes, [3]= Reportes;
$url = explode("/", $url);
$controller = "";
$method = "";
if (isset($url[0])) {
    $controller = $url[0];
}
if (isset($url[1])) {
    if ($url[1] != '') {
        $method = $url[1];
    }
}

//invocamos los archivos de la libreria todos
spl_autoload_register(function($class){
   if (file_exists(LBS.$class.".php")) {
    require LBS.$class.".php";
   }
 });

require 'Controllers/Error.php';
$error = new Errors();
//Instacia de la classe library
//$obj = new controllers();
// echo $controller."---".$method;
$controllersPath = "Controllers/" . $controller . '.php';
if (file_exists($controllersPath)) {
    //Traemos los archivos en forma de variable de la carpeta controller
    require $controllersPath;
    //instaciamos de la classe
    $controller = new $controller();
    if (isset($method)) {
        if (method_exists($controller, $method)) {

            $controller->{$method}();
        } else {
            $error->error();
        }
    }
} else {
    $error->error();
}
?>

