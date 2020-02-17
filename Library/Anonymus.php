<?php

//A qui declaramos que solo sea estritamen lo que se reciban sean arrays
declare (strict_types = 1);

class Anonymus {
    
public  function clientesClass(array $array){
    return new class($array){
    var $Id_cliente;
    var $Nombre;
    var $Apellido_paterno;
    var $Apellido_materno;
    var $Email;
    var $Edad; 
    var $Fecha_inicio;
    var $Folio;
    
function __construct($array) {
    $this->Id_cliente = $array[0];
    $this->Nombre = $array[1];
    $this->Apellido_paterno = $array[2];
    $this->Apellido_materno = $array[3];
    $this->Email = $array[4];
    $this->Edad = $array[5];
    $this->Fecha_inicio = $array[6];
    $this->Folio = $array[7];
    }
   };
 }
 
//Clase para registrar datos de pago 
 public function pagosClass(array $array){
     
    return new Class($array){
       var $Id_pago;
       var $Nombre;
       var $Mes;
       var $Pago;
       var $Estatus;
       var $Folio;
       var $Fecha_pago;
  function __construct($array){
     $this->Id_pago = $array[0];
     $this->Nombre = $array[1];
     $this->Mes = $array[2];
     $this->Pago = $array[3];
     $this->Estatus = $array[4];
     $this->Folio = $array[5];
     $this->Fecha_pago = $array[6];
     $this->Proxima_fecha = $array[7];
     
     }
    };
    }
    public function pagoClass(array $array){
        return new Class($array){
            var $Nombre;
            var $Mes;
            var $Pago;
            var $Fecha_pago;
            var $Proxima_fecha;

            function __construct($array){
            $this->Nombre = $array[0];
            $this->Mes = $array[1];
            $this->Pago = $array[2];
            $this->Fecha_pago = $array[3];
            $this->Proxima_fecha = $array[4];
        }
             
        };
        
    }
}
?>