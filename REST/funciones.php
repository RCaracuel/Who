<?php 
require "conexion_bd.php";


function login($email,$clave){
$con=conectar();
if(!$con){
    return array("mensaje"=>"No se ha podido conectar");
}else{
    mysqli_set_charset($con,"utf8");

    $cla=md5($clave);
    $consulta="select * from usuarios where email='$email' and pass='$cla'";
    $resultado=mysqli_query($con,$consulta);

    if(!$resultado){
        mysqli_free_result($resultado);
        mysqli_close($con);
        return array("mensaje"=>"No se ha podido realizar la consulta".mysqli_error($con)."/".mysqli_errno($con));
    }else{

        $fila=mysqli_fetch_assoc($resultado);
        return array("usuario"=>$fila);

    }

}
}

function top10(){

    $con=conectar();
    if(!$con){
        return array("mensaje"=>"No se ha podido conectar");
    }else{
        mysqli_set_charset($con,"utf8");

        $consulta="select * from inmueble where estrellas=5 limit 5";
        $resultado=mysqli_query($con,$consulta);
    
        if(!$resultado){
            mysqli_free_result($resultado);
            mysqli_close($con);
            return array("mensaje"=>"No se ha podido realizar la consulta".mysqli_error($con)."/".mysqli_errno($con));
        }else{
            $top=array();
 
            while($fila=mysqli_fetch_assoc($resultado)){
                $top[]=$fila;
            }
            return array("top"=>$top);
    
        }
    
    }

}

function obtener_libros(){

    $con=conectar();
    if(!$con){
        return array("mensaje"=>"No se ha podido conectar a la BD.");
    }else{
        mysqli_set_charset($con,"utf8");

        $consulta="select * from libros";
        $resultado=mysqli_query($con,$consulta);
        if(!$resultado){
            return array("mensaje"=>"No se ha podido realizar la consulta.".mysqli_errno($con)."/".mysqli_error($con));
        }else{
            $libros=array();
            while($fila=mysqli_fetch_assoc($resultado)){
                $libros[]=$fila;
            }
            $total=mysqli_num_rows($resultado);
            mysqli_free_result($resultado);
            return array("libros"=>$libros,"total"=>$total);
        }
    }
}

function buscar_email($email){

    $con=conectar();

    if(!$con){
        return array("mensaje"=>"No se ha podido conectar a la BD");
    }else{
        mysqli_set_charset($con,"utf8");
        
        $consulta="select * from usuarios where email='".$email."'";
        $resultado=mysqli_query($con,$consulta);

        if(!$resultado){
            return array("mensaje"=>"No se ha podido realizar la consulta.".mysqli_error($con)."/".mysqli_errno($con));
        }else{
            if(mysqli_num_rows($resultado)>0){
                return array("existe"=>"El email ya existe");
            }else{
            return array("no_existe"=>"El email no existe");
            }
        }
    }
}

function insertar_usuario($nombre,$apellido,$email,$clave){

    $con=conectar();
  //  return array("mensaje"=>"He entrado a la función");
    $pass=md5($clave);
    if(!$con){
        return array("mensaje"=>"No se ha podido conectar con la BD");
    }else{
        mysqli_set_charset($con,"utf8");

        $consulta="insert into usuarios (nombre,apellidos,email,pass) values ('$nombre','$apellido','$email', '$pass')";
        $resultado=mysqli_query($con,$consulta);

        if(!$resultado){
            return array("mensaje"=>"No se ha podido realizar la consulta.".mysqli_errno($con)."/".mysqli_error($con));
        }else{
            return array("mensaje_exito"=>"Se ha insertado el usuario con éxito");
        }
    }

}


?>