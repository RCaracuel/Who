﻿<?php
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

$app->get("/buscar_propiedades/:cod", function($cod){
    echo json_encode(buscar_propiedades($cod), JSON_FORCE_OBJECT);
});

$app->get("/buscar_propiedades_baja/:cod", function($cod){
    echo json_encode(buscar_propiedades_baja($cod), JSON_FORCE_OBJECT);
});

$app->get("/buscar_informes/:cod", function($cod){
    echo json_encode(buscar_informes($cod), JSON_FORCE_OBJECT);
});

$app->get("/traer_opiniones/:dni", function($dni){
    echo json_encode(traer_opiniones($dni), JSON_FORCE_OBJECT);
});

$app->get("/buscar_contratos/:cod", function($cod){
    echo json_encode(buscar_contratos($cod), JSON_FORCE_OBJECT);
});
$app->get("/buscar_contratos_finalizados_propietario/:cod", function($cod){
    echo json_encode(buscar_contratos_finalizados_propietario($cod), JSON_FORCE_OBJECT);
});
$app->get("/buscar_contratos_finalizados_inquilino/:cod", function($cod){
    echo json_encode(buscar_contratos_finalizados_inquilino($cod), JSON_FORCE_OBJECT);
});

$app->get("/buscar_dni/:dni", function($dni){
    echo json_encode(buscar_dni($dni), JSON_FORCE_OBJECT);
});

$app->get("/opiniones/:codigo", function($codigo){
    echo json_encode(buscar_opiniones($codigo), JSON_FORCE_OBJECT);
});

$app->post("/buscar_dni_usuario", function(){
    echo json_encode(buscar_dni_usuario($_POST["dni"]), JSON_FORCE_OBJECT);
});

$app->post('/top5', function(){
    echo json_encode(top5(),JSON_FORCE_OBJECT);
});
$app->post('/usuario', function(){
    echo json_encode(usuario($_POST["email"]),JSON_FORCE_OBJECT);
});

$app->post('/usuario_codigo', function(){
    echo json_encode(usuario_codigo($_POST["codigo"]),JSON_FORCE_OBJECT);
});

$app->put('/cambiar_foto/:email', function($email) use ($app){
    $datos=$app->request->put();
    echo json_encode(cambiar_foto($email,$datos["foto"]),JSON_FORCE_OBJECT);
  });

  $app->put('/cambiar_datos/:email', function($email) use ($app){
    $datos=$app->request->put();
    echo json_encode(cambiar_datos($email,$datos["nombre"],$datos["apellidos"]),JSON_FORCE_OBJECT);
  });

  $app->put('/cambiar_contrasenia/:email', function($email) use ($app){
    $datos=$app->request->put();
    echo json_encode(cambiar_contrasenia($email,$datos["old"],$datos["nueva"]),JSON_FORCE_OBJECT);
  });

  $app->put('/finalizar_contrato', function() use ($app){
    $datos=$app->request->put();
    echo json_encode(finalizar_contrato($datos["codigo_casa"],$datos["codigo_inquilino"],$datos["fecha_inicio_alquiler"]),JSON_FORCE_OBJECT);
  });

  $app->put('/baja_usuario/:email', function($email) use ($app){
    echo json_encode(baja_usuario($email),JSON_FORCE_OBJECT);
  });

  $app->put('/baja_propiedad/:codigo', function($codigo) use ($app){
    echo json_encode(baja_propiedad($codigo),JSON_FORCE_OBJECT);
  });

  $app->put('/alta_propiedad/:codigo', function($codigo) use ($app){
    echo json_encode(alta_propiedad($codigo),JSON_FORCE_OBJECT);
  });

$app->post("/registro", function(){
    echo json_encode(insertar_usuario($_POST["nombre"],$_POST["apellidos"],$_POST["email"],$_POST["clave"],$_POST["dni"]), JSON_FORCE_OBJECT);
});

$app->post("/registro_contrato", function(){
    echo json_encode(insertar_usuario_contrato($_POST["nombre"],$_POST["apellidos"],$_POST["dni"]), JSON_FORCE_OBJECT);
});

$app->post("/insertar_propiedad", function(){
    echo json_encode(insertar_propiedad($_POST["codigo"],$_POST["habitaciones"],$_POST["terraza"],$_POST["piscina"],$_POST["garaje"],$_POST["jardin"],$_POST["distancia"],$_POST["m2"],$_POST["idufir"],$_POST["localidad"]), JSON_FORCE_OBJECT);
});

$app->post("/insertar_informe", function(){
    echo json_encode(insertar_informe($_POST["cod_usu"],$_POST["texto"]), JSON_FORCE_OBJECT);
});

$app->post("/enviar_opinion", function(){
    echo json_encode(enviar_opinion($_POST["propietario"],$_POST["inquilino"],$_POST["opinion"],$_POST["estrellas"]), JSON_FORCE_OBJECT);
});

$app->post("/enviar_comentario", function(){
    echo json_encode(enviar_comentario($_POST["inmueble"],$_POST["inquilino"],$_POST["opinion"],$_POST["estrellas"]), JSON_FORCE_OBJECT);
});

$app->post("/insertar_contrato", function(){
    echo json_encode(insertar_contrato($_POST["inquilino"],$_POST["inmueble"], $_POST["inicio"],$_POST["fin"]), JSON_FORCE_OBJECT);
});



$app->run();

?>





