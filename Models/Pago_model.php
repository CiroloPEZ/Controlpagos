<?php

class Pago_model extends conexion{

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
        $columns = "Id_pago,Email, Nombre, Mes, Pago, Valor, Fecha_pago, Proxima_fecha, Estatus, Folio";
        return $this->db->select1($columns, "pagos", $where, $array);
    }

    //Comparamos la fecha del sistema con la de BD 
    function getComparacionf($Fecha) {
        $where = " WHERE Fecha_pago = '$Fecha[0]' ";
        $response = $this->db->select2("*", 'pagos', $where, array('Fecha_pago' => $Fecha));
        return $response;
    }

    /* Insertaremos el estatus y la cantidad a pagar */

    public function insertarVencido($Vencido) {
        print_r($Vencido);
        $where = " WHERE Fecha_pago = '$Vencido[1]' ";
        $response = $this->db->select1("*", 'pagos', $where, null);
        //Si response es un array 
        if (is_array($response)) {
            //El response lo declaramos para comprobar si tiene datos 
            $response = $response['results'];
            if (0 == count($response)) {
                
            } else {
                $value = " Estatus = :Estatus, Valor = :Valor, Proxima_fecha = :Proxima_fecha";

                //Si la fecha el igual a la recibidad por el sitema entonces hasme un update
                $where = " WHERE Fecha_pago = '$Vencido[1]' ";
                //A qui insertamos la cantidad de 225 en el indice 2
                $array = array(
                    $Vencido[2],
                    $Vencido[3],
                    $Vencido[4]
                );

                $data = $this->db->update("pagos", $array, $value, $where);
                //Mostrando errores del servidor
                if (is_bool($data)) {
                    return 0;
                } else {
                    return $data;
                }
            }
        }
    }

    //En esta funcion realizaremos las consultad en nuestra base de datos 
    //Para guardar nuestros pagos 
    public function Comprobarpago($pago){
        
        
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
               $data = $this->db->update("pagos", $array , $value, $where);
               // $data = false;
                   if(is_bool($data)){
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
                    
                       if(is_bool($data2)){
                         return 0;
                     }else{
                         return $data2;
                     }
                }else{

                    return $data;
                }
               }
            }
            }
        }
       
    }


