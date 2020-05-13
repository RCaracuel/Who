<?php
require 'funciones.php';
require 'Slim/Slim.php';


// El framework Slim tiene definido un namespace llamado Slim
// Por eso aparece \Slim\ antes del nombre de la clase.
\Slim\Slim::registerAutoloader();
// Creamos la aplicaci�n
$app = new \Slim\Slim();
// Indicamos el tipo de contenido y condificaci�n que devolveremos desde el framework Slim
$app->contentType('application/json; charset=utf-8');


$app->post('/login', function(){
    echo json_encode(login($_POST["email"],$_POST["clave"]), JSON_FORCE_OBJECT);
});

$app->get("/buscar_email/:email", function($email){
    echo json_encode(buscar_email($email), JSON_FORCE_OBJECT);
});

$app->post('/top10', function(){
    echo json_encode(top10(),JSON_FORCE_OBJECT);
});

$app->get("/libro/:cod", function($cod){
    echo json_encode(buscar_libro($cod), JSON_FORCE_OBJECT);
});

$app->post("/registro", function(){
    echo json_encode(insertar_usuario($_POST["nombre"],$_POST["apellidos"],$_POST["email"],$_POST["clave"]), JSON_FORCE_OBJECT);
});

$app->run();

?>





