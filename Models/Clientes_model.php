<?php

class Clientes_model extends conexion {

    //A qui eredamos la base de datos
    function __construct() {
        parent::__construct();
    }

    public function registerCliente($clientes, $pagos) {
        //A qui verficamos si ya hay un proveedor registrado
        $where = " WHERE Email = :Email";
        $response = $this->db->select1("*", 'clientes', $where, array('Email' => $clientes->Email));

        if (is_array($response)) {
            //A qui insertamos los datos a la tabla cliente
            $response = $response['results'];
            if (0 == count($response)) {
                //
                //Esta seria la query
                $value = "(Nombre, Apellido_paterno, Apellido_materno, Email, Edad, Fecha_inicio, Folio) 
                          VALUE (:Nombre, :Apellido_paterno, :Apellido_materno, :Email, :Edad, :Fecha_inicio, :Folio)";
                $data = $this->db->insert1("clientes", $clientes, $value);
                // $data = true;
                if (is_bool($data)) {
                    //A qui ya se inserto los datos en los datos en la tabla proveedores
                    // echo $data;
                    $response = $this->db->select1("*", 'clientes', $where, array('Email' => $clientes->Email));
                    //  var_dump($response);
                    if (is_array($response)) {
                        echo "condi2";
                        //Checamos si es el mismo proveedor
                        $response = $response['results'];
                        //   var_dump($pagos);
                        $pagos->Id_cliente = $response[0]["Id_cliente"];
                        var_dump($pagos);
                        $value = " (`Id_pago`, `Nombre`, `Mes`, `Pago`,  `Fecha_pago`, `Estatus`, `Folio`, `Id_cliente`) VALUES (:Id_pago, :Nombre,:Mes,:Pago,:Fecha_pago, :Estatus, :Folio, :Id_cliente)";
                        print_r($pagos);
                        $data = $this->db->insert1("pagos", $pagos, $value);

                        if (is_bool($data)) {
                            // return 0;
                            return 0;
                        } else {
                            //  return $data;
                            echo $data;
                        }
                    } else {
                        return $response;
                    }
                } else {
                    return $data;
                }
            } else {
                return 1;
            }
        } else {
            return $response;
        }
    }

    //Insertaremos la fecha del pago cuando insertamos el dato  
  public function insertarFecha($Fecha_pago) {

        // Obtenemos los datos de los clientes 
        // $.Fecha_pago[0] obtengo el id_cliente     
        $where = " WHERE Id_cliente = " . $Fecha_pago[0];

        $response = $this->db->select1("*", 'pagos', $where, null);
        //Si response es un array 
        if (is_array($response)) {
            $response = $response['results'];
            
            //A qui cargamos los datos nuevos
            $value = "Id_cliente = :Id_cliente, Fecha_pago = :Fecha_pago";

            $where = " WHERE Id_cliente = " . $Fecha_pago[0];


            if (0 == count($response)) {


                $data = $this->db->update("pagos", $Fecha_pago, $value, $where);
                if (is_bool($data)) {
                    return 0;
                } else {
                    return $data;
                }
            } else {
                $data = $this->db->update("pagos", $Fecha_pago, $value, $where);
                if (is_bool($data)) {
                    return 0;
                } else {
                    return $data;
                }
            }
        }
    }

   

  

    //Buscamos los clientes de acuerdo a su nombre o apellido paterno
    function getCliente($filter) {
        $where = " WHERE Id_cliente LIKE :Id_cliente OR Nombre LIKE :Nombre OR Apellido_paterno LIKE :Apellido_paterno";
        $array = array(
            'Id_cliente' => '%' . $filter . '%',
            'Nombre' => '%' . $filter . '%',
            'Apellido_paterno' => '%' . $filter . '%',
        );

        $columns = "Id_cliente, Nombre, Apellido_paterno, Apellido_materno, Email, Edad, Fecha_inicio, Folio";
        //Retorname el valor de acuerdo a los parametros que estan arriba
        return $this->db->select1($columns, "clientes", $where, $array);
    }
    function editCliente($cliente, $Id_cliente) {
        
        print_r($cliente);
     
        $where = " WHERE Email= :Email";
        $response = $this->db->select1("*", 'clientes', $where, array('Email' => $cliente->Email));
   

        //Si response es un array 
        if (is_array($response)) {
            $response = $response['results'];
            //A qui cargamos los datos nuesvos
            $value = "Id_cliente = :Id_cliente, Nombre = :Nombre, Apellido_paterno = :Apellido_paterno, Apellido_materno = :Apellido_materno, Email = :Email, Edad = :Edad,  Folio = :Folio";

            $where = " WHERE Id_cliente = " . $Id_cliente;
          
            if (0 == count($response)) {
                $data = $this->db->update("clientes", $cliente, $value, $where);
                
                if (is_bool($data)) {
                    return 0;
                } else {
                    return $data;
                }
            } else {
              
                if ($response[0]['Id_cliente'] == $Id_cliente) {
                    
                    $data = $this->db->update("clientes", $cliente, $value, $where);
                    echo 'skdmksalmd23234';
                    if (is_bool($data)) {
                        return 0;
                    } else {
                        return $data;
                    }
                } else {
                    return "El email ya esta registrado";
                }
            }
        } else {
            return $response;
        }
    }

    function deleteCliente($Id_cliente) {
        $where = " WHERE Id_cliente = :Id_cliente";
        $data = $this->db->delete('clientes', $where, array('Id_cliente' => $Id_cliente));
        if (is_bool($data)) {
            
        } else {
            return $data;
        }
    }

}

?>
