<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/principal.css">
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@500&family=Montserrat&display=swap" rel="stylesheet">
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
                <li class="oculto"><button type="input" name="perfil">PERFIL</button></li>
                <li><button type="input" name="buscar">BUSCAR</button></li>
                <li><button type="input" name="contratos">CONTRATOS</button></li>
                <li><button type="input" name="propiedades">PROPIEDADES</button></li>
                <li><button type="input" name="salir">SALIR</button></li>
            </ul>
        </form>
        <div id="escritorio">
            <p><?php echo $_SESSION["nombre"]; ?></p>
            <?php
            $datos = array(
                "email" => $_SESSION["email"]
            );
            // var_dump($datos);

            $obj = consumir_servicio_REST(URL . "/usuario", "POST", $datos);
            $_SESSION["id_usu"] = $obj->usuario->cod_usuario;
            echo "<a href='principal.php?perfil'><img src='img/" . $obj->usuario->foto_perfil . "' alt='foto-perfil'/></a>"
            ?>
        </div>
    </header>
    <main>
        <section id="titulares">
            <form action="principal.php" method="post">


                <input <?php if (isset($_POST["mas_buscados"])) echo 'style="background-color:#ed217d"'; ?>type='submit' name='mas_buscados' class="titulo_prueba" value='Los + buscados'>

                <input <?php if (isset($_POST["mas_economicos"])) echo 'style="background-color:#ed217d"'; ?> type='submit' name='mas_economicos' class="titulo_prueba" value='Los + económicos'>
                <input <?php if (isset($_POST["protegida"])) echo 'style="background-color:#ed217d"'; ?> type='submit' name='protegida' class="titulo_prueba" value='Tu casa protegida'>
                <input <?php if (isset($_POST["top5"])) echo 'style="background-color:#ed217d"'; ?> type='submit' name='top5' class="titulo_prueba" value='Top 5'>


            </form>

        </section>
        <section id="grande2">

            <?php
            if (isset($_POST["top5"])) {
            

$obj = consumir_servicio_REST(URL . "/top5", "POST");
                //var_dump($obj);
                foreach ($obj->top as $inmueble) {

                    echo "<article>";
                    // echo "hola";
                    //echo $inmueble->imagen;

                    echo "<p><span class='destino'>Casa " . $inmueble->cod_inmueble . "</span>";
                    echo "<br/>";
                    echo "<img src='img/" . $inmueble->imagen . "' alt='foto_casa'/>";
                    echo "Localidad: " . $inmueble->localidad;
                    echo "<br/>";
                    echo "Distancia centro: " . $inmueble->distancia_centro . "km";
                    echo "<br/>";
                    echo "M2: " . ($inmueble->m2);
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
                    echo "Puntuación: ";
                    $estrellas = (int) $inmueble->media_estrellas;

                    for ($i = 0; $i < $estrellas; $i++) {
                        echo "⭐";
                    }
                    echo "<br/>";

                    echo "(" . $inmueble->total_comenta . ($inmueble->total_comenta == 1 ? " opinión" : " opiniones") . ")";
                    echo "</p>";
                    echo "</article>";
                }
            


            } elseif (isset($_POST["mas_economicos"])) {
            ?>

                <article>

                    <p><span class="destino">Camboya</span>
                        <br />
                        <img src="https://content.skyscnr.com/m/055ab35306c6c272/original/GettyImages-474347378.jpg?resize=1800px:1800px&quality=100" alt="camboya" />
                        En Camboya podrás encontrar alojamiento a partir de 7 euros la noche. Y si quieres el lujo de disponer de aire acondicionado, unos 10 euros. Un buen plato de pescado en Khmer Amok te costará entorno a los 4 euros.
                    </p>
                </article>
                <article>

                    <p><span class="destino">Malasia</span>
                        <br />
                        <img src="https://content.skyscnr.com/m/72e1e49275db7466/original/GettyImages-480173148.jpg?resize=1800px:1800px&quality=100" alt="malasia" />
                        Si te apasiona probar platos nuevos, pero siempre aparece el fantasma del dinero arruinando cada plan que haces, tu destino es Malasia.
                    </p>
                </article>
                <article>

                    <p><span class="destino">Paraguay</span>
                        <br />
                        <img src="https://content.skyscnr.com/m/1b5dc12e5372c2a7/original/GettyImages-178820829_doc.jpg?resize=1800px:1800px&quality=100" alt="paraguay" />
                        Con la capital, Asunción, considerada la ciudad más barata del mundo, este país escala posiciones en el top de los países más baratos del mundo a los que ir a pasar unas vacaciones de lujo.
                    </p>
                </article>
                <article>

                    <p><span class="destino">Bolivia</span>
                        <br />
                        <img src="https://content.skyscnr.com/m/0309f59d3544aa9f/original/GettyImages-99446039.jpg?resize=1800px:1800px&quality=100" alt="bolivia" />
                        Bolivia es uno de los países más baratos por excelencia y más teniendo en cuenta que puedes sobrevivir, moverte y conocer el país por menos de 19 euros al día.
                    </p>

                </article>
                <a href="https://www.skyscanner.es/noticias/inspiracion/los-20-paises-mas-baratos-a-los-que-ir-de-vacaciones">Artículo de skyscanner.es</a>

            <?php


            } elseif (isset($_POST["protegida"])) {
            ?>
                <article class="robo">
                    <p>
                        <span class="destino">Cómo proteger tu casa</span>
                        <br />
                        <br />
                        ⚪ Que se vea que tu hogar está protegido.
                        <br /> Está demostrado que una casa con un sistema de seguridad visible, con cámaras de vigilancia o carteles de la compañía que nos proporciona el servicio puede llegar a disuadir a los ladrones de intentar robar en ella. Hoy en día existen alarmas que se pueden conectar o desconectar desde un smartphone y te permiten ver imágenes en tiempo real del interior de la vivienda.
                        <br />
                        ⚪ La discreción es muy importante. <br />
                        No comentes, excepto a tus más allegados y personas de confianza, cuándo y durante cuánto tiempo vas a estar fuera de casa. Tampoco publiques en las redes sociales nada relativo a tus próximas vacaciones o escapadas ya que estarás dando pistas a los cacos para saber cuándo es el mejor momento para hacer de las suyas.
                        <br />
                        ⚪ Que no parezca que tu casa está vacía.<br />
                        No dejes las persianas bajadas y asegúrate de que no se va acumulando el correo en tu buzón. Éstos son signos inequívocos de que no hay nadie en casa. Pídele a un amigo o un familiar, incluso un vecino de confianza que recoja tus cartas y abra y cierre las ventanas para que se vea movimiento. Si te vas por pocos días, podrías dejar ropa tendida. Si cuentas con alumbrado exterior, déjalo encendido, y si es posible deja alguna luz prendida en el interior para dar la impresión de que la casa no está sola.
                        <br />
                        ⚪ Asegúrate de que no existen accesos fáciles a tu vivienda.<br />
                        Otro de los consejos para proteger tu casa cuando no estás es revisar las posibles entradas a través de balcones, árboles o estructuras de la propia vivienda como canalones. No escondas la llave en una maceta, en la caja de contadores o en los alrededores de la vivienda ya que se pueden encontrar con relativa facilidad.
                        <br />
                        ⚪ Ve un paso por delante de los ladrones.<br />
                        Hoy en día uno de los métodos más usados para evitar el correcto funcionamiento de dispositivos electrónicos es el uso de inhibidores. Afortunadamente existen en el mercado soluciones de seguridad que permiten conectarse con la Central Receptora de Alarmas de forma inalámbrica o por cable incluso si el sistema está siendo boicoteado.
                    </p>
                </article>

            <?php
            } else {
?>
                <article>

                <p><span class="destino">Londres</span>
                    <br />
                    <img src="img/londres.jpg" alt="londres" />
                    Es el destino más buscado en Google, no es de extrañar, debido a que es la mayor ciudad y área urbana de Gran Bretaña y de toda la Unión Europea. Con todas las zonas de interés cultural que Londres tiene es normal que sea uno de los destinos preferidos por los ínter nautas para elegir como destino vacacional.
                </p>
            </article>
            <article>

                <p><span class="destino">Tailandia</span>
                    <br />
                    <img src="img/tailandia.jpg" alt="tailandia" />
                    Uno de los destinos favoritas para realizar un viaje de novios, la combinación de zonas culturales con zonas paradisíacas de playas hacen de Tailandia un destino muy solicitado por los recién casados. Un destino bastante económico para pasar una temporada larga allí y empaparte de la cultura milenaria asiática de diferentes zonas de Tailandia.
                </p>
            </article>
            <article>

                <p><span class="destino">París</span>
                    <br />
                    <img src="img/paris.jpg" alt="paris" />
                    El tercer destino más buscado en Google es París, la ciudad del amor, un destino romántico con un gran interés cultural en territorio Francés. Destacan diferentes lugares para visitar como la Torre Eiffel, Disneyland Paris o la Catedral de Notre Dame.
                </p>
            </article>
            <article>

                <p><span class="destino">Roma</span>
                    <br />
                    <img src="img/roma.jpg" alt="roma" />
                    Preciosa ciudad llena de lugares culturales que visitar, en cuanto pises Roma notarás que respiras historia en casi cualquier zona. Espectaculares monumentos te esperan para que puedas visitarlos con total tranquilidad y disfrutes de su belleza y cultura italiana.
                </p>

            </article>
            <a href="https://www.felicesvacaciones.es/blog/los-destinos-mas-buscados-en-google">Artículo de felicesvacaciones.es</a>
<?php
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
</body>

</html>