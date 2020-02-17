  <?php
//Praticamente este es el controlador de a qui redireccionos con links pero no lo hago en un solo archivo
class controllers extends Anonymus{
  //Con este constructor cargaremos todos los modelos 
    public function __construct(){
      Session::star(); //A qui traemos la funciones del archivo session
      //Echo 'sistema libreria'
       
      $this->view = new Views(); // A qui cargo el archivo views y la instancia views archivo del head principalmente
 
      $this->loadClassmodels(); //A qui cargo todos los modelos 
}
//Cuando se ejecutan las vistas también se ejecutan los modelos 
function loadClassmodels(){
      //Este obtiene la clase model cuando ejecutamos la pagina
      $model = get_class($this).'_model';
      
    //Este requiere el archivo
      $path = 'Models/'.$model.'.php';
   
     //Este verficamos si existe el archivo
      if(file_exists($path)){
        //Requiremos el archivo de la carpeta model
          require $path;
        //Tomas todas las funciones de la carpeta model que esten en sus clases                  
          $this->model = new $model;
              
          
      }
}

}
?>