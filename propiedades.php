<?php

$error_hab = false;
$error_distancia = false;
$error_m2 = false;
$error_localidad = false;
$error_idufir = false;
if (isset($_POST["agregar"])) {
    $error_hab = $_POST["habitaciones"]=="";
    $error_distancia = $_POST["distancia"]=="";
    $error_m2 = $_POST["m2"]=="";
    $error_localidad = $_POST["localidad"]=="";
    $error_idufir = $_POST["idufir"]=="";
    $error_idufir_long=strlen($_POST["idufir"])!=14;
   // echo strlen($_POST["idufir"]);

    $error_propiedades=$error_hab||$error_distancia||$error_m2||$error_localidad||$error_idufir||$error_idufir_long;

    if(!$error_propiedades){
        $terraza=isset($_POST["terraza"]);
        $piscina=isset($_POST["piscina"]);
        $garaje=isset($_POST["garaje"]);
        $jardin=isset($_POST["jardin"]);
    
        $inmueble=array(
            "codigo"=>$_SESSION["id_usu"],
            "habitaciones"=>$_POST["habitaciones"],
            "terraza"=>$terraza,
            "piscina"=>$piscina,
            "garaje"=>$garaje,
            "jardin"=>$jardin,
            "distancia"=>$_POST["distancia"],
            "m2"=>$_POST["m2"],
            "idufir"=>$_POST["idufir"],
            "localidad"=>$_POST["localidad"]
        );
        
        //var_dump($inmueble);

        $obj=consumir_servicio_REST(URL."/insertar_propiedad","POST",$inmueble);
      //  var_dump($obj);

    
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/principal.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@600&display=swap" rel="stylesheet">
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
            <p>
              <span class="titulo"> Mis propiedades</span>
            </p>
            <div class="oculta">

                <?php

                $obj = consumir_servicio_REST(URL . "/buscar_propiedades/" . $_SESSION["id_usu"], "GET");
                if (isset($obj->sin_propiedades)) {
                    echo "<article>";

                    echo "No tiene ninguna propiedad registrada";

                    echo "</article>";
                } elseif (isset($obj->propiedades)) {
                    // var_dump($obj);
                    echo "<span class='titulo2'>Mis Propiedades</span>";

                    foreach ($obj->propiedades as $inmueble) {

                        echo "<article>";
                        // echo "hola";
                        //echo $inmueble->imagen;
                        
                        if(!$inmueble->imagen)
                        $foto_casa="no_foto.jpg";
                        else
                        $foto_casa=$inmueble->imagen;
                        
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
            </div>
            <p>
            <span class="titulo">  Añadir propiedad </span>
            </p>
            <div class="oculta">
                <article>
                    <form action="principal.php" method="post">
                    <span class="titulo"> Añadir propiedad:</span>
                        <br />
                
                        <br />
                        <table>
                            <tr>
        
                                <td><input  class="formu2" id="habitaciones" name="habitaciones" type="text" min="1" pattern="^[0-9]+" placeholder="Nº Habitaciones">
                                    <?php if (isset($error_habitaciones)) echo '<span class="error">*</span>'; ?></td>
                            </tr>
                            <tr>
                                <td> <label for="terraza">Terraza:&nbsp;&nbsp;&nbsp;</label>
                                <input type="checkbox" id="terraza" name="terraza" />
                                </td>
                            </tr>
                            <tr>
                                <td> <label for="jardin">Jardín:&nbsp;&nbsp;&nbsp;</label>

                                    <input type="checkbox" id="jardin" name="jardin" />

                                </td>
                            </tr>
                            <tr>
                                <td> <label for="piscina">Piscina:&nbsp;&nbsp;&nbsp;</label>
                               
                                    <input type="checkbox" id="piscina" name="piscina" />

                                </td>
                            </tr>
                            <tr>
                                <td> <label for="garaje">Garaje:&nbsp;&nbsp;&nbsp;</label>
                                
                                    <input type="checkbox" id="garaje" name="garaje" />

                                </td>
                            </tr>
                            <tr>
                                
                                <td><input  class="formu2" id="distancia" name="distancia" type="text" min="1" pattern="^[0-9]+" placeholder="Distancia al centro">
                            </tr>
                            <tr>

                                <td><input id="m2" class="formu2" name="m2" type="text" min="1" pattern="^[0-9]+" placeholder="M2">
                            </tr>
                            <tr>

                                <td><input id="idufir"class="formu2" name="idufir" type="text" min="1" required pattern="[0-9]{14}" placeholder="IDUFIR">
                            </tr>
                            <tr>
                                <td><input class="formu2" id="localidad" name="localidad" type="text" placeholder="Localidad">
                            </tr>
                        </table>

                        <input class="sub" type="submit" name="agregar" value="Agregar" />
                        <br />
                        <br />
                        <input type="hidden" class="edita_peque" name="edita_peque" />
                        <?php


                        // echo "** Campo vacío o incorrecto **";

                        ?>
                    </form>
                </article>
            </div>
            <p>
            <span class="titulo">  Editar propiedad </span>
            </p>
            <div class="oculta">

            </div>
            <p>
            <span class="titulo">   Dar de baja </span>
            </p>
            <div class="oculta">

            </div>
        </section>
        <section id="grande">

            <?php

            if (isset($_POST["agregar"]) && ($error_propiedades)) {
            ?>
                <article>
                <form action="principal.php" method="post">
                    <span class="titulo"> Añadir propiedad:</span>
                        <br />
                
                        <br />
                        <table>
                            <tr>
        
                                <td><input  class="formu2" id="habitaciones" name="habitaciones" type="text" min="1" pattern="^[0-9]+" placeholder="Nº Habitaciones">
                                    <?php if (isset($error_habitaciones)) echo '<span class="error">*</span>'; ?></td>
                            </tr>
                            <tr>
                                <td> <label for="terraza">Terraza:&nbsp;&nbsp;&nbsp;</label>
                                <input type="checkbox" id="terraza" name="terraza" />
                                </td>
                            </tr>
                            <tr>
                                <td> <label for="jardin">Jardín:&nbsp;&nbsp;&nbsp;</label>

                                    <input type="checkbox" id="jardin" name="jardin" />

                                </td>
                            </tr>
                            <tr>
                                <td> <label for="piscina">Piscina:&nbsp;&nbsp;&nbsp;</label>
                               
                                    <input type="checkbox" id="piscina" name="piscina" />

                                </td>
                            </tr>
                            <tr>
                                <td> <label for="garaje">Garaje:&nbsp;&nbsp;&nbsp;</label>
                                
                                    <input type="checkbox" id="garaje" name="garaje" />

                                </td>
                            </tr>
                            <tr>
                                
                                <td><input  class="formu2" id="distancia" name="distancia" type="text" min="1" pattern="^[0-9]+" placeholder="Distancia al centro">
                            </tr>
                            <tr>

                                <td><input id="m2" class="formu2" name="m2" type="text" min="1" pattern="^[0-9]+" placeholder="M2">
                            </tr>
                            <tr>

                                <td><input id="idufir"class="formu2" name="idufir" type="text" min="1" required pattern="[0-9]{14}" placeholder="IDUFIR">
                            </tr>
                            <tr>
                                <td><input class="formu2" id="localidad" name="localidad" type="text" placeholder="Localidad">
                            </tr>
                        </table>

                        <input class="sub" type="submit" name="agregar" value="Agregar" />
                        <br />
                        <br />
                        <input type="hidden" class="edita_peque" name="edita_peque" />
                        <?php


                        // echo "** Campo vacío o incorrecto **";

                        ?>
                    </form>
                </article>
            <?php
            } else {
                $obj = consumir_servicio_REST(URL . "/buscar_propiedades/" . $_SESSION["id_usu"], "GET");
                if (isset($obj->sin_propiedades)) {
                    echo "<article>";

                    echo "No tiene ninguna propiedad registrada";

                    echo "</article>";
                } elseif (isset($obj->propiedades)) {
                    // var_dump($obj);
                    echo " <span class='titulo2'>Mis Propiedades</span>";
                    foreach ($obj->propiedades as $inmueble) {

                        echo "<article>";
                        // echo "hola";
                        //echo $inmueble->imagen;
                          
                        if(!$inmueble->imagen)
                        $foto_casa="no_foto.jpg";
                        else
                        $foto_casa=$inmueble->imagen;
                        
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
    <script type="text/javascript" src="JS/jquery-3.5.1.js"></script>
    <script>
        $(document).ready(function() {


            $("#titulares").on("click", "p:not(.oculta)", function() {
                //console.log("hola");
                if ($(window).width() < 1000)
                    $(this).next().fadeToggle(800);

                $("#grande").html($(this).next().html());


            });

            $(window).resize(function() {
                // console.log("hola");
                if ($(window).width() > 1000)
                    $("#titulares .oculta").hide();

            })

        })
    </script>
</body>

</html>