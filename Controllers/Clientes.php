<?php

class Clientes extends controllers {
//Toma los datos de la vista 
    function __construct() {
        parent::__construct();
    }

    //En caso de que quieran ingresar atravez de la URL a nuestro archivo 
    public function Clientes() {
        //Esta variable contiene los datos de ususario 
        //También es importante si los datos que esta en session son admin124
       
            //A qui tomo el dato que tengo guardado en la session 
            if (null != Session::getSession("User")) {

                //Entra a la vista principal 
            } else {

                header("Location:" . URL);
            }
        $this->view->render($this, "principal");
    }

//Tiene que entrar a esta funcion
    public function registerCliente() {

        $user = Session::getSession("User");

        if (null !== $user) {
            if ("Admin124" == $user["Roles"]) {

                if (empty($_POST["Nombre"])) {
                    echo "El campo nombre es obligatorio";
                } else {
                    if (empty($_POST["Apellido_paterno"])) {
                        echo "El campo apellido paterno es obligatorios";
                    } else {
                        if (empty($_POST["Apellido_materno"])) {
                            echo 'El campo apellido materno es obligatorio';
                        } else {
                            if (empty($_POST["Edad"])) {
                                echo 'El campo edad es obligatorio';
                            } else {
                                if (empty($_POST["Folio"])) {
                                    echo 'El campo folio es obligatorio';
                                } else {
                                    //E insertaremos la palabra activo por default.
                                    $array1 = array(
                                        $_POST["Nombre"],
                                        $_POST["Apellido_paterno"],
                                        $_POST["Apellido_materno"],
                                        $_POST["Email"],
                                        $_POST["Edad"],
                                        date("d-m-Y"),
                                        $_POST["Folio"],
                                        "ACTIVO",
                                    );
                                    //A qui haremos el calculalo de la fecha
                                    //Si array1 tienes datos ya tabla 
                                    //Calculame la fecha e insetarme el registro en la tabla pagos  y tambien evaluar el tipo de paquete

                                    $fecha_actual = date("d-m-Y");
                                    //sumo 28 días
                                    $Fecha_pago = date("d-m-Y", strtotime($fecha_actual . " + 28 days"));

                                    $array2 = array(
                                        "",
                                        $_POST["Nombre"],
                                        date("m"),
                                        "$0.00", //Pago nulo por ser el principio
                                        "Activo",
                                        $_POST["Folio"],
                                        //sumo 28 días
                                        $Fecha_pago, //Fecha pago por que a un no es el primer mes
                                    );
                                    $data = $this->model->registerCliente($this->clientesClass($array1), $this->pagosClass($array2));


                                    if ($data == 1) {
                                        echo "El email " . $_POST["Email"] . " ya esta registrado..   ";
                                    } else {
                                        
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                echo 'no tienes acceso';
            }
        }
    }

   

   
    //Metodo para editar cliente.
    public function editCliente() {
        
        $user = Session::getSession("User");
        if (null !== $user) {
            
            if (empty($_POST["Nombre"])) {
                echo "El campo nombre es obligatorio";
            } else {
                if (empty($_POST["Apellido_paterno"])) {
                    echo "El campo apellido paterno es obligatorios";
                } else {
                    if (empty($_POST["Apellido_materno"])) {
                        echo 'El campo apellido materno es obligatorio';
                    } else {
                        if (empty($_POST["Email"])) {
                            echo 'El campo email es obligatorio';
                        } else {
                             if(empty($_POST["Fecha_inicio"])){
                                  echo 'Falta fecha inicio';
                             } else {
                            if (empty($_POST["Edad"])) {
                                echo 'El campo edad es obligatorio';
                            } else {
                                if (empty($_POST["Folio"])) {
                                    echo 'El campo folio es obligatorio';
                                } else {
                                    //En caso de una imagen tendria que ir el codigo 
                                    //A qui es donde tengo que recibir el dato de IdUusuario
                                    //Evaluamos el IdUsuario en caso de un ataque de inyeccion 
                                    //Utilizamos el mismo metodo para mostrar los usuario en nuestra ventana
                                    //El metodo getCliente 
                        
                                    $response = $this->model->getCliente($_POST["Id_cliente"]);

                                    if (is_array($response)) {


                                        $array = array(
                                            $_POST["Id_cliente"],
                                            $_POST["Nombre"],
                                            $_POST["Apellido_paterno"],
                                            $_POST["Apellido_materno"],
                                            $_POST["Email"],
                                            $_POST['Edad'],
                                            0,
                                            $_POST['Folio'],
                                        );
                                        print_r($array);
                                      $this->model->editCliente($this->clientesClass($array), $_POST['Id_cliente']);
                                    } else {
                                        return $response;
                                    }
                                }
                            }
                        }
                    }
                }
            }
           }
        } else {
            echo "Lo siento estas feo";
        }
    }

//Metodo para mostrar nuestro clientes 
    public function getCliente() {
        //Verificamos la session 
        $user = Session::getSession("User");
        if (null != $user) {
            if ("Admin124" == $user["Roles"]) {
                //A qui hacemos la funcion de busqueda de clientes

                $count = 0;
                $dataFilter = null;
                /////
                $data = $this->model->getCliente($_POST["filter"]);


                if (is_array($data)) {
                    //Guardamos los results 
                    $array = $data["results"];

                    foreach ($array as $key => $value) {

//Resivo los parametros y los convertimos a un objeto json 

                        $dataCliente = json_encode($array[$count]);

                        $dataFilter .= "<tr>" .
                                "<td>" . $value["Nombre"] . "</td>" .
                                "<td>" . $value["Apellido_paterno"] . "</td>" .
                                "<td>" . $value["Apellido_materno"] . "</td>" .
                                "<td>" . $value["Fecha_inicio"] . "</td>" .
                                "<td>" . $value["Email"] . "</td>" .
                                "<td>" . $value["Edad"] . "</td>" .
                                
                                "<td>" . $value["Folio"] . "</td>" .
                                "<td>" .
                                "<button type='button' class='btn btn-dark' onclick='dataCliente(" . $dataCliente . ")' data-toggle='modal' data-target='#myModal'>Editar</button> |" .
                                "<button type='button' class='btn btn-dark' onclick='deleteCliente(" . $dataCliente . ")'  data-toggle='modal' data-target='#myModal2'>Eliminar</button> " .
                                "<a class='btn btn-dark' href='http://localhost/Fecha_pago/Pago/pago'>pago</a> " .
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

    public function deleteCliente() {
        $user = Session::getSession("User");
        if (null != $user) {
            if ("Admin124" == $user["Roles"]) {
                var_dump($_POST["Id_cliente"]);
                echo $this->model->deleteCliente($_POST["Id_cliente"]);
            } else {
                echo "No access";
            }
        }
    }

}

?>
     