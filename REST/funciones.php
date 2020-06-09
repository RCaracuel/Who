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

        $consulta="select *, avg(comenta.estrellas) as media_estrellas, count(comenta.cod_usuario) as total_comenta from inmueble join fotos on inmueble.cod_inmueble=fotos.cod_inmueble join comenta on inmueble.cod_inmueble=comenta.cod_inmueble group by inmueble.cod_inmueble order by media_estrellas desc limit 5";
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

function buscar_dni_usuario($dni){

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
                $email=mysqli_fetch_assoc($resultado)["cod_usuario"];
                return array("existe"=>"El dni existe", "codigo"=>$email);
            }else{
                
            return array("no_existe"=>"El dni no existe");
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
        
        $consulta="select inmueble.*,fotos.cod_foto,fotos.imagen  from inmueble left join fotos on inmueble.cod_inmueble=fotos.cod_inmueble where inmueble.cod_propietario='$cod' and baja=0";
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

function buscar_propiedades_baja($cod){

    $con=conectar();

    if(!$con){
        return array("mensaje"=>"No se ha podido conectar a la BD");
    }else{
        mysqli_set_charset($con,"utf8");
        
        $consulta="select inmueble.*,fotos.cod_foto,fotos.imagen  from inmueble left join fotos on inmueble.cod_inmueble=fotos.cod_inmueble where inmueble.cod_propietario='$cod' and baja=1";
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

function buscar_opiniones($codigo){

    $con=conectar();

    if(!$con){
        return array("mensaje"=>"No se ha podido conectar a la BD");
    }else{
        mysqli_set_charset($con,"utf8");
        
        $consulta="select avg(opina.estrellas) as puntuacion, count(opina.cod_propietario) as total from opina where cod_inquilino='$codigo'";
        $resultado=mysqli_query($con,$consulta);

        if(!$resultado){
            return array("mensaje"=>"No se ha podido realizar la consulta.".mysqli_error($con)."/".mysqli_errno($con));
        }else{

               $opiniones=mysqli_fetch_assoc($resultado);
                
                return array("opiniones"=>$opiniones);

        }
    }
}


function buscar_contratos($cod){
    $con=conectar();

    if(!$con){
        return array("mensaje"=>"No se ha podido conectar a la BD");
    }else{
        mysqli_set_charset($con,"utf8");
        
        $consulta="select inmueble.localidad, alquila.fecha_ini, alquila.fecha_fin, alquila.cod_usuario, alquila.cod_inmueble from alquila join inmueble on alquila.cod_inmueble=inmueble.cod_inmueble join usuarios on usuarios.cod_usuario=inmueble.cod_propietario where inmueble.cod_propietario='$cod'and alquila.fecha_fin>now()";
        $resultado=mysqli_query($con,$consulta);

        if(!$resultado){
            return array("mensaje"=>"No se ha podido realizar la consulta.".mysqli_error($con)."/".mysqli_errno($con));
        }else{

            if(mysqli_num_rows($resultado)>0){
                $contratos=array();
                while($fila=mysqli_fetch_assoc($resultado)){
                    $contratos[]=$fila;
                }

                mysqli_free_result($resultado);
                return array("contratos"=>$contratos);
            }else{
            return array("sin_contratos"=>"No existen contratos registrados de este usuario");
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

function insertar_contrato($inquilino,$inmueble,$inicio,$fin){

    $con=conectar();
  //  return array("mensaje"=>"He entrado a la función");
   
    if(!$con){
        return array("mensaje"=>"No se ha podido conectar con la BD");
    }else{
        mysqli_set_charset($con,"utf8");

        $consulta="insert into alquila (cod_usuario,cod_inmueble,fecha_ini,fecha_fin) values ('$inquilino','$inmueble','$inicio','$fin')";
        $resultado=mysqli_query($con,$consulta);

        if(!$resultado){
            return array("mensaje"=>"No se ha podido realizar la consulta.".mysqli_errno($con)."/".mysqli_error($con));
        }else{
            return array("mensaje_exito"=>"Se ha insertado el contrato con éxito");
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

function insertar_usuario_contrato($nombre,$apellido,$dni){

    $con=conectar();
  //  return array("mensaje"=>"He entrado a la función");

    if(!$con){
        return array("mensaje"=>"No se ha podido conectar con la BD");
    }else{
        mysqli_set_charset($con,"utf8");

        $consulta="insert into usuarios (nombre,apellidos,dni) values ('$nombre','$apellido','$dni')";
        $resultado=mysqli_query($con,$consulta);

        if(!$resultado){
            return array("mensaje"=>"No se ha podido realizar la consulta.".mysqli_errno($con)."/".mysqli_error($con));
        }else{
            
            $ultimo=mysqli_insert_id($con);

            return array("mensaje_exito"=>"Se ha insertado el usuario con éxito", "ultimo"=>$ultimo);
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


function baja_propiedad($codigo){
    $con=conectar();
    if(!$con){
        return array("mensaje"=>"No se ha podido conectar con la BD");
    }else{
        mysqli_set_charset($con,"utf8");
      
        $consulta="update inmueble set baja='1' where cod_inmueble='$codigo'";
        $resultado=mysqli_query($con,$consulta);

        if(!$resultado){
            return array("mensaje"=>"No se ha podido realizar la consulta.".mysqli_errno($con)."/".mysqli_error($con));
        }else{
            return array("mensaje_exito"=>"Se ha dado de baja con éxito");
        }
    }

}


function alta_propiedad($codigo){
    $con=conectar();
    if(!$con){
        return array("mensaje"=>"No se ha podido conectar con la BD");
    }else{
        mysqli_set_charset($con,"utf8");
      
        $consulta="update inmueble set baja='0' where cod_inmueble='$codigo'";
        $resultado=mysqli_query($con,$consulta);

        if(!$resultado){
            return array("mensaje"=>"No se ha podido realizar la consulta.".mysqli_errno($con)."/".mysqli_error($con));
        }else{
            return array("mensaje_exito"=>"Se ha dado de baja con éxito");
        }
    }

}


?>