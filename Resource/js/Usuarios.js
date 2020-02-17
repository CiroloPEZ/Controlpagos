class Usuarios {
 
constructor() {
        //super(); //Hacemos referencia a la clase que estamos hereando y invocamos todas las propiedades de la clase upload picture
        this.Funcion = 0;
        this.IdUsuario = 0;
        //this.Imagen = null; 
      //  console.log(URL);
    }

    loginUser() {
        //Validamos el email
          var a= document.getElementById("password").value;
          //Si obtenemos los datos 
          console.log(a);
        if (validarEmail(document.getElementById("email").value)) {
            
            $.post(
                    "Index/userLogin", //A qui envio los datos del  controlador
                     $('.login').serialize(), //Voy a serializar todo lo que se ingrese en nuestro login
                   
            (response) => {
               console.log(response); //Visualizar por consola del modelo
               
                if (response == 1) { //A qui evaluo el password
                        document.getElementById("password").focus();
                        document.getElementById("indexMessage").innerHTML = "Ingrese el password";
                    } else {
                        if (response == 2) {
                            document.getElementById("password").focus();
                            document.getElementById("indexMessage").innerHTML = "Introduzca al menos 6 caracteres";
                    } else {
                       try {
                            var item = JSON.parse(response); // A qui recibo los datos del response 
                            // var valor = (int)item.IdUsuario;
                            if (0 < item.IdUsuario) {
                               //Guardamos los datos en la memoria de nuestro navegador local
                              localStorage.setItem("User", response); // Si los datos enviados al servidos estan mal mensaje email o contraseña incorrectos
                              //  window.location.href = "Principal/principal";  //Si la funcion json funciona me redireccion ala principal
                           //     console.log(item.IdUsuario);
                               console.log(URL);
                              window.location.href= URL + 'Principal/principal';
                               
                             
                            } else {
                                //A qui solo mostramos un mesaje de error
                                document.getElementById("indexMessage").innerHTML = "Email o contraseño incorrectos";
                            }
                        } catch (e) {
                            document.getElementById("indexMessage").innerHTML = response; //Brinca a qui a al error
                        }
                    }
                }
            }
            );
        } else {
            document.getElementById("email").focus();
            document.getElementById("indexMessage").innerHTML = "Ingrese una dirección de correo valida"; 
          //  M.toast({html: 'ingrese una direccion de correo validad', classes: 'rounded'});
        }
    }
    //Aplicacion to
  userData(URLactual){
    // alert(URLactual);
    //A qui si la ruta es la principal de login 
      if(PATHNAME == URLactual){
          //Removemos el usuario
             localStorage.removeItem("User");
             document.getElementById('menuNavbar1').style.display = 'none';  
         }else{
              // var b =  localStorage.getItem("User");
             //  alert("datos de la session " +b); //null 
            //A qui entrando 
       if(null !== localStorage.getItem("User")) {
              //A qui entrando a esta función 
        //alert(3);
           let item = JSON.parse(localStorage.getItem("User"));
       //    console.log(item);
           
         if(0 < item.IdUsuario){
                //Este el menu display lo bloqueamos cuando cerramos la session
                   document.getElementById('menuNavbar1').style.display = 'block';            
               }
            }
        }
    }
  sessionClose() {
    localStorage.removeItem("user");
   // alert("uno");
   document.getElementById('menuNavbar1').style.display = 'none';
 
}
}
