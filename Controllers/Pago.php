<?php

class Pago extends controllers {

    //Toma los datos de la vista 
    function __construct() {
        parent::__construct();
    }

    //En caso de que quieran ingresar atravez de la URL a nuestro archivo 
    //Comprobamos que halla iniciado session un usuario si no redireccionamos a la pagina principal 
    public function Pago() {
        if (null != Session::getSession("User")) { //Esta variable contiene los datos de ususario
            //"pagos" se refiere al archivo html
            $this->view->render($this, "pago", null);
        } else {
            header("Location:" . URL);
        }
    }

//A qui obtemos el historial de pagos de otra tabla ???
    public function getHispago($filter) {
        $where = " WHERE Email Like :Email";
        $array = array(
            'Email' => '%' . $filter . '%',
        );
        $columns = "Nombre, Emai, Mes_pago, Cantidad";
        return $this->db->select1($columns, "pagos", $where, $array);
    }

    public function getPago() {
        //Verificamos la session 
        $user = Session::getSession("User");
        if (null != $user) {
            if ("Admin124" == $user["Roles"]) {
                //A qui hacemos la funcion de mostrar clientes 
                $count = 0;
                $dataFilter = null;
                //Ocupo obtener datos de dos tablas de la base de datos
             //   $data = $this->model->getPago($_POST["filter"]);
              $data = $this->model->getPagoi(0);
               print_r($data);

                if (is_array($data)) {

                    //Guardamos los results 
                    $array = $data["results"];
                    foreach ($array as $key => $value) {
//Resivo los parametros y los convertimos a un objeto json 
                        $dataPago = json_encode($array[$count]);


                        $dataFilter .= "<tr>" .
                                "<td>" . $value["Nombre"] . "</td>" .
                                "<td>" . $value["Email"] . "</td>" .
                                "<td>" . $value["Fecha_anterior"] . "</td>" .
                                "<td>" . $value["Pago"] . "</td>" .
                                "<td>" . $value["Proxima_fecha"] . "</td>" .
                                "<td>" . $value["Estatus"] . "</td>" .
                                "<td>" .
                                
                                "<button type='button' class='btn btn-dark' onclick='pagoCliente(" . $dataPago . ")'  data-toggle='modal' data-target='#myModal3'>|Realiza pago|</button> " .
                                "<button type='button' class='btn btn-dark' onclick='getHiscatalogo(" . $dataPago . ")'  data-toggle='modal' data-target='#myModal4'>|Historial de pagos|</button> " .
                                "</td>" .
                                "</tr>";
                        $count++;
                    }

//Imprimiendo datos esto es importante 
                    //   $paginador = " <p>Resultados</p> ";
                    echo json_encode(array(
                        "dataFilter" => $dataFilter,
                            //  "paginador" => $paginador
                    ));
                } else {
                    echo $data;
                }
            } else {
                header("Location: http://localhost/Fecha_pago/index.php");
                echo 'estas feo';
            }
        } else {
            //Redireccionamos al enlace principál     
        }
    }

//En esta funcion realizaremos la evaluacion de nuestra fecha actual e 
    //E insertaremos la palabra vencido en caso de las fecha se igual a la base de datos.
    public function revisarFecha() {
        $user = Session::getSession("User");
        if (null !== $user) {
            //Obtemos la fecha actual del sistema y comparamos con la base de datos
            if ("Admin124" == $user["Roles"]) {
                $array = array(
                    date("d-m-Y"),
                );
                //A qui obtemos los datos de catolago pagos 
                $data = $this->model->getPagos($array);
                $array = $data["results"];

                //A qui obtenemos los datos del catalogo de pagos 
                $data2 = $this->model->getPagosanteriores();
                $array2 = $data2["results"];

                if (empty($array2[0]["Fecha_pagada"])) {
                    echo 'No se realizado un pago';
                } else {
                    for ($i = 0; $i < count($array); $i++) {
                        //Si los registro de proxima fecha tiene ya una fecha pagada anteriormente y si no deben inserta vencido 
                        if (is_array($data) and $array[$i]["Proxima_fecha"] = $array and empty($array2[$i]["Fecha_pagada"])) {
                            //A qui va ser un update 
                            $data3 = $this->model->getInsertarvencido($array[$i]["Email"]);
                        } else {
                              // Si no debe 
                             // A qui actualizaremos fechas la proxima fecha va a pasar debe pasar a fecha_anterio
                            // Fecha anterior mas 28 dias 
                           //Este array me va a dar los email de las personas que ya pagaron 
                          //  print_r($array[$i]["Email"]);
                           $data4 = $this->model->getActualizarfecha($array[$i]["Email"]);
                           print_r($data4);
                            
                        }
                    }
                }
            } else {
                echo 'No tienes el acceso permitido';
            }
        }
    }

//Metodo para 
    public function Comprobarpago() {
        $user = Session::getSession("User");
        if (null != $user) {
            if ("Admin124" == $user["Roles"]) {
                if (empty($_POST["Nombre"])) {
                    echo "El campo de nombre es obligatorio";
                } else {
                    if (empty($_POST["Folio"])) {
                        echo "El campo folio es obligatorio222";
                        print_r($_POST["Folio"]);
                    } else {
                        if (empty($_POST["Fecha_pago"])) {

                            echo 'Fecha de pago es obligatoria';
                        } else {
                            $Fecha_proxima = date("d-m-Y", strtotime($_POST["Proxima_fecha"] . " + 28 days"));
                            $pago = array(
                                $_POST["Id_pago"],
                                $_POST["Nombre"],
                                $_POST["Mes"],
                                $_POST["Valor"],
                                "Activo",
                                $_POST["Folio"],
                                //Es la fecha actual que se tiene en la base de datos cuando se registro el cliente
                                $_POST["Fecha_pago"],
                                //  $_POST["Cantidad"],
                                //A qui es la proxima fecha =????
                                $Fecha_proxima,
                            );
                            //  print_r($pago);
                            // pagosClass Hace referencia a la clase anonima 
                            print_r($this->model->Comprobarpago($this->pagosClass($pago), $_POST['Id_pago']));
                        }
                    }
                }
            }
        } else {
            echo 'No tienes acceso';
        }
    }

}
