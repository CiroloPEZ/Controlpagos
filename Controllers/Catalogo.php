<?php

class Catalogo extends controllers {

    //Toma los datos de la vista 
    function __construct() {
        //Compara: funcion
        parent::__construct();
    }

    //En caso de que quieran ingresar atravez de la URL a nuestro archivo 
    //Comprobamos que halla iniciado session un usuario si no redireccionamos a la pagina principal 
    public function Catalogo() {
        if (null != Session::getSession("User")) { //Esta variable contiene los datos de ususario
            //"pagos" se refiere al archivo html
            $this->view->render($this, "catalogo", null);
        } else {
            header("Location:" . URL);
        }
    }

    //Metodo para mostra nuestro catalogo de pagos 
    public function getCatalogo() {

        //Verificamos en inicio de session 
        $user = Session::getSession("User");
        if (null != $user) {
            if ("Admin124" == $user["Roles"]) {
                //A qui hacemos la funcion de busqueda de la información de nuestro catologo
                $count = 0;
                $dataFilter = null;


                $data = $this->model->getCatalogo($_POST["filter"]);
             

                if (is_array($data)) {
                    //Guardamos los results 
                    $array = $data["results"];

                    foreach ($array as $key => $value) {

                        $dataCatalogo = json_encode($array[$count]);

                        $dataFilter .= "<tr>" .
                                "<td>" . $value["Nombre"] . "</td>" .
                                "<td>" . $value["Mes_pago"] . "</td> " .
                                "<td>" . $value["Cantidad"] . "</td>" .
                                "<td>" . $value["Fecha_pagada"] . "</td>" .
                                "<td>" . $value["Folio"] . "</td>" .
                                "<td>" . $value["Id_pago"] . "</td>" .
                                "<td>" .
                                "<button type='button' class='btn btn-dark' onclick='dataCatalogo(" . $dataCatalogo . ")' data-toggle='modal' data-target='#myModal'>Editar</button> |" .
                                "</td>" .
                                "</tr>" .
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
    
 public function getHiscatologo(){
   $user = Session::getSession("User");
   if(null != $user){
      if("Admin124" == $user["Roles"]){
         //A qui mandamos a traer nuestra funcion del modelo
         $count = 0;
         $dataFilter = null;
         $data = $this->model->getHispago($_POST["filter"]);
         
      if(is_array($data)){
           $array = $data["results"];
       foreach ($array as $key => $value){
           
          $dataFilter .="<tr>".
              "<td>".$value["Nombre"]. "</td>".
              "<td>".$value["Email"]. "</td>".
              "<td>".$value["Fecha_pagada"]. "</td>".
              "<td>".$value["Folio"]."</td>".
              "<td>".
              "</td>". 
              "</tr>".
                  
            $count ++;
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
        
}

 


?>