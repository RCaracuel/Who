<?php
session_name("who");
session_start();
require "funcion.php";

if (isset($_POST["salir"])) {
    session_destroy();
    header("location:index.php");
    exit;
}
if (isset($_SESSION["nombre"])) {


    if (isset($_SESSION["nombre"])) {
        // echo "Hola";
        $ahora = time();
        $tiempo_transcurrido = $ahora - $_SESSION["ultimo_acceso"];
        if ($tiempo_transcurrido > 60 * 10) {
            session_unset();
            $_SESSION["tiempo"] = "El tiempo de sesión ha expirado";
            header("Location:index.php");
            exit;
        } else {
            $_SESSION["ultimo_acceso"] = time();

            $obj = consumir_servicio_REST(URL . "/top10", "POST");
            //var_dump($obj);
            foreach ($obj->top as $inmueble) {

               // echo $inmueble->garaje;
            }
                include "prueba.php";
          }
    } else {
        session_unset();
        $_SESSION["intruso"] = "";
        header("location:index.php");
        exit;
    }
} else {
    session_unset();
    $_SESSION["intruso"] = "";
    header("location:index.php");
    exit;
} ?>