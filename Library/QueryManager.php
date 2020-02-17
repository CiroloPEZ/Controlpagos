<?php

//La query manager no ayuda a generar todas las consulta en nuestro codigo
Class QueryManager {

    private $pdo;

    function __construct($USER, $PASS, $DB) {
        try {
            //Metodo de conexion universal
            $this->pdo = new PDO('mysql:host=localhost;dbname=' . $DB . ';charser=utf8'
                    , $USER, $PASS, [
                PDO::ATTR_EMULATE_PREPARES => false, //Evitamos un ataque de inyecion
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                    ]
            );
        } catch (Exception $e) {
            print "¡Error!: " . $e->getMessage();
            die();
        }
    }

    /* Metodos acceso a la base de datos en general */
//A qui hacemos un select*from para un dato en especifco 
    function select1($attr, $table, $where, $param) {
        try {

            $where = $where ?? "";

            $query = "SELECT " . $attr . " FROM " . $table . $where; //Seleccioname la table usuarios de la tabla usuarios dond email se email
            $sth = $this->pdo->prepare($query);
            $sth->execute($param);
            $response = $sth->fetchAll(PDO::FETCH_ASSOC); //A qui tomo los datos de la consulta
            //Almacenamos en un array la respueste que devuelve nuestro servidor
            return array("results" => $response);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        $pdo = null;
    }
//A qui hacemos un select en general  
    function select2($attr, $table, $where, $param){
        try {
            
             $where = $where ?? "";
            $query = "SELECT " . $attr . " FROM " . $table . $where; //Seleccioname la table usuarios de la tabla usuarios dond email se email
            $sth = $this->pdo->prepare($query);
            $sth->execute();
            $response= $sth->fetchAll(PDO::FETCH_ASSOC);//A qui tomos los datos de la consulta y los guardo en array parecido
            //Almacenamos en un array la respuesta del servido 
            return array("results"=>$response);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        
    }
    //Este es un insert1 pero si la necsidad de un where
     function insert1($table, $param, $value){
       try{
          //A qui insertamos los datos de acuerdo a la tabla con una evaluacion de informacion
           $query = "INSERT INTO ".$table.$value;
           $sth = $this->pdo->prepare($query);
           //Obtenemos los datos del array y ese array va obtener los datos de clase anonima
           $sth->execute((array)$param);
           
           return true;
        } catch (Exception $ex) {
            return $ex->getMessage() ;
       } 
       $pdo = null;
    }
    
    //Este nada mas es para inserta un dato de acuerdo al ID
    //Table recibe en nombre de la table, parametro recibe los parametos, value recibe la informacion que va a ser insertada
    function insert($table, $param, $value, $where) {
        try {
            //A qui insertamos los datos de acuerdo a la tabla con una evaluacion de informacion
        $query = " INSERT INTO " . $table . " SET " . $value . $where;

            $sth = $this->pdo->prepare($query);
            //Obtenemos los datos del array y ese array va obtener los datos de clase anonima
            $sth->execute((array) $param);

            return true;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
        $pdo = null;
    }

    function update($table, $param, $value, $where) {
        try {
            $query = " UPDATE " . $table . " SET " . $value . $where;
            $sth = $this->pdo->prepare($query);
            $sth->execute((array) $param);
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        $pdo = null;
    }
    
function delete($table, $where, $param) {
   try{
      $query = "DELETE FROM ".$table. $where;
      $sth = $this->pdo->prepare($query);
        $sth->execute($param);
      return true;
    }catch(PDOException $e){
      return $e->getMessage();
   } 
    $pdo = null;
  }
}

?>