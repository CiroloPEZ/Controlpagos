<?php

class Catalogo_model extends conexion {

    //A qui eredamos la base de datos
    function __construct() {
        parent::__construct();
    }
//Mostramos los datos generelales
    public function getCatalogo($filter) {
        $where = " WHERE Clave_catalogo LIKE :Clave_catalogo OR Nombre LIKE :Nombre";
        $array = array(
            'Clave_catalogo' => '%' . $filter . '%',
            'Nombre' => '%' . $filter . '%',
        );
        $columns = "Clave_catalogo, Nombre, Mes_pago, Cantidad, Fecha_pagada, Folio, Id_pago";
        return $this->db->select1($columns, "catalogo_pagos", $where, $array);
    }
    
//A qui solo mostramos el historial de pagos, de acuerdo a una clave 
    public function getHispago($filter) {
        $where = " WHERE Email Like :Email";
        $array = array(
            
            'Email' => '%' . $filter . '%',
        );
        $columns = "Nombre, Email, Fecha_pagada, Folio";
        return $this->db->select1($columns, "catalogo_pagos", $where, $array);
    }

}

?>
