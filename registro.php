<?php 
session_name("who");
session_start();
define("URL", "http://localhost/Proyectos/Curso_19_20/Who/REST");
function consumir_servicio_REST($url, $metodo, $datos = null)
{

    $llamada = curl_init();
    curl_setopt($llamada, CURLOPT_URL, $url);
    curl_setopt($llamada, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($llamada, CURLOPT_CUSTOMREQUEST, $metodo);
    if (isset($datos))
        curl_setopt($llamada, CURLOPT_POSTFIELDS, http_build_query($datos));

    $response = curl_exec($llamada);
    curl_close($llamada);
    if (!$response)
        die("Error consumiendo el servicio Web: " . $url);
    $decodeText = substr($response, 3, strlen($response) - 1);
    return json_decode($decodeText);
}

$error_nombre=true;
$error_apellido=true;
$error_email=true;
$error_clave=true;
$error_clave2=true;
$error_iguales=false;
if(isset($_POST["entrar"])){
    
$error_nombre=$_POST["nombre"]=="";
$error_apellido=$_POST["apellidos"]=="";
$error_email=$_POST["email"]=="";
$error_clave=$_POST["clave"]=="";
$error_clave2=$_POST["clave2"]=="";

if($_POST["clave"]!="" && $_POST["clave2"]!=""){
    if($_POST["clave"]!=$_POST["clave2"])
   // echo "No son iguales";
    $error_iguales=true;
}

$error_todo=$error_nombre||$error_apellido||$error_email||$error_clave||$error_clave2||$error_iguales;

if(!$error_todo){
    $datos=array(
        "nombre"=>$_POST["nombre"],
        "apellidos"=>$_POST["apellidos"],
        "email"=>$_POST["email"],
        "clave"=>$_POST["clave"]
    );
    var_dump($datos);
   // var_dump(URL . "/login/" . $usu . "/" . $clavelito); 
  
    $obj = consumir_servicio_REST(URL . "/registro", "POST", $datos);
    if($obj->mensaje_exito){
        $_SESSION["nombre"]=$_POST["nombre"]." ".$_POST["apellidos"];
        header("Location:principal.php");
        exit;
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
        <img src="img/logo.png" alt="logotipo"/>
        <section>
            <form action="registro.php" method="post">
                <p>REGISTRO</p>
                <p>
                    <label for="nombre">Nombre</label>
                    <?php if(isset($_POST["entrar"]) && $error_nombre) echo " ** Campo vacío **" ?>
                </p>
                <p>
                    <input type="text" name="nombre" id="nombre"/>
                   
                </p>
                <p>
                    <label for="apellidos">Apellidos</label>
                    <?php if(isset($_POST["entrar"]) && $error_apellido) echo " ** Campo vacío **" ?>
                </p>
                <p>
                    <input type="text" name="apellidos" id="apellidos"/>
                    
                </p>
                <p>
                    <label for="email">Email</label>
                    <?php if(isset($_POST["entrar"]) && $error_email) echo " ** Campo vacío **" ?>
                </p>
                <p>
                    <input type="text" name="email" id="email"/>
                    
                </p>
                <p>
                    <label for="clave">Contraseña</label>
                    <?php if(isset($_POST["entrar"]) && $error_clave) echo " ** Campo vacío **";
                        elseif( isset($_POST["clave"]) && isset($_POST["clave2"]) && $_POST["clave"]!=$_POST["clave2"]) echo " **Contraseñas distintas**";?>
                </p>
                <p>
                    <input type="password" name="clave" id="clave"/>
                    
                </p>
                <p>
                    <label for="clave2">Repita contraseña</label>
                    <?php if(isset($_POST["entrar"]) && $error_clave2) echo " ** Campo vacío **" ?>
                </p>
                <p>
                    <input type="password" name="clave2" id="clave2"/>
                </p>
                <p>
                    <button type="submit" name="atras" formaction="index.php">Atrás</button>
                    <input type="submit" name="entrar" value="Entrar"/>
                </p>
            </form>
        </section>
    </main>
</body>
</html>