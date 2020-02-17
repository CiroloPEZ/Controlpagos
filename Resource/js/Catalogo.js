/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Catalogo {

    getCatalogo(valor) {
       
        //Operador ternario no si si 
        //Enviamos la variable valor como null para que deje buscar 
        var valor = valor != null ? valor : "";

        $.post(
                //Controlador de catalogos manda la informacion ahi
                URL + "Catalogo/getCatalogo",
                {
                    filter: valor,
                },
                (response) => {
            //  console.log(response);
            try {
                let item = JSON.parse(response);
                $("#resultCatalogo").html(item.dataFilter);
                //   $("#paginador").html(item.paginador);
            } catch (error) {

            }
        });
    }
    //Metodo para mostral el historial de pagos 
    getHiscatalogo(valor) {
        
       var valor = valor !=null ? valor : "";
        $.post(
                URL + "Catalogo/getHiscatologo",
                {
                    filter: valor,
                },
                (response) => {
                    console.log(response);
            try {
                let item = JSON.parse(response);
                $("#resultHiscatalogo").html(item.dataFilter);
            } catch (error) {

            }

        });
    }

}