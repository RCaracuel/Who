
<?php 
session_name("who");
session_start();
require "funcion.php";

$error_email=true;
$error_clave=true;

if(isset($_POST["acceder"])){
    $error_email=$_POST["email"]=="";
    $error_clave=$_POST["clave"]=="";

    $error=$error_email||$error_clave;

    if(!$error){

        $datos=array(
            "email"=>$_POST["email"],
            "clave"=>$_POST["clave"]
        );
        var_dump($datos);

        $obj = consumir_servicio_REST(URL . "/login", "POST", $datos);
        //var_dump($obj);
        echo $obj->usuario->nombre;
    
    }
}


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@600&display=swap" rel="stylesheet">
    <title>Who</title>
</head>
<body>
    <main>
        <img src="img/logo.png" alt="logotipo"/>
        <section>
            <form action="index.php" method="post">
                <p>
                    <label for="email">Introduzca su email:</label>
                </p>
                <p>
                    <input type="email" name="email" id="email" value="<?php if(isset($_POST["acceder"])) echo $_POST["email"]; ?>" placeholder="<?php if(isset($_POST["acceder"]) && $_POST["email"]=="") echo "Campo vacío"; ?>"/>
                </p>
                <p>
                    <label for="clave">Introduzca contraseña:</label>
                </p>
                <p>
                    <input type="password" name="clave" id="clave" placeholder="<?php if(isset($_POST["acceder"]) && $_POST["clave"]=="") echo "Campo vacío"; ?>"/>
                </p>
    
                <p>
                    <button type="submit" name="registro" formaction="registro.php">Registro</button>
                    <input type="submit" name="acceder" value="Acceder"/>
                </p>
            </form>
        </section>
    </main>
</body>
</html>