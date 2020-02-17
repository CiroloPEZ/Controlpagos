<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class conexion {
            function __construct() {
                $this->db = new QueryManager("root", "","pagos");
            }
}
