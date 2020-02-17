<?php

class Session {

    static function star() {
        //Iniciamos la session 
        @session_start();
    }

    static function getSession($name) {
//Obtendremos el nombre de nuestra session 
        return $_SESSION[$name];
    }

    static function setSession($name, $data) {
        return $_SESSION[$name] = $data;
    }

    static function destroy() {
        //Destruimos la session 
        @session_destroy();
    }

}

?>