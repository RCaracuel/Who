<?php 

    require "config_bd.php";

    function conectar(){

        @$con=mysqli_connect(servidor,usuario,clave,bd);

        return $con;
    }



?>