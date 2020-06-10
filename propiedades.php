<?php

$error_hab = false;
$error_distancia = false;
$error_m2 = false;
$error_localidad = false;
$error_idufir = false;
if (isset($_POST["agregar"])) {
    $error_hab = $_POST["habitaciones"] == "";
    $error_distancia = $_POST["distancia"] == "";
    $error_m2 = $_POST["m2"] == "";
    $error_localidad = $_POST["localidad"] == "";
    $error_idufir = $_POST["idufir"] == "";
    $error_idufir_long = strlen($_POST["idufir"]) != 14;
    // echo strlen($_POST["idufir"]);

    $error_propiedades = $error_hab || $error_distancia || $error_m2 || $error_localidad || $error_idufir || $error_idufir_long;

    if (!$error_propiedades) {
        $terraza = isset($_POST["terraza"]);
        $piscina = isset($_POST["piscina"]);
        $garaje = isset($_POST["garaje"]);
        $jardin = isset($_POST["jardin"]);

        $inmueble = array(
            "codigo" => $_SESSION["id_usu"],
            "habitaciones" => $_POST["habitaciones"],
            "terraza" => $terraza,
            "piscina" => $piscina,
            "garaje" => $garaje,
            "jardin" => $jardin,
            "distancia" => $_POST["distancia"],
            "m2" => $_POST["m2"],
            "idufir" => $_POST["idufir"],
            "localidad" => $_POST["localidad"]
        );

        //var_dump($inmueble);

        $obj = consumir_servicio_REST(URL . "/insertar_propiedad", "POST", $inmueble);
        // var_dump($obj);


    }
}

if(isset($_POST["baja"])){


    if(isset($_POST["casa"])){
       // var_dump($_POST["casa"]);
        
       $obj=consumir_servicio_REST(URL."/baja_propiedad/".$_POST["casa"], "PUT");
     //  var_dump($obj);


    }
}

if(isset($_POST["alta"])){


    if(isset($_POST["casa2"])){
       // var_dump($_POST["casa"]);
        
       $obj=consumir_servicio_REST(URL."/alta_propiedad/".$_POST["casa2"], "PUT");
      // var_dump($obj);


    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/principal.css">
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@500&family=Montserrat&display=swap" rel="stylesheet">
    <title>Página principal</title>

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
                <li class="oculto"><button type="input" name="perfil">PERFIL</button></li>
                <li><button type="input" name="buscar">BUSCAR</button></li>
                <li><button type="input" name="contratos">CONTRATOS</button></li>
                <li><button type="input" name="propiedades">PROPIEDADES</button></li>
                <li><button type="input" name="salir">SALIR</button></li>
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

<input <?php if (isset($_POST["mis_propiedades"])) echo 'style="background-color:#ed217d"'; ?> type='submit' name='mis_propiedades' class="titulo_prueba" value='Mis Propiedades'>

<input <?php if (isset($_POST["add_propiedad"])) echo 'style="background-color:#ed217d"'; ?>type='submit' name='add_propiedad' class="titulo_prueba" value='Añadir propiedad'>

<input <?php if (isset($_POST["dar_baja"])) echo 'style="background-color:#ed217d"'; ?> type='submit' name='dar_baja' class="titulo_prueba" value='Dar de baja'>
<input <?php if (isset($_POST["dar_alta"])) echo 'style="background-color:#ed217d"'; ?> type='submit' name='dar_alta' class="titulo_prueba" value='Dar de alta'>


</form>
        </section>
        <section id="grande2">
                            <?php

                            if(isset($_POST["add_propiedad"])){
                                    ?>

<article>
                    <form action="principal.php" method="post">

                        <input class="formu2" id="habitaciones" name="habitaciones" type="text" min="1" pattern="^[0-9]+" placeholder="Nº Habitaciones">
                        <?php if (isset($error_habitaciones)) echo '<span class="error">*</span>'; ?>
                        <input class="formu2" id="distancia" name="distancia" type="text" min="1" pattern="^[0-9]+" placeholder="Distancia al centro">


                        <input id="m2" class="formu2" name="m2" type="text" min="1" pattern="^[0-9]+" placeholder="M2">


                        <input id="idufir" class="formu2" name="idufir" type="text" min="1" required pattern="[0-9]{14}" placeholder="IDUFIR">

                        <input class="formu2" id="localidad" name="localidad" type="text" placeholder="Localidad">

                        <div class="container">
                            <ul class="ks-cboxtags">
                                <li><input type="checkbox" id="checkboxOne" name="terraza"><label for="checkboxOne">Terraza</label></li>
                                <li><input type="checkbox" id="checkboxTwo" name="jardin"><label for="checkboxTwo">Jardín</label></li>
                                <li><input type="checkbox" id="checkboxThree" name="piscina"><label for="checkboxThree">Piscina</label></li>
                                <li><input type="checkbox" id="checkboxFour" name="garaje"><label for="checkboxFour">Garaje</label></li>
                            </ul>
                        </div>

                        <input class="sub" type="submit" name="agregar" value="Agregar" />
                        <input type="hidden" class="edita_peque" name="edita_peque" />
                        <?php


                        // echo "** Campo vacío o incorrecto **";

                        ?>
                    </form>
                </article>


<?php
                            }elseif(isset($_POST["dar_baja"])){
                                ?>
<article>
                    <p>
                        Las propiedad o propiedades que se den de baja no aparecerá en las búsquedas de otros usuarios pero permanecerán en nuestra base de datos.
                    </p>
                    <p>
                        A continuación seleccione la propiedad  que desea dar de baja de nuestro servicio:</p>
                        <div class="container">
                            <form action="principal.php" method="post">
                            <ul class="ks-cboxtags">

                                <?php

                            $obj = consumir_servicio_REST(URL . "/buscar_propiedades/" . $_SESSION["id_usu"], "GET");
                            //var_dump($obj);
                            if (isset($obj->sin_propiedades)) {
                                echo "<article>";

                                echo "No tiene ninguna propiedad registrada";

                                echo "</article>";
                            } elseif (isset($obj->propiedades)) {
                                // var_dump($obj);

                                $contador=1;
                                foreach ($obj->propiedades as $inmueble) {
                                   // echo $inmueble->cod_inmueble;
                                echo "<li><input type='radio' id='checkboxOtro".$contador."' name='casa' value='".$inmueble->cod_inmueble."'><label for='checkboxOtro".$contador."'>Cod. ".$inmueble->cod_inmueble." - Loc. ".$inmueble->localidad."</label></li>";
                            
                                $contador++;

                                }
                            }


                                ?>
                     
                            </ul>
                            <input type="submit" class="sub" name="baja" value="Dar de baja"/>
                            </form>
                        </div>
                   
                </article>

<?php
                            }elseif(isset($_POST["dar_alta"])){
                                ?>

<article>
                      
                        
                            
                           

                                <?php

                            $obj = consumir_servicio_REST(URL . "/buscar_propiedades_baja/" . $_SESSION["id_usu"], "GET");
                            //var_dump($obj);
                            if (isset($obj->sin_propiedades)) {
                                echo "<article>";

                                echo "<p>No tiene ninguna propiedad dada de baja</p>";

                                echo "</article>";
                            } elseif (isset($obj->propiedades)) {
                                // var_dump($obj);

                                $contador=1;
                                echo "<p>A continuación seleccione la propiedad  que desea dar de alta en nuestro servicio</p>";

                                echo "<form action='principal.php' method='post'>";
                                echo "<div class='container'>";
                               echo "<ul class='ks-cboxtags'>";
                                foreach ($obj->propiedades as $inmueble) {
                                   // echo $inmueble->cod_inmueble;
                                   
                                echo "<li><input type='radio' id='checkboxOne".$contador."' name='casa2' value='".$inmueble->cod_inmueble."'><label for='checkboxOne".$contador."'>Cod.".$inmueble->cod_inmueble." - Loc. ".$inmueble->localidad."</label></li>";
                            
                                $contador++;

                                }
                                echo "</div>";
                            }


                                ?>
                        <input type="submit" class="sub" name="alta" value="Dar de alta"/>
                            </ul>
                         
                            </form>
                        
                            </article>


<?php
                            }
                            else{

                                ?>
                        
                <?php

$obj = consumir_servicio_REST(URL . "/buscar_propiedades/" . $_SESSION["id_usu"], "GET");

if (isset($obj->sin_propiedades)) {
    echo "<article>";

    echo "<p>No tiene ninguna propiedad registrada</p>";

    echo "</article>";
} elseif (isset($obj->propiedades)) {
    // var_dump($obj);
    echo "<span class='titulo2'>Mis Propiedades</span>";

    foreach ($obj->propiedades as $inmueble) {

        echo "<article>";
        // echo "hola";
        //echo $inmueble->imagen;

        if (!$inmueble->imagen)
            $foto_casa = "no_foto.jpg";
        else
            $foto_casa = $inmueble->imagen;

        echo "<p><span class='destino'>Casa " . $inmueble->cod_inmueble . "</span>";
        echo "<br/>";
        echo "<img src='img/" . $foto_casa . "' alt='foto_casa'/>";
        echo "Localidad: " . $inmueble->localidad;
        echo "<br/>";
        echo "Distancia centro: " . $inmueble->distancia_centro . "km";
        echo "<br/>";
        echo "M2: " . ($inmueble->m2);
        echo "<br/>";
        echo "Nº Habitaciones: " . $inmueble->num_hab;
        echo "<br/>";
        echo "Garaje: " . ($inmueble->garaje == 0 ? "No" : "Si");
        echo "<br/>";
        echo "Terraza: " . ($inmueble->terraza == 0 ? "No" : "Si");
        echo "<br/>";
        echo "Jardín: " . ($inmueble->jardin == 0 ? "No" : "Si");
        echo "<br/>";
        echo "Piscina: " . ($inmueble->piscina == 0 ? "No" : "Si");
        echo "<br/>";
        echo "Puntuación: ";
        $estrellas = (int) $inmueble->estrellas;

        for ($i = 0; $i < $estrellas; $i++) {
            echo "⭐";
        }
        echo "</p>";
        echo "</article>";
    }
}

?>
</article>

<?php
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