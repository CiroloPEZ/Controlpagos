<?php
     class Principal extends controllers{
         function __construct() {
             parent::__construct();
         }
       public function principal(){
           if(null !=Session::getSession("User")){
               
           }else{
                 header("Location:".URL);
           }
           $this->view->render($this,"principal", null);
       }
     }
?>

