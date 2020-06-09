<?php

$error_foto = true;
if (isset($_POST["subir"])) {

    // var_dump($_FILES["foto2"]);
    $error_foto = ($_FILES["foto2"]["name"] == "" || $_FILES['foto2']['error'] || !getimagesize($_FILES['foto2']['tmp_name']));
    $arr = explode(".", $_FILES['foto2']['name']); //separador por el punto
    $extension = end($arr); // del array obtenido antes quiero la última posición, la extensión

    $nombre_unico = $_SESSION["id_usu"];
    $foto_bd = $nombre_unico . "." . $extension;
    $datos = array(
        "foto" => $foto_bd
    );

    $obj = consumir_servicio_REST(URL . "/cambiar_foto/" . $_SESSION["email"], "PUT", $datos);
    //  var_dump($obj);
    if (isset($obj->mensaje_exito)) {
        @$var = move_uploaded_file($_FILES['foto2']['tmp_name'], "img/" . $foto_bd);
    } else {
        echo $obj->mensaje;
    }
}



if (isset($_POST["crear"])) {
    $datos_contrato = array(
        "inquilino" => $_SESSION["codigo_inquilino"],
        "inmueble" => $_POST["inmueble"],
        "inicio" => $_POST["fecha_ini"],
        "fin" => $_POST["fecha_fin"]
    );

    $ahora = date("Y-m-d");

    if ($_POST["fecha_fin"] >= $_POST["fecha_ini"] && $_POST["fecha_ini"] >= $ahora) {
        $obj = consumir_servicio_REST(URL . "/insertar_contrato", "POST", $datos_contrato);
        // echo "correcto";
    } else {
        echo "Fechas incorrectas";
    }
}

if (isset($_POST["continuar"])) {


    $datos_nuevo = array(
        "nombre" => $_POST["nombre"],
        "apellidos" => $_POST["apellidos"],
        "dni" => $_POST["dni"]
    );
    $obj = consumir_servicio_REST(URL . "/registro_contrato", "POST", $datos_nuevo);
    // var_dump($obj);
    //  $_SESSION["codigo_inquilino"]=$obj->ultimo;
}

if (isset($_POST["finalizar_contrato"])) {
    echo "hola";
     echo $_POST["codigo_casa"];
    echo $_POST["codigo_inquilino"];
    echo $_POST["fecha_inicio_alquiler"];

}

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/principal.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@600&display=swap" rel="stylesheet">
    <title>Perfil usuario</title>

</head>

<body>
    <header>
        <a href="principal.php"> <img id="logo" src="img/logo.png" alt="logotipo" /></a>
        <input type="checkbox" id="ham" />
        <label for="ham" id="hamburguesa">
            <span></span>
            <span></span>
            <span></span>
        </label>
        <form action="principal.php" method="post">
            <ul id="menu">
                <li class="oculto"><button type="input" name="perfil">Perfil</button></li>
                <li><button type="input" name="buscar">Buscar</button></li>
                <li><button type="input" name="contratos">Contratos</button></li>
                <li><button type="input" name="propiedades">Propiedades</button></li>
                <li><button type="input" name="salir">Salir</button></li>
            </ul>
        </form>
        <div id="escritorio">
            <p><?php echo $_SESSION["nombre"]; ?></p>
            <?php
            $datos = array(
                "email" => $_SESSION["email"]
            );
            // var_dump($datos);

            $obj = consumir_servicio_REST(URL . "/usuario", "POST", $datos);
            $_SESSION["id_usu"] = $obj->usuario->cod_usuario;
            echo "<a href='principal.php?perfil'><img src='img/" . $obj->usuario->foto_perfil . "' alt='foto-perfil'/></a>"
            ?>

        </div>
    </header>
    <main>
        <section id="titulares">
            <form action="principal.php" method="post">

                <input <?php if (isset($_POST["crear_contrato"]) || isset($_POST["dni"])) echo 'style="background-color:#ed217d"'; ?> type='submit' name='crear_contrato' class="titulo_prueba" value='Crear contrato'>
                <input <?php if (isset($_POST["contrato_vigente"]) || isset($_POST["crear"])) echo 'style="background-color:#ed217d"'; ?> type='submit' name='contrato_vigente' class="titulo_prueba" value='Contratos Vigentes'>
                <input <?php if (isset($_POST["contrato_fin"])) echo 'style="background-color:#ed217d"'; ?>type='submit' name='contrato_fin' class="titulo_prueba" value='Contrato Finalizado'>

                <input type='submit' name='opiniones_usu' class="titulo_prueba" value='Opiniones Usuario'>


                <?php
                $obj = consumir_servicio_REST(URL . "/buscar_propiedades/" . $_SESSION["id_usu"], "GET");
                //var_dump($obj);
                if (isset($obj->propiedades)) {
                ?>


                    <input type='submit' name='consultar_inquilino' class="titulo_prueba" value='Consultar inquilino'>
                <?php
                }
                ?>

            </form>
        </section>
        <section id="grande2">

            <?php
            if (isset($_POST["contrato_fin"])) {
            ?>

                <article>
                    Ha pulsado Contratos finalizados
                </article>
            <?php
            }elseif(isset($_POST["crear"]) || isset($_POST["contrato_vigente"])){
                $obj = consumir_servicio_REST(URL . "/buscar_propiedades/" . $_SESSION["id_usu"], "GET");
                            if (isset($obj->sin_propiedades)) {
                                echo "<article>";

                                echo "No tiene ninguna propiedad registrada";

                                echo "</article>";
                            } else{
                                $obj=consumir_servicio_REST(URL."/buscar_contratos/".$_SESSION["id_usu"],"GET");
                             //   var_dump($obj);
                                $contador_contratos=1;
                                foreach ($obj->contratos as $contrato) {

                                    echo "<article>";
                                    // echo "hola";
                                    //echo $inmueble->imagen;
                
                                    echo "<p><span class='destino'>Contrato Nº " . $contador_contratos . "</span>";
                                    echo "<br/>";
                                    echo "Localidad " . $contrato->localidad;
                                    echo "<br/>";
                                    echo "Fecha inicio  " . $contrato->fecha_ini;
                                    echo "<br/>";
                                    echo "Fecha inicio  " . $contrato->fecha_fin;
                                    echo "</p>";
                                   
                                    
                            echo "<form action='principal.php' method='post'>";
                echo "<input type='hidden' name='codigo_casa' value='".$contrato->cod_inmueble."'/>";
                echo "<input type='hidden' name='codigo_inquilino' value='".$contrato->cod_usuario."'/>";
                echo "<input type='hidden' name='fecha_inicio_alquiler' value='".$contrato->fecha_ini."'/>";
               echo "<input class='sub' type='submit' name='finalizar_contrato' value='Finalizar contrato'/>";
            echo "</form>";
                                
                                    echo "</article>";
                                    $contador_contratos++;
                                }
                            }
            } else {
            ?>

                <article>



                    <?php
                    if (isset($_POST["buscar"]) && $_POST["dni"] != "" || isset($_POST["crear"]) || isset($_POST["continuar"])) {
                        if (isset($_POST["dni"]))
                            $_SESSION["dni"] = $_POST["dni"];

                        $dni_usu = array(
                            "dni" => $_SESSION["dni"]
                        );
                        $obj = consumir_servicio_REST(URL . "/buscar_dni_usuario", "POST", $dni_usu);
                        //var_dump($obj);
                        if (isset($obj->existe)) {
                            //var_dump($obj);
                            // echo $obj->codigo;

                            $_SESSION["codigo_inquilino"] = $obj->codigo;
                            // echo $_SESSION["codigo_inquilino"];

                            $obj = consumir_servicio_REST(URL . "/buscar_propiedades/" . $_SESSION["id_usu"], "GET");
                            if (isset($obj->sin_propiedades)) {
                                echo "<article>";

                                echo "No tiene ninguna propiedad registrada";

                                echo "</article>";
                            } elseif (isset($obj->propiedades)) {
                                if (isset($_POST["crear"])) {
                                    $fecha_inicio = $_POST["fecha_ini"];
                                    $fecha_fin = $_POST["fecha_fin"];
                                }
                    ?>

                                <form action="principal.php" method="post" enctype="multipart/form-data">

                                    <select class="titulo_prueba" name="inmueble">
                                        <?php
                                        foreach ($obj->propiedades as $inmueble) {
                                            if (isset($_POST["inmueble"]) && $inmueble->cod_inmueble == $_POST["inmueble"])
                                                echo "<option value='" . $inmueble->cod_inmueble . "' checked>" . $inmueble->cod_inmueble . "-" . $inmueble->localidad . "</option>";
                                            else
                                                echo "<option value='" . $inmueble->cod_inmueble . "' >" . $inmueble->cod_inmueble . "-" . $inmueble->localidad . "</option>";
                                        }
                                        ?>
                                    </select>
                                    <p> Fecha Inicio
                                        <br />
                                        <input class="formu" type="date" name="fecha_ini" value='<?php if (isset($_POST["crear"]))
                                                                                                        echo $_POST["fecha_ini"]; ?>' required>
                                    </p>
                                    <p>
                                        Fecha Fin
                                        <br />
                                        <input class="formu" type="date" name="fecha_fin" value='<?php if (isset($_POST["crear"]))
                                                                                                        echo $_POST["fecha_fin"]; ?>' required />
                                    </p>
                                    <br />
                                    <?php

                                    //traer opiniones de los inquilinos
                                    $obj = consumir_servicio_REST(URL . "/opiniones/" . $_SESSION["codigo_inquilino"], "GET");
                                    //ar_dump($obj);
                                    if ($obj != null) {
                                        $puntuacion = floor($obj->opiniones->puntuacion);
                                        if ($puntuacion > 5)
                                            $puntuacion = 5;
                                        echo "Puntuación: " . $puntuacion;
                                        echo "  (Total votaciones: " . $obj->opiniones->total . ")";
                                    }
                                    ?>
                                    <input class="sub" type="submit" name="crear" value="Crear contrato" />

                                </form>


                            <?php

                            }


                            ?>



                        <?php
                        } elseif (isset($obj->no_existe)) {
                        ?>
                            <form action="principal.php" method="post">

                                <p>
                                    <input class="formu" type="text" name="nombre" value="<?php if (isset($_POST["entrar"])) echo $_POST["nombre"]; ?>" placeholder="<?php if (isset($_POST["entrar"]) && $error_nombre) echo "Campo vacío";
                                                                                                                                                                        else echo "Nombre"; ?>" required />

                                </p>
                                <br />
                                <p>
                                    <input class="formu" type="text" name="apellidos" value="<?php if (isset($_POST["entrar"])) echo $_POST["apellidos"]; ?>" placeholder="<?php if (isset($_POST["entrar"]) && $error_apellido) echo "Campo vacío";
                                                                                                                                                                            else echo "Apellidos"; ?>" required />

                                </p>
                                <br />
                                <p>
                                    <input class="formu" type="text" name="dni" value="<?php if (isset($_POST["entrar"])) echo $_POST["dni"]; ?>" placeholder="<?php echo "DNI"; ?>" required pattern="(([X-Z]{1})([-]?)(\d{7})([-]?)([A-Z]{1}))|((\d{8})([-]?)([A-Z]{1}))" />

                                </p>
                                <br />
                                <p>
                                    <input class="sub" type="submit" name="continuar" value="Continuar" />

                                </p>








                            </form>

                        <?php
                        } else {
                            echo $obj->mensaje;
                        }
                    } else {
                        ?>
                        Crear Contrato
                        <br />
                        <br />
                        <form action="principal.php" method="post">
                            <p> <input pattern="(([X-Z]{1})([-]?)(\d{7})([-]?)([A-Z]{1}))|((\d{8})([-]?)([A-Z]{1}))" class="formu" type="text" name="dni" placeholder="Escriba dni del inquilino" value='<?php
                                                                                                                                                                                                            if (isset($_POST["dni"])) echo $_POST["dni"]; ?>' required />
                                <label for="buscar">🔎</label>
                                <input class="invisible" type="submit" id="buscar" name="buscar" />
                            </p>


                        </form>
                </article>
        <?php
                    }
                }
        ?>
        </section>
    </main>
    <footer>
        <p><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" alt="copyright">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M14 0C8.48 0 4 4.48 4 10C4 15.52 8.48 20 14 20C19.52 20 24 15.52 24 10C24 4.48 19.52 0 14 0ZM12.08 8.86C12.13 8.53 12.24 8.24 12.38 7.99C12.52 7.74 12.72 7.53 12.97 7.37C13.21 7.22 13.51 7.15 13.88 7.14C14.11 7.15 14.32 7.19 14.51 7.27C14.71 7.36 14.89 7.48 15.03 7.63C15.17 7.78 15.28 7.96 15.37 8.16C15.46 8.36 15.5 8.58 15.51 8.8H17.3C17.28 8.33 17.19 7.9 17.02 7.51C16.85 7.12 16.62 6.78 16.32 6.5C16.02 6.22 15.66 6 15.24 5.84C14.82 5.68 14.36 5.61 13.85 5.61C13.2 5.61 12.63 5.72 12.15 5.95C11.67 6.18 11.27 6.48 10.95 6.87C10.63 7.26 10.39 7.71 10.24 8.23C10.09 8.75 10 9.29 10 9.87V10.14C10 10.72 10.08 11.26 10.23 11.78C10.38 12.3 10.62 12.75 10.94 13.13C11.26 13.51 11.66 13.82 12.14 14.04C12.62 14.26 13.19 14.38 13.84 14.38C14.31 14.38 14.75 14.3 15.16 14.15C15.57 14 15.93 13.79 16.24 13.52C16.55 13.25 16.8 12.94 16.98 12.58C17.16 12.22 17.27 11.84 17.28 11.43H15.49C15.48 11.64 15.43 11.83 15.34 12.01C15.25 12.19 15.13 12.34 14.98 12.47C14.83 12.6 14.66 12.7 14.46 12.77C14.27 12.84 14.07 12.86 13.86 12.87C13.5 12.86 13.2 12.79 12.97 12.64C12.72 12.48 12.52 12.27 12.38 12.02C12.24 11.77 12.13 11.47 12.08 11.14C12.03 10.81 12 10.47 12 10.14V9.87C12 9.52 12.03 9.19 12.08 8.86ZM6 10C6 14.41 9.59 18 14 18C18.41 18 22 14.41 22 10C22 5.59 18.41 2 14 2C9.59 2 6 5.59 6 10Z" fill="#F2F2F2" />
            </svg>
        </p>
        <p> Todos los derechos reservados.
            Idea original de Rosa Caracuel Calderón
        </p>
    </footer>

</body>

</html>