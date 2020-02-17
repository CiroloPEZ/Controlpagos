
var data_Cliente = null;

//////////////////////Metodos para logear a un usuario
var us = new Usuarios();//Instaciamos la clase usuarios de java script

var loginUser = () => {
    //A qui obtenemos el formulario los datos del formulario del evento onclick 
    us.loginUser();
}
var sessionClose = ()=>{
    us.sessionClose();
}

/////////////////////Seción donde estan la funciónes de los clientes
var cliente = new Clientes();

$(function () {
    //Para registrar
    $("#registerCliente").click(function (){
        return cliente.registerCliente();
    });
    //Pára editar cliente 
    $("#rCliente").click(function (){
        
       return cliente.ediCliente(); 
    });
    //Metodo para realizar los pagos
    $("#pagos").click(function () {
       
       return cliente.realizarPago();     
     //  data_pago = null;
    });

    //Metodo para borra cliente
     $("#deleteCliente").click(function (){
       
      cliente.deleteCliente(data_Cliente); 
      data_Cliente = null;
   });
   
  
});
//Metodo para buscar nuestro cliente  por nombre y apellido
var getCliente = () => {
    let valor = document.getElementById("filtrarCliente").value;
    cliente.getCliente(valor);
   
}

//Para cargar la informacion en nuestro campos 
//data recibimos los parematros
//Metodo para editar cliente
var dataCliente = (data) =>{
      cliente.editCliente(data);
}
//Para borrar
var deleteCliente = (data) => {
        document.getElementById("userName").innerHTML = data.Email;
      data_Cliente = data;
}
///////////Metodos para realizar los pagos del clien
var pago = new Pago();


//Mostrar datos en modal de pagos
//pagoCliente es igual a pagoCliente(" . $dataCliente . ")' hace referencia
var pagoCliente = (data) => {
     document.getElementById("userName2").innerHTML = data.Id_pago;
     document.getElementById("cantidad").innerHTML = data.Valor;
     document.getElementById("Proximafecha").innerHTML = data.Proxima_fecha;
     pago.pago(data);
     data_pago = data; 
}
//Buscamos todos los registros que tenga la palabra vencidos
var getPago = () => {
    //Validamos si tiene la opcion de vencido activada 
   let valor = document.getElementById("filtraPago").value;
   pago.getPago(valor);

}
//////////Metodo para realizar el calculo de la fecha
//Revisar bien estas funciones
$(function (){
   $("#revisarFecha").click(function () {
      return pago.getCalculoFechas();
    });
    //Pára editar cliente 
   $("#Comprobarp").click(function (){
      return pago.Comprobarpago(); 
    });
});
//////////////////Seccion para mostrar datos de los pagos 
var catalogo = new Catalogo();

var getCatalogo = () => {
      console.log(34);
      let valor = document.getElementById("filtrarCatalogo").value;
      catalogo.getCatalogo(valor);
  
   }

//Cargamos los datos 
 var getHiscatalogo = (data) => {  
      document.getElementById("hist").innerHTML = data.Email;
     let valor = document.getElementById("filtraHistorial").value = data.Email;
     
    catalogo.getHiscatalogo(valor);
 }

var principal = new Principal();
//Funciones que se ejecuta al inicio de la pagina 
$().ready(()=>{
     
    
      let URLactual = window.location.pathname;
  
      principal.linkPrincipal(URLactual);
       
      

       us.userData(URLactual);
     
  //  getVencimiento(1);
  
});
