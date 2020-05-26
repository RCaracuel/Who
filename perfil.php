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

$error_prueba = isset($_POST["modificar"]);
$error_nombre = false;
$error_apellidos = false;
$error_dni = false;
$dni_de_otro = false;
if (isset($_POST["modificar"])) {
    $error_nombre = $_POST["nombre"] == "";
    $error_apellidos = $_POST["apellidos"] == "";

    $error_todo_perfil = $error_nombre || $error_apellidos || $error_dni;

    if (!$error_todo_perfil) {

        $comprobar_dni = array(
            "dni" => $_POST["dni"],
            "email" => $_SESSION["email"]
        );

        $obj = consumir_servicio_REST(URL . "/buscar_dni/" . $_POST["dni"], "GET");
        //var_dump($obj);
        if (isset($obj->existe)) {
            $obj2 = consumir_servicio_REST(URL . "/buscar_dni_usuario", "POST", $comprobar_dni);
            // var_dump($obj2);
            if (isset($obj2->no_pertenece)) {
                $dni_de_otro = true;
            } elseif (isset($obj2->pertenece)) {
                $datos = array(
                    "nombre" => $_POST["nombre"],
                    "apellidos" => $_POST["apellidos"],
                    "dni" => $_POST["dni"]
                );

                $obj = consumir_servicio_REST(URL . "/cambiar_datos/" . $_SESSION["email"], "PUT", $datos);
                $_SESSION["nombre"] = $_POST["nombre"] . " " . $_POST["apellidos"];

                //  var_dump($obj);

            }
        } elseif (isset($obj->no_existe)) {

            $datos = array(
                "nombre" => $_POST["nombre"],
                "apellidos" => $_POST["apellidos"],
                "dni" => $_POST["dni"]
            );

            $obj = consumir_servicio_REST(URL . "/cambiar_datos/" . $_SESSION["email"], "PUT", $datos);
            // var_dump($obj);
            $_SESSION["nombre"] = $_POST["nombre"] . " " . $_POST["apellidos"];
        }
    }
    // echo $_POST["nombre"];

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
            $_SESSION["id_usu"]=$obj->usuario->cod_usuario;
            echo "<a href='principal.php?perfil'><img src='img/" . $obj->usuario->foto_perfil . "' alt='foto-perfil'/></a>"
            ?>

        </div>
    </header>
    <main>
        <section id="titulares">
            <p>
            <span class="titulo"> Datos personales</span>
            </p>
            <div class="oculta">

                <?php
                $datos = array(
                    "email" => $_SESSION["email"]
                );
                // var_dump($datos);

                $obj = consumir_servicio_REST(URL . "/usuario", "POST", $datos);
                echo "<article>";
                echo "<img id='perfil' src='img/" . $obj->usuario->foto_perfil . "' alt='imagen-perfil'/>";
                echo "<p id='perf'>Nombre: " . $obj->usuario->nombre . "</br>";
                echo "Apellidos: " . $obj->usuario->apellidos . "<br/>";
                echo "Email: " . $obj->usuario->email . "</br>";
                if ($obj->usuario->dni == null)
                    echo "Su perfil no está completo, debe rellenarlo en 'Editar Perfil'<br/>";
                else
                    echo "DNI: " . $obj->usuario->dni . "</br>";
                echo "</p>";
                echo "<form action='principal.php' method='post' enctype='multipart/form-data'>";
                echo "<input type='file' name='foto2'/>";
                echo "<input type='submit' name='subir' value='Subir'/>";
                echo "</form>";
                echo "</article>";
                ?>

            </div>
            <p>
            <span class="titulo"> Editar perfil</span>
            </p>
            <div class="oculta" style="<?php if ($error_prueba && isset($_POST["edita_peque"])) echo 'display:block'; ?>">
                <article>
                    <form action="principal.php" method="post">
                        <?php
                        $datos = array(
                            "email" => $_SESSION["email"]
                        );
                        // var_dump($datos);

                        $obj = consumir_servicio_REST(URL . "/usuario", "POST", $datos);
                        if (!isset($_POST["modificar"])) {
                            $nombre = $obj->usuario->nombre;
                            $apellidos = $obj->usuario->apellidos;

                            if ($obj->usuario->dni != null) {
                                $dni = $obj->usuario->dni;
                            }
                        } else {
                            $nombre = $_POST["nombre"];
                            $apellidos = $_POST["apellidos"];
                            $dni = $_POST["dni"];
                        }

                        ?>
                      <span class="titulo">  Editar perfil:</span>
                        <br />
                        <hr />
                        <br />
                        <table>
                            <tr>
                                <td> <label for="nombre">Nombre:</label></td>
                                <td><input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" />
                                    <?php if ($error_nombre) echo '<span class="error">*</span>'; ?></td>
                            </tr>
                            <tr>
                                <td> <label for="apellidos">Apellidos:</label></td>
                                <td><input type="text" id="apellidos" name="apellidos" value="<?php echo $apellidos; ?>" />
                                    <?php if ($error_apellidos) echo '<span class="error">*</span>'; ?></td>
                            </tr>
                            <tr>
                                <td> <label for="dni">Dni:</label></td>
                                <td>
                                    <input type="text" pattern="[0-9]{8}[A-Za-z]{1}" id="dni" name="dni" placeholder="12345678Y" value="<?php if ($obj->usuario->dni != null) echo $dni; ?>" />
                                    <?php if ($dni_de_otro) echo '<span class="error">*</span>'; ?>
                                </td>
                            </tr>
                            <tr>
                                <td> <label for="copia">Copia DNI:</label></td>
                                <td><input type="file" name="copia" id="copia"></td>
                            </tr>
                        </table>

                        <input type="submit" name="modificar" value="Modificar" />
                        <br />
                        <br />
                        <input type="hidden" class="edita_peque" name="edita_peque" />
                        <?php

                        if ($dni_de_otro || $error_nombre || $error_apellidos)
                            echo "** Campo vacío o incorrecto **";

                        ?>
                    </form>
                </article>
            </div>
            <p>
            <span class="titulo">  Seguridad</span>
            </p>
            <div class="oculta">

            </div>
            <p>
            <span class="titulo">  Eliminar cuenta</span>
            </p>
            <div class="oculta">

            </div>
            <p>
            <span class="titulo">  Informar problema </span>
            </p>
            <div class="oculta">

            </div>
        </section>
        <section id="grande">
            <?php
            if (isset($_POST["subir"]) || !(isset($_POST["modificar"]))) {
                $datos = array(
                    "email" => $_SESSION["email"]
                );
                // var_dump($datos);

                $obj = consumir_servicio_REST(URL . "/usuario", "POST", $datos);
                echo "<article>";
                echo "<img id='perfil' src='img/" . $obj->usuario->foto_perfil . "' alt='imagen-perfil'/>";
                echo "<p id='perf'>Nombre: " . $obj->usuario->nombre . "</br>";
                echo "Apellidos: " . $obj->usuario->apellidos . "<br/>";
                echo "Email: " . $obj->usuario->email . "</br>";
                if ($obj->usuario->dni == null)
                    echo "Su perfil no está completo, debe rellenarlo en 'Editar Perfil'<br/>";
                else
                    echo "DNI: " . $obj->usuario->dni . "</br>";
                echo "</p>";
                echo "<form action='principal.php' method='post' enctype='multipart/form-data'>";
                echo "<input type='file' name='foto2'/>";
                echo "<input type='submit' name='subir' value='Subir'/>";
                echo "</form>";
                echo "</article>";
            } elseif (isset($_POST["modificar"])) {
            ?>
                <article>
                    <form action="principal.php" method="post">
                        <?php
                        $datos = array(
                            "email" => $_SESSION["email"]
                        );
                        // var_dump($datos);

                        $obj = consumir_servicio_REST(URL . "/usuario", "POST", $datos);

                        if (!isset($_POST["modificar"])) {
                            $nombre = $obj->usuario->nombre;
                            $apellidos = $obj->usuario->apellidos;

                            if ($obj->usuario->dni != null) {
                                $dni = $obj->usuario->dni;
                            }
                        } else {
                            $nombre = $_POST["nombre"];
                            $apellidos = $_POST["apellidos"];
                            $dni = $_POST["dni"];
                        }

                        ?>
                       <span class="titulo"> Editar perfil</span>
                        <br />
                        <br />
                        <table>
                            <tr>
                                <td> <label for="nombre2">Nombre:</label></td>
                                <td><input type="text" id="nombre2" name="nombre" value="<?php echo $nombre ?>" />
                                    <?php if ($error_nombre) echo '<span class="error">*</span>'; ?>
                                </td>
                            </tr>
                            <tr>
                                <td> <label for="apellidos2">Apellidos:</label></td>
                                <td><input type="text" id="apellidos2" name="apellidos" value="<?php echo $apellidos; ?>" />
                                    <?php if ($error_apellidos) echo '<span class="error">*</span>'; ?></td>
                            </tr>
                            <tr>
                                <td> <label for="dni2">Dni:</label></td>
                                <td>

                                    <input type="text" id="dni2" pattern="[0-9]{8}[A-Za-z]{1}" placeholder="12345678Y" name="dni" value="<?php if ($obj->usuario->dni != null) echo $dni; ?>" />
                                    <?php if ($dni_de_otro) echo '<span class="error">*</span>'; ?>
                                </td>
                            </tr>
                            <tr>
                                <td> <label for="copia2">Copia DNI:</label></td>
                                <td><input type="file" name="copia" id="copia2"></td>
                            </tr>
                        </table>

                        <input type="submit" name="modificar" value="Modificar" />
                        <br />
                        <br />
                        <?php

                        if ($dni_de_otro || $error_nombre || $error_apellidos)
                            echo "** Campo vacío o incorrecto **";

                        ?>
                    </form>
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
    <script type="text/javascript" src="JS/jquery-3.5.1.js"></script>
    <script>
        $(document).ready(function() {


            //al hacer click a cualquier etiqueta que no tenga la clase oculta dentro de la etiqueta con id titulares
            $("#titulares").on("click", "p:not(.oculta)", function() {
                //console.log("hola");
                if ($(window).width() < 1000)
                    $(this).next().slideToggle(800);

                $("#grande").html($(this).next().html());

                // console.log($("#grande .edita_peque").val());
                $("#grande .edita_peque").remove();


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