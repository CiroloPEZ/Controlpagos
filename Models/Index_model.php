<?php

class Index_model extends Conexion {

    function __construct() {
        //    $this->indexModel();
        parent::__construct();
    }

function userLogin($email, $password) {
   
        $where = " WHERE Email = :Email";
        $param = array('Email' => $email);
        //Seleccionamos de la tabla usuarios donde email se igual email
        $response = $this->db->select1("*", 'usuarios', $where, $param); //Select usuarios where email=email;
        if (is_array($response)) {
            $response = $response['results'];
            //le hace falta un paso
            if (0 != count($response)) {
          
                //    echo "Password antes de verfy $password
                  //print_r ($response);
                if (password_verify($password, $response[0]["Password"])) { //A qui evaluando el password con la encriptacion hash5
                  //A qui guardamos la información del usuario que ha iniciado session 
                    $data = array(
                        "IdUsuario" => $response[0]["IdUsuario"],
                        "Nombre" => $response[0]["Nombre"],
                        "Apellido" => $response[0]["Apellido"],
                        "Roles" => $response[0]["Roles"],
                        "Imagen" => $response[0]["Imagen"],
                    );
                    // "User" vendria siendo la variable $name, $data la informacion de la vista
                    //Este user se envia  atravez del controlador a usuarios, como si hubiera un json
                    Session::setSession("User",$data);
                    return $data;
                } else {
                    $data = array(
                        "IdUsuario" => 0,
                    );
                    return $data;
                }
            } else {
                 return "El email no esta registrado";
            }
        }else {
            return $response;
        }
    }

}

?>
