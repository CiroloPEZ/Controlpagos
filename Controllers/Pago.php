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

//A qui obtemos el historial de pagos de otra tabla 
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
                $data = $this->model->getPago($_POST["filter"]);
                
                if (is_array($data)) {

                    //Guardamos los results 
                    $array = $data["results"];
                    foreach ($array as $key => $value) {
//Resivo los parametros y los convertimos a un objeto json 
                        $dataPago = json_encode($array[$count]);
                        
                       
                        $dataFilter .= "<tr>" .
                                "<td>" . $value["Nombre"] . "</td>" .
                                "<td>" . $value["Email"] . "</td>" .
                                "<td>" . $value["Mes"] . "</td>" .
                                "<td>" . $value["Pago"] . "</td>" .
                                "<td>" . $value["Valor"] . "</td>" .
                                "<td>" . $value["Fecha_pago"] . "</td>" .
                                "<td>" . $value["Proxima_fecha"]. "</td>".
                                "<td>" . $value["Estatus"] . "</td>" .
                                "<td>" . $value["Folio"] . "</td>" .
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
                //A qui tenemos los datos de la fecha actual de acuerdo con el array 
                $data = $this->model->getComparacionf($array);
                if (is_array($data)) {
                    //Guardamos los results 
                    $array = $data["results"];
                    $fecha = date("d-m-Y");
                    //A qui insertamos la palabra vencido 
                    if ($array[0]["Fecha_pago"] == $fecha) {
                     
                    $Fecha_proxima = date("d-m-Y", strtotime($array[0]["Fecha_pago"] . " + 28 days"));
                        
                        $array = array(
                            //Al id_cliente
                            $array[0]["Id_cliente"],
                            $fecha,
                            "Vencido",
                            225,
                            $Fecha_proxima,
                        );
                       
                        //A qui debe ser donde esta fecha actual = fecha actual
                        //Dentro de metodo insertaVencido evaluaremos la fecha actual
                       print_r($this->model->insertarVencido($array));
                    } else {
                        
                        echo 'No hay fechas vecidas';
                    }
                }
            } else {
                echo 'No tienes permitido';
            }
        }
    }
//Metodo para comprobar pagos
    public function Comprobarpago() {
        $user = Session::getSession("User");
        if (null != $user) {
            if ("Admin124" == $user["Roles"]) {
                if (empty($_POST["Nombre"])) {
                    echo "El campo de nombre es obligatorio";
                } else {
                    if(empty($_POST["Folio"])){
                        echo "El campo folio es obligatorio222";
                        print_r($_POST["Folio"]);
                    } else {
                       if(empty($_POST["Fecha_pago"])){
                           
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
        
      }else{
          echo 'No tienes acceso';
      }
    
    }
   }
