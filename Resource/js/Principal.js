class Principal { //De la parte usuarios
constructor(){

}

//Metodo para cargar las paginas en un sola parte de la paginas web 
//link biene siendo la url actual 

linkPrincipal(link){
   
let url = "";
        let cadena = link.split("/");
        for (let i = 0; i < cadena.length; i++){
           if(i >= 2){
               url += cadena[i];
           }
        }
    // alert(url);
     //Este swicth se ejecuta cada vez que entramos a una url
switch(url){ 

    //A qui cargamos los metodos que se queremos que se ejecuten automaticamente
    //Evaluamos el la url que direcccion estamos para pasar por nuestro navegador
case "Principalprincipal":
    //Cargamos todo el link con los de usuarios/usuarios
       
        getCliente(1); 
        
        break;    
        case "Pagopago":
             getPago(1);
        break;  
}
}
}