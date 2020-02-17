
class Clientes {

    constructor() {
        //Crearemos unas propiedades
        this.Funcion = 0;
        this.Id_cliente = 0;
    }

    registerCliente() {
        //Evitara que el formulario se cierre
        let valor = false;
        //Validamos el email que estamos ingresando  
        if (validarEmail(document.getElementById("Email").value)) {
            var data = new FormData();
            //Enviamos la informacion a nuestro controlador
            //Si la informacion es true asignaremos "Clientes/registerCliente"
            //Si es falso le asignaremos  "Clientes/editCliente"
            var url = this.Funcion == 0 ? "Clientes/registerCliente" : "";
            //Este es nuestro arreglo

            data.append('Id_cliente', this.Id_cliente);
            data.append('Nombre', $("#Nombre").val());
            data.append('Apellido_paterno', $("#Apellido_paterno").val());
            data.append('Apellido_materno', $("#Apellido_materno").val());
            data.append('Email', $("#Email").val());
            data.append('Fecha_inicio', $("#Fecha_inicio").val());
            data.append('Edad', $("#Edad").val());
            data.append('Folio', $("#Folio").val());
            //Utilizamos ajaz para enviar nuestro datos al servidor
            $.ajax({
                //La url quedaria a si http://localhost/Fecha_pago/Cliente/registerClienete que seria nuestro metodo
                url: URL + url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: (response) => {

                    document.getElementById("clienteMessage").innerHTML = response;
                    stop();
                    valor = false;
                }
            });
        } else {
            document.getElementById("Email").focus();
            document.getElementById("clienteMessage").innerHTML = 'Ingrese una dirección de corre válidad';
            return valor;
        }

    }
    ediCliente() {

        //Evitara que el formulario se cierre
        let valor = false;

        //Validamos el email que estamos ingresando  ghgjhgj

        if (validarEmail(($("#Email4").val()))) {
            var data = new FormData();
            //Enviamos la informacion a nuestro controlador

            //Si la informacion es true asignaremos "Clientes/registerCliente"
            //Si es falso le asignaremos  "Clientes/editCliente"
            var url = "Clientes/editCliente";
            //Este es nuestro arreglo

            data.append('Id_cliente', this.Id_cliente);
            data.append('Nombre', $("#Nombre1").val());
            data.append('Apellido_paterno', $("#Apellido_paterno2").val());
            data.append('Apellido_materno', $("#Apellido_materno3").val());
            data.append('Email', $("#Email4").val());
            data.append('Fecha_inicio', this.Fecha_inicio);
            data.append('Edad', $("#Edad5").val());
            data.append('Folio', $("#Folio6").val());
            //Utilizamos ajaz para enviar nuestro datos al servidor
            $.ajax({
                //La url quedaria a si http://localhost/Fecha_pago/Cliente/registerCliente que seria nuestro metodo
                url: URL + url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: (response) => {
                    console.log(response);
                  
                    var d = document.getElementById("clienMessage").innerHTML = "Error";
                 
                    stop();
                    valor = false;
                }
            });
        } else {
            document.getElementById("Email4").focus();
            document.getElementById("clienMessage").innerHTML = 'Ingrese una dirección de corre válidad';
            return valor;
        }

    }

    //Mostramos los datos en nuestras vista
//Valor se refiere a todos los valores que devuela nuestro contraldor
    getCliente(valor) {

//Operador ternario no si si 
//Enviamos la variable valor como null para que la deje de buscar
        var valor = valor != null ? valor : "";
        $.post(
                //Controlador usuarios mandamos los datos 
                URL + "Clientes/getCliente",
                {
                    filter: valor, //La informacison que insertamos en el camp0o de texto9
                    //En caso de no tener nada se envia un 0 o null
                },
                (response) => {
                // console.log(response);
            try {
                let item = JSON.parse(response);

                $("#resultCliente").html(item.dataFilter);
                $("#paginador").html(item.paginador);
            } catch (error) {

            }

        });
    }
  
    
    
    //Metodo para cargar datos en la vista 
    editCliente(data) {

        this.Funcion = 1;
        this.Id_cliente = data.Id_cliente;
        document.getElementById("Nombre1").value = data.Nombre;
        document.getElementById("Apellido_paterno2").value = data.Apellido_paterno;
        document.getElementById("Apellido_materno3").value = data.Apellido_materno;
        document.getElementById("Email4").value = data.Email;
        document.getElementById("Edad5").value = data.Edad;
        //  document.getElementById("Fecha_inicio").value = data.Fecha_inicio; 
        document.getElementById("Folio6").value = data.Folio;

    }
  

    deleteCliente(data) {
      //El data recimos datos de controlador 
        $.post(
                URL + "Clientes/deleteCliente",
                {
                    //A qui enviamos el id_cliente para borra de acuerdo al id
                  Id_cliente: data.Id_cliente,
                  email: data.Email
                },
                (response) => {
            if (response == 0) {
                this.restablecerClientes();
            } else {
                document.getElementById("deteUserMessagge").innerHTML = response;
            }

        });
    }

    restablecerClientes() {
        this.Funcion = 0;
        this.Id_cliente = 0;
        window.location.href = URL + "Principal/principal";
    }
}

