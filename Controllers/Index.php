<?php

//Heredamos los atributos de la controllers y las funciones
class Index extends controllers {

    public function __construct() {
        //  echo 'Index de controlador';
       parent::__construct();
    }

    public function index() {

        $user = isset($_SESSION["User"]) ?? null; //Si no contiene un dato en la variable use le asignamos un null
       
        if (null != $user) {
            //A qui abrimos el login 
            header("Location: http://localhost/Fecha_pago/Principal/Principal");
        } else {
            $this->view->render($this, "index", null);
        }
    }

 public function userLogin(){

     
        if(isset($_POST["email"])){
            if (!empty($_POST["password"])) {
                
               if (6<=strlen($_POST["password"])) {
                   //A qui utilizamos el userlogin del modelo
                    $data =  $this->model->userLogin($_POST["email"],$_POST["password"]);
                    if (is_array($data)) { //Si regresa un $data si esta bien
                        echo json_encode($data);
                    } else {
                        echo $data;
                    }
               } else {
                  echo 2; // El password le falta seis caracteres utilizando el framework
               }   
            } else {
                echo 1; //Si el password esta mal me envias un 1
            }
            
         /*  // echo password_hash($_POST["password"], PASSWORD_DEFAULT);
            */
            
        }
    }
      public function destroySession() {
        // header("Location".URL); // Viene jalando el archivo desde el head de la vista 
        Session::destroy();
        header("Location: http://localhost/Fecha_pago/index.php"); // Viene jalando el archivo desde el head de la vista 
    }

}
?>
   