<?php

class Pago_model extends conexion {

    //A qui heredamos la base de datos
    function __construct() {
        parent::__construct();
    }

    //Buscamos los pagos de acuerdo a su estatus
    function getPago($filter) {
      
        $where = " WHERE Id_pago LIKE :Id_pago OR Estatus LIKE :Estatus";
        $array = array(
            'Id_pago' => '%' . $filter . '%',
            'Estatus' => '%' . $filter . '%',
        );
        $columns = "`Id_pago`, `Nombre`, `Email`, `Fecha_anterior`, `Pago`, `Proxima_fecha`, `Estatus`, `Id_cliente`";
        return $this->db->select1($columns, "pagos", $where, $array);
    }

    //Metodo para obtener los datos de los pagos de acuerdo al email 
    function getPagoss($Email) {

        $where = " WHERE Email = :Email";
        $array = array(
            'Email' => $Email,
        );
        $columns = "`Id_pago`, `Nombre`, `Email`, `Fecha_anterior`, `Pago`, `Proxima_fecha`, `Estatus`, `Id_cliente`";
        $response = $this->db->select1($columns, 'pagos', $where, $array);
        return $response;
    }

    //Metodo limipio para consultar las proximas fechas si parametros
    function getPagos() {
        $where = " WHERE 1";
        $array = "";
        $columns = "`Id_pago`, `Nombre`, `Email`, `Fecha_anterior`, `Pago`, `Proxima_fecha`, `Estatus`, `Id_cliente`";
        $response = $this->db->select3($columns, 'pagos', $where, $array);
        return $response;
    }

    /* Metodo para consulta el catologos de pagos para aver si hay pagos que sea menor a la fecha actual */

    function getPagosanteriores() {
        $where = " WHERE 1";
        $array = "";

        $columns = "`Clave_catalogo`, `Nombre`, `Email`, `Cantidad`, `Fecha_pagada`, `Id_pago` ";
        $response = $this->db->select3($columns, 'catalogo_pagos', $where, $array);
        return $response;
    }

    /* Insertaremos el estatus y la cantidad a pagar */

    public function getInsertarvencido($Email) {
        //Si la fecha el igual a la recibidad por el sitema entonces hasme un update
        $where = " WHERE Email= '$Email' ";
        $value = " Estatus = :Estatus, Pago = :Pago";
        //A qui insertamos los datos a actulizar 
        $array = array(
            "Vencido", //Estatus
            225, //Pago obtendria otro dato mas 
        );
        $data = $this->db->update("pagos", $array, $value, $where);
        //Mostrando errores del servidor
        if (is_bool($data)) {
            return 0;
        } else {
            return $data;
        }
    }

    //Metodo para actualizar la fecha de las personas que si pagaron 
    public function getActualizarfecha($Email) {
        //Obtenemos los datos de acuerdo a email 
        $data = $this->getPagoss($Email);
        $array = $data["results"];
        // print_r($array[0]["Proxima_fecha"]);
        $where = " WHERE Email = '$Email'";
        $value = "Fecha_anterior = :Fecha_anterior, Proxima_fecha = :Proxima_fecha";
        //Actulizamos las fecha anterior  
        $Fecha_actualizada = date("d-m-Y", strtotime($array[0]["Proxima_fecha"] . " + 28 days"));
        $array = array(
            $array[0]["Proxima_fecha"], // Va a cambiarse a fecha anterior 
            $Fecha_actualizada, //Proxima fecha actualizada 
        );

        $data = $this->db->update("pagos", $array, $value, $where);

        if (is_bool($data)) {
            return 0;
        } else {
            return $data;
        }
    }

    //En esta funcion realizaremos las consultad en nuestra base de datos 
    //Para guardar nuestros pagos 
    public function Comprobarpago($pago) {
        $user = Session::getSession("User");
        if (null != $user) {

            $where = " WHERE  Id_pago = '$pago->Id_pago'";
            $response = $this->db->select1("*", 'pagos', $where, null);
            if (is_array($response)) {
                $response = $response['results'];
                //A qui cargaremos los datos a actualizar 
                $value = "Pago = :Pago, Estatus = :Estatus, Fecha_pago = :Fecha_pago, Proxima_fecha = :Proxima_fecha";
                $where = " WHERE  Id_pago = '$pago->Id_pago'";
                //Comprobamos si tenemos datos 
                if (0 == count($response)) {
                    echo 'Datos erroneos del sistema';
                } else {

                    $array = array(
                        $pago->Pago,
                        $pago->Estatus,
                        //La fecha actualmente que se esta pagando
                        $pago->Fecha_pago,
                        //La proxima fecha a que se va a pagar apartir de la ultima fecha que se pago 
                        $pago->Proxima_fecha,
                    );

                    // print_r($array);
                    $data = $this->db->update("pagos", $array, $value, $where);
                    // $data = false;
                    if (is_bool($data)) {
                        //Correcion de datos tengo que agregar un ID
                        $value = "(`Nombre`, `Mes_pago`, `Cantidad`, `Fecha_pagada`, `Folio`)VALUES (:Nombre, :Mes_pago, :Cantidad, :Fecha_pagada, :Folio)";
                        $array = array(
                            $pago->Nombre,
                            $pago->Mes,
                            $pago->Pago,
                            $pago->Fecha_pago,
                            $pago->Folio
                        );
                        //   print_r($array);
                        $data2 = $this->db->insert1("catalogo_pagos", $array, $value);

                        if (is_bool($data2)) {
                            return 0;
                        } else {
                            return $data2;
                        }
                    } else {

                        return $data;
                    }
                }
            }
        }
    }
