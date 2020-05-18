<?php
$obj = consumir_servicio_REST(URL . "/top5", "POST");
//var_dump($obj);
foreach ($obj->top as $inmueble) {

    //  echo $inmueble->estrellas;
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/principal.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@600&display=swap" rel="stylesheet">
    <title>Página principal</title>

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
                <li><button type="input" name="propiedades">Propiedades</button></li>
                <li><button type="input" name="suscripcion">Suscripción</button></li>
                <li><button type="input" name="salir">Salir</button></li>
            </ul>
        </form>
        <div id="escritorio">
            <p><?php echo $_SESSION["nombre"]; ?></p>
            <a href="perfil.html"><img src="img/perfil.png" alt="foto-perfil" /></a>
        </div>
    </header>
    <main>
        <section id="titulares">
            <p>
                TOP 5
            </p>
            <div class="oculta">
                <?php

                $obj = consumir_servicio_REST(URL . "/top5", "POST");
                //var_dump($obj);
                foreach ($obj->top as $inmueble) {

                    echo "<article>";
                    // echo "hola";
                    //echo $inmueble->imagen;
                    echo "<img src='img/" . $inmueble->imagen . "' alt='foto_casa'/>";
                    echo "<p><span class='destino'>Casa " . $inmueble->cod_inmueble."</span>";
                    echo "<br/>";
                    echo "Localidad: " . $inmueble->localidad;
                    echo "<br/>";
                    echo "Distancia centro: " . $inmueble->distancia_centro . "km";
                    echo "<br/>";
                    echo "M2: " . ($inmueble->m2 == 0 ? "No" : "Si");
                    echo "<br/>";
                    echo "Nº Habitaciones: " . $inmueble->num_hab;
                    echo "<br/>";
                    echo "Garaje: " . ($inmueble->garaje == 0 ? "No" : "Si");
                    echo "<br/>";
                    echo "Terraza: " . ($inmueble->terraza == 0 ? "No" : "Si");
                    echo "<br/>";
                    echo "Jardín: " . ($inmueble->jardin == 0 ? "No" : "Si");
                    echo "<br/>";
                    echo "Piscina: " . ($inmueble->piscina == 0 ? "No" : "Si");
                    echo "<br/>";
                    echo "</p>";
                    echo "</article>";
                }
                ?>
            </div>
            <p>
                Los + buscados
            </p>
            <div class="oculta">
               <article>
                   <img src="img/londres.jpg" alt="londres"/>
                   <p><span class="destino">Londres</span>
                       <br/>
                       Es el destino más buscado en Google, no es de extrañar, debido a que es la mayor ciudad y área urbana de Gran Bretaña y de toda la Unión Europea. Con todas las zonas de interés cultural que Londres tiene es normal que sea uno de los destinos preferidos por los ínter nautas para elegir como destino vacacional.
                   </p>
               </article>
               <article>
                   <img src="img/tailandia.jpg" alt="tailandia"/>
                   <p><span class="destino">Tailandia</span>
                       <br/>
                       Uno de los destinos favoritas para realizar un viaje de novios, la combinación de zonas culturales con zonas paradisíacas de playas hacen de Tailandia un destino muy solicitado por los recién casados. Un destino bastante económico para pasar una temporada larga allí y empaparte de la cultura milenaria asiática de diferentes zonas de Tailandia.
                   </p>
               </article>
               <article>
                   <img src="img/paris.jpg" alt="paris"/>
                   <p><span class="destino">París</span>
                       <br/>
                       El tercer destino más buscado en Google es París, la ciudad del amor, un destino romántico con un gran interés cultural en territorio Francés. Destacan diferentes lugares para visitar como la Torre Eiffel, Disneyland Paris o la Catedral de Notre Dame.
                   </p>
               </article>
               <article>
                   <img src="img/roma.jpg" alt="roma"/>
                   <p><span class="destino">Roma</span>
                       <br/>
                       Preciosa ciudad llena de lugares culturales que visitar, en cuanto pises Roma notarás que respiras historia en casi cualquier zona. Espectaculares monumentos te esperan para que puedas visitarlos con total tranquilidad y disfrutes de su belleza y cultura italiana.
                   </p>
                   
               </article>
               <a href="https://www.felicesvacaciones.es/blog/los-destinos-mas-buscados-en-google">Artículo de felicesvacaciones.es</a>
            </div>
            <p>
                Los + económicos
            </p>
            <div class="oculta">
                3 Lorem ipsum, dolor sit amet consectetur adipisicing elit. Id alias deserunt maxime iusto atque, laudantium quod accusantium sequi vero minima error nemo nam vitae magnam voluptatem, nulla, minus molestiae aut!
            </div>
            <p>
                Tu casa protegida
            </p>
            <div class="oculta">
                4 Lorem ipsum, dolor sit amet consectetur adipisicing elit. Id alias deserunt maxime iusto atque, laudantium quod accusantium sequi vero minima error nemo nam vitae magnam voluptatem, nulla, minus molestiae aut!
            </div>
        </section>
        <section id="grande">

            <?php

            $obj = consumir_servicio_REST(URL . "/top5", "POST");
            //var_dump($obj);
            foreach ($obj->top as $inmueble) {

                echo "<article>";
                // echo "hola";
                //echo $inmueble->imagen;
                echo "<img src='img/" . $inmueble->imagen . "' alt='foto_casa'/>";
                echo "<p><span class='destino'>Casa " . $inmueble->cod_inmueble."</span>";
                echo "<br/>";
                echo "<br/>";
                echo "Localidad: " . $inmueble->localidad;
                echo "<br/>";
                echo "Distancia centro: " . $inmueble->distancia_centro . "km";
                echo "<br/>";
                echo "M2: " . ($inmueble->m2 == 0 ? "No" : "Si");
                echo "<br/>";
                echo "Nº Habitaciones: " . $inmueble->num_hab;
                echo "<br/>";
                echo "Garaje: " . ($inmueble->garaje == 0 ? "No" : "Si");
                echo "<br/>";
                echo "Terraza: " . ($inmueble->terraza == 0 ? "No" : "Si");
                echo "<br/>";
                echo "Jardín: " . ($inmueble->jardin == 0 ? "No" : "Si");
                echo "<br/>";
                echo "Piscina: " . ($inmueble->piscina == 0 ? "No" : "Si");
                echo "<br/>";
                echo "</p>";
                echo "</article>";
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


            $("#titulares").on("click", "p:not(.oculta)", function() {
                //console.log("hola");
                if ($(window).width() < 1000)
                    $(this).next().fadeToggle(800);

                $("#grande").html($(this).next().html());


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