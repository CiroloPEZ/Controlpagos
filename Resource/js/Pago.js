
class Pago {
      constructor() {
        //Crearemos unas propiedades
        this.Funcion = 0;
        this.Id_pago = 0;
    }
    
//Mostramos los datos en nuestras vista
//Valor se refiere a todos los valores que devuela nuestro contraldor

    getPago(valor) {
    
//Operador ternario no si si 
//Enviamos la variable valor como null para que la deje de buscar
       
        var valor = valor != null ? valor : "";
        $.post(
                //Controlador usuarios mandamos los datos 
                URL + "Pago/getPago",
                
                {
                    filter: valor, //La informacison que insertamos en el camp0o de texto9
                    //En caso de no tener nada se envia un 0 o null
                },
                (response) => {
      //           console.log(response);
            try {
                let item = JSON.parse(response);

                $("#resultPago").html(item.dataFilter);
                $("#paginador").html(item.paginador);
            } catch (error) {

            }

        });
    }
 //Metodo para insertar el vencimiento de un pago de un cliente
    getCalculoFechas() {
        //El data esta vacio
        var url = "Pago/revisarFecha";
        var   data =  new Date();
       $.ajax({
            //La url quedaria a si http://localhost/Fecha_pago/Pago/revisarFecha que seria nuestro metodo
            url: URL + url,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: (response) => {
                 console.log(response);
              //  document.getElementById("detePagoMessagge").innerHTML = response;
                stop();
            }
        });
    }
//Metodo para mostrar datos en metodo realizar pago
    pago(data) {
        this.Funcion = 1;
        document.getElementById("Nombre").value = data.Nombre;
        document.getElementById("Email").value = data.Email;
        document.getElementById("Folio").value = data.Folio;
        document.getElementById("Fecha_pago").value = data.Fecha_pago;
        
    }
 //Funcion para
 Comprobarpago(){
    
    //Evitara que el formulario se cierre
        let valor = false;
     if (validarEmail(($("#Email").val()))) {
         
        
        var data = new FormData();
        
        var url = "Pago/Comprobarpago";
    

     data.append('Id_pago', this.Id_pago);
     data.append('Mes', this.Mes);
     data.append('Valor', this.Valor);
     data.append('Estatus', this.Estatus);
     data.append('Nombre', $("#Nombre").val());
     data.append('Email', $("#Email").val());
     data.append('Folio', $("#Folio").val());
     data.append('Fecha_pago', $("#Fecha_pago").val());
     data.append('Proxima_fecha', this.Proxima_fecha);
     data.append('Cantidad', $("#Cantidad").val());
         
     $.ajax({
            url: URL + url,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
          success:(response)=> {
               
               document.getElementById("PagoMessagge").innerHTML = response;
               stop();
               valor = false;
           }
         });
  }else{ 
      document.getElementById("Email").focus();
      document.getElementById("PagoMessagge").innerHTML = 'Ingresar un correo valido';
      return valor;
     }
   }
 }