
<?php 
session_name("who");
session_start();

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
            <form action="principal.php" method="post">
                <p>
                    <label for="email">Introduzca su email:</label>
                </p>
                <p>
                    <input type="text" name="email" id="email"/>
                </p>
                <p>
                    <label for="clave">Introduzca contraseña:</label>
                </p>
                <p>
                    <input type="password" name="clave" id="clave"/>
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