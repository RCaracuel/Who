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

        if($fila["activo"]==0){
            $consulta="update usuarios set activo=1 where email='$email' and pass='$cla'";
            $resultado=mysqli_query($con,$consulta);
            if(!$resultado){
                mysqli_free_result($resultado);
                mysqli_close($con);
                return array("mensaje"=>"No se ha podido realizar la consulta".mysqli_error($con)."/".mysqli_errno($con));
            }else{
                return array("usuario"=>$fila);
            }

        }
        return array("usuario"=>$fila);

    }

}
}

function usuario($email){
    $con=conectar();
    if(!$con){
        return array("mensaje"=>"No se ha podido conectar");
    }else{
        mysqli_set_charset($con,"utf8");
    

        $consulta="select * from usuarios where email='$email'";
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


function top5(){

    $con=conectar();
    if(!$con){
        return array("mensaje"=>"No se ha podido conectar");
    }else{
        mysqli_set_charset($con,"utf8");

        $consulta="select * from inmueble join fotos where inmueble.cod_inmueble=fotos.cod_inmueble group by inmueble.cod_inmueble order by estrellas desc  limit 5";
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

function buscar_dni_usuario($dni,$email){

    $con=conectar();

    if(!$con){
        return array("mensaje"=>"No se ha podido conectar a la BD");
    }else{
        mysqli_set_charset($con,"utf8");
        
        $consulta="select * from usuarios where dni='".$dni."' and email='$email'";
        $resultado=mysqli_query($con,$consulta);

        if(!$resultado){
            return array("mensaje"=>"No se ha podido realizar la consulta.".mysqli_error($con)."/".mysqli_errno($con));
        }else{
            if(mysqli_num_rows($resultado)>0){
                return array("pertenece"=>"El dni pertenece al email");
            }else{
            return array("no_pertenece"=>"El dni no pertenece al email");
            }
        }
    }
}

function buscar_dni($dni){

    $con=conectar();

    if(!$con){
        return array("mensaje"=>"No se ha podido conectar a la BD");
    }else{
        mysqli_set_charset($con,"utf8");
        
        $consulta="select * from usuarios where dni='".$dni."'";
        $resultado=mysqli_query($con,$consulta);

        if(!$resultado){
            return array("mensaje"=>"No se ha podido realizar la consulta.".mysqli_error($con)."/".mysqli_errno($con));
        }else{
            if(mysqli_num_rows($resultado)>0){
                return array("existe"=>"Dni existente");
            }else{
            return array("no_existe"=>"El dni no existe");
            }
        }
    }
}

function buscar_propiedades($cod){

    $con=conectar();

    if(!$con){
        return array("mensaje"=>"No se ha podido conectar a la BD");
    }else{
        mysqli_set_charset($con,"utf8");
        
        $consulta="select * from inmueble left join fotos on inmueble.cod_inmueble=fotos.cod_inmueble where inmueble.cod_propietario='$cod'";
        $resultado=mysqli_query($con,$consulta);

        if(!$resultado){
            return array("mensaje"=>"No se ha podido realizar la consulta.".mysqli_error($con)."/".mysqli_errno($con));
        }else{
            if(mysqli_num_rows($resultado)>0){
                $propiedades=array();
                while($fila=mysqli_fetch_assoc($resultado)){
                    $propiedades[]=$fila;
                }
                $total=mysqli_num_rows($resultado);
                mysqli_free_result($resultado);
                return array("propiedades"=>$propiedades,"total"=>$total);
            }else{
            return array("sin_propiedades"=>"No existen propiedades registradas de este usuario");
            }
        }
    }
}

function buscar_informes($cod){

    $con=conectar();

    if(!$con){
        return array("mensaje"=>"No se ha podido conectar a la BD");
    }else{
        mysqli_set_charset($con,"utf8");
        
        $consulta="select * from informes where cod_usuario='$cod'";
        $resultado=mysqli_query($con,$consulta);

        if(!$resultado){
            return array("mensaje"=>"No se ha podido realizar la consulta.".mysqli_error($con)."/".mysqli_errno($con));
        }else{
            if(mysqli_num_rows($resultado)>0){
                $informes=array();
                while($fila=mysqli_fetch_assoc($resultado)){
                    $informes[]=$fila;
                }
                $total=mysqli_num_rows($resultado);
                mysqli_free_result($resultado);
                return array("informes"=>$informes,"total"=>$total);
            }else{
            return array("sin_informes"=>"No existen informes registrados de este usuario");
            }
        }
    }
}


function insertar_propiedad($codigo,$habitaciones,$terraza,$piscina,$garaje,$jardin,$distancia,$m2,$idufir,$localidad){

    $con=conectar();
  //  return array("mensaje"=>"He entrado a la función");
   
    if(!$con){
        return array("mensaje"=>"No se ha podido conectar con la BD");
    }else{
        mysqli_set_charset($con,"utf8");

        $consulta="insert into inmueble (cod_propietario,num_hab,terraza,jardin,piscina,garaje,distancia_centro,m2,idufir,localidad) values ('$codigo','$habitaciones','$terraza','$jardin', '$piscina', '$garaje','$distancia','$m2','$idufir','$localidad')";
        $resultado=mysqli_query($con,$consulta);

        if(!$resultado){
            return array("mensaje"=>"No se ha podido realizar la consulta.".mysqli_errno($con)."/".mysqli_error($con));
        }else{
            return array("mensaje_exito"=>"Se ha insertado la propiedad con éxito");
        }
    }

}

function insertar_informe($cod_usu,$texto){

    $con=conectar();
  //  return array("mensaje"=>"He entrado a la función");
   
    if(!$con){
        return array("mensaje"=>"No se ha podido conectar con la BD");
    }else{
        mysqli_set_charset($con,"utf8");

        $consulta="insert into informes (cod_usuario,informe,fecha_informe) values ('$cod_usu','$texto',now())";
        $resultado=mysqli_query($con,$consulta);

        if(!$resultado){
            return array("mensaje"=>"No se ha podido realizar la consulta.".mysqli_errno($con)."/".mysqli_error($con));
        }else{
            return array("mensaje_exito"=>"Se ha insertado el informe con éxito");
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

function cambiar_foto($email,$foto){

    $con=conectar();
      if(!$con){
          return array("mensaje"=>"No se ha podido conectar con la BD");
      }else{
          mysqli_set_charset($con,"utf8");
  
          $consulta="update usuarios set foto_perfil='$foto' where email='$email'";
          $resultado=mysqli_query($con,$consulta);
  
          if(!$resultado){
              return array("mensaje"=>"No se ha podido realizar la consulta.".mysqli_errno($con)."/".mysqli_error($con));
          }else{
              return array("mensaje_exito"=>"Se ha cambiado la foto con éxito");
          }
      }

}

function cambiar_datos($email,$nombre,$apellidos){

    $con=conectar();
      if(!$con){
          return array("mensaje"=>"No se ha podido conectar con la BD");
      }else{
          mysqli_set_charset($con,"utf8");
  
          $consulta="update usuarios set nombre='$nombre', apellidos='$apellidos' where email='$email'";
          $resultado=mysqli_query($con,$consulta);
  
          if(!$resultado){
              return array("mensaje"=>"No se ha podido realizar la consulta.".mysqli_errno($con)."/".mysqli_error($con));
          }else{
              return array("mensaje_exito"=>"Se han cambiado los datos con éxito");
          }
      }

}

function cambiar_contrasenia($email,$old,$nueva){

    $con=conectar();
      if(!$con){
          return array("mensaje"=>"No se ha podido conectar con la BD");
      }else{
          mysqli_set_charset($con,"utf8");
        
          $consulta="update usuarios set pass='$nueva' where email='$email' and pass='$old'";
          $resultado=mysqli_query($con,$consulta);
  
          if(!$resultado){
              return array("mensaje"=>"No se ha podido realizar la consulta.".mysqli_errno($con)."/".mysqli_error($con));
          }else{
              return array("mensaje_exito"=>"Se ha cambiado la contraseña con éxito");
          }
      }

}


function baja_usuario($email){
    $con=conectar();
    if(!$con){
        return array("mensaje"=>"No se ha podido conectar con la BD");
    }else{
        mysqli_set_charset($con,"utf8");
      
        $consulta="update usuarios set activo='0' where email='$email'";
        $resultado=mysqli_query($con,$consulta);

        if(!$resultado){
            return array("mensaje"=>"No se ha podido realizar la consulta.".mysqli_errno($con)."/".mysqli_error($con));
        }else{
            return array("mensaje_exito"=>"Se ha dado de baja con éxito");
        }
    }

}
?>