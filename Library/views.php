<?php
//A qui halo la vista de la cabecera y el pien de pagina 
//También lo que tenga en controlador con html 
class views{
    //Ahora resivo vista html y php 
    //Php es para ver parametros
    function  render($controller, $view, $models){
        //Galamos todos los controladores 
        $controller = get_class($controller);
        require VIEWS.DFT."head.html";
        //A qui evaluamos si nuestro parametro models o sea el email no tiene dato
        if($models == null){ //Estro significa que no estamos pasando ningun dato
          require VIEWS.$controller.'/'.$view.'.html'; //A qui van las vistas html
        }else{
            require VIEWS.$controller.'/'.$view.'.php'; //A qui van las vista php
        }
      
        require VIEWS.DFT."footer.html";
        
    }
}
?>


