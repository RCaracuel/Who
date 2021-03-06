<?php
session_name("who");
session_start();

require "funcion.php";

$error_nombre = true;
$error_apellido = true;
$error_email = true;
$error_clave = true;
$error_clave2 = true;
$error_iguales = false;
$error_existe = false;

if(isset($_POST["atras"])){
    header("Location: index.php");
    exit;
}

if (isset($_POST["entrar"])) {

    $error_nombre = $_POST["nombre"] == "";
    $error_apellido = $_POST["apellidos"] == "";
    $error_email = $_POST["email"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_clave2 = $_POST["clave2"] == "";

    if ($_POST["clave"] != "" && $_POST["clave2"] != "") {
        if ($_POST["clave"] != $_POST["clave2"])
            // echo "No son iguales";
            $error_iguales = true;
    }

    if ($_POST["email"] != "") {
        $obj = consumir_servicio_REST(URL . "/buscar_email/" . $_POST["email"], "GET");
        if (isset($obj->existe)) {
            $error_existe = true;
        }
       // var_dump($obj);
    }
    $error_todo = $error_nombre || $error_apellido || $error_email || $error_clave || $error_clave2 || $error_iguales || $error_existe;

    if (!$error_todo) {
        $datos = array(
            "nombre" => $_POST["nombre"],
            "apellidos" => $_POST["apellidos"],
            "email" => $_POST["email"],
            "clave" => $_POST["clave"],
            "dni"=>$_POST["dni"]
        );
        var_dump($datos);
        // var_dump(URL . "/login/" . $usu . "/" . $clavelito); 

        $obj = consumir_servicio_REST(URL . "/registro", "POST", $datos);
        if (isset($obj->mensaje_exito)) {
            $_SESSION["nombre"] = $_POST["nombre"] . " " . $_POST["apellidos"];
            $_SESSION["clave"] = md5($_POST["clave"]);
            $_SESSION["email"] = $_POST["email"];
            $_SESSION["ultimo_acceso"] = time();
            header("Location:principal.php");
            exit;
        }else{
            var_dump($obj);
        }
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/registro.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@600&display=swap" rel="stylesheet">
    <title>Registro</title>
</head>

<body>
    <main>
        <img src="img/logo.png" alt="logotipo" />
        <section>
            <form action="registro.php" method="post">
                <p>REGISTRO</p>

                <p>
                    <input class="formu" type="text" name="nombre" required value="<?php if (isset($_POST["entrar"])) echo $_POST["nombre"]; ?>" placeholder="<?php if (isset($_POST["entrar"]) && $error_nombre) echo "Campo vacío";
                                                                                                                                                    else echo "Nombre"; ?>" />

                </p>
                <p>
                    <input class="formu" type="text" name="apellidos" required value="<?php if (isset($_POST["entrar"])) echo $_POST["apellidos"]; ?>" placeholder="<?php if (isset($_POST["entrar"]) && $error_apellido) echo "Campo vacío";
                                                                                                                                                            else echo "Apellidos"; ?>" />

                </p>

                <p>
                    <input class="formu" type="email" name="email" required value="<?php if (isset($_POST["entrar"])) echo $_POST["email"]; ?>" placeholder="<?php if (isset($_POST["entrar"]) && $error_email) echo "Campo vacío";
                                                                                                                                                    else echo "Email"; ?>" />

                </p>
                <p>
                    <input pattern="(([X-Z]{1})([-]?)(\d{7})([-]?)([A-Z]{1}))|((\d{8})([-]?)([A-Za-z]{1}))" class="formu" type="text" name="dni" required value="<?php if (isset($_POST["entrar"])) echo $_POST["dni"]; ?>" placeholder="<?php echo "DNI 72655489Y"; ?>" />

                </p>

                <p>
                    <input class="formu" type="password" name="clave" required placeholder="<?php if (isset($_POST["entrar"]) && $error_clave) echo "Campo vacío";
                                                                                    elseif (isset($_POST["clave"]) && isset($_POST["clave2"]) && $_POST["clave"] != $_POST["clave2"]) echo "Las contraseñas no coinciden";
                                                                                    else echo "Contraseña"; ?>" />

                </p>

                <p>
                    <input class="formu" type="password" name="clave2" required placeholder="<?php if (isset($_POST["entrar"]) && $error_clave2) echo "Campo vacío";
                                                                                    else echo "Repita Contraseña"; ?>" />
                </p>
                <p>
                    <input class="sub" type="submit" name="entrar" value="Entrar" />
                  
                </p>
            </form>
            <form action="index.php" method="post">
            <button class="sub">Atrás</button>
            </form>
        </section>
    </main>
</body>

</html>