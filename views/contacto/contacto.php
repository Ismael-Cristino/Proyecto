<?php

require_once "assets/php/funciones.php";

$cadena = "";
$errores = [];
$datos = [];
$visibilidad = "invisible";
$tipo = "alert-danger";

if (isset($_REQUEST["error"])) {
    $errores = ($_SESSION["errores"]) ?? [];
    $datos = ($_SESSION["datos"]) ?? [];
    $cadena = "Atención Se han producido Errores";
    $visibilidad = "visible";
}

if (isset($_REQUEST["enviado"])) {
    $cadena = "¡Formulario enviado con éxito!";
    $visibilidad = "visible";
    $tipo = "alert-success";
}

?>

<main class="contenido-Contacto">
    <div class="margen cabecera">
        <h1>Contacto</h1>
    </div>

    <div class="margen contacto-form" id="inicio-3">
        <div class="inicio-3-grid">
            <div class="inicio-3-form calencario-form">
                <h2 class="encabezado">Formulario</h2>
                <div class="alert <?= $tipo ?> <?= $visibilidad ?>"><?= $cadena ?></div>
                <form class="formulario" method="POST" action="/index.php?tabla=formulario&accion=enviar&evento=enviar">
                    <input type="hidden" name="origen" value="contacto">
                    <input type="text" name="nombre" id="nombre" placeholder="Nombre y apellidos" value="<?= $_SESSION["datos"]["nombre"] ?? "" ?>" aria-describedby="nombre">
                    <?= isset($errores["nombre"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "nombre") . '</div>' : ""; ?>

                    <div class="fila-doble">
                        <input type="number" name="numero" id="numero" placeholder="Número de teléfono" value="<?= $_SESSION["datos"]["numero"] ?? "" ?>" aria-describedby="numero">
                        <input type="email" name="email" id="email" placeholder="Dirección de correo electrónico" value="<?= $_SESSION["datos"]["email"] ?? "" ?>" aria-describedby="email">
                    </div>
                    <?= isset($errores["numero"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "numero") . '</div>' : ""; ?>
                    <?= isset($errores["email"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "email") . '</div>' : ""; ?>

                    <input type="date" name="fecha" id="fecha" placeholder="Fecha de la mudanza" value="<?= $_SESSION["datos"]["fecha"] ?? "" ?>" aria-describedby="fecha">
                    <?= isset($errores["fecha"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "fecha") . '</div>' : ""; ?>
                    <select name="servicio" id="servicio">
                        <option value="#"> -- Selecciona un servicio -- </option>
                        <option value="trasladoDom" <?= (isset($_SESSION["datos"]["servicio"]) && $_SESSION["datos"]["servicio"] == "trasladoDom") ? "selected" : "" ?>>Traslado de domicilio</option>
                        <option value="trasladoOfi" <?= isset($_SESSION["datos"]["servicio"]) && $_SESSION["datos"]["servicio"] == "trasladoOfi" ? "selected" : "" ?>>Traslado de oficina</option>
                        <option value="retiro" <?= isset($_SESSION["datos"]["servicio"]) && $_SESSION["datos"]["servicio"] == "retiro" ? "selected" : "" ?>>Retiro de objetos en desuso</option>
                        <option value="vaciado" <?= isset($_SESSION["datos"]["servicio"]) && $_SESSION["datos"]["servicio"] == "vaciado" ? "selected" : "" ?>>Vaciados de trasteros</option>
                        <option value="otros" <?= isset($_SESSION["datos"]["servicio"]) && $_SESSION["datos"]["servicio"] == "otros" ? "selected" : "" ?>>Otros</option>
                    </select>
                    <?= isset($errores["servicio"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "servicio") . '</div>' : ""; ?>
                    <small>Recuera poner en ambos campos: Ciudad, Población, código postal, nº, etc.</small>
                    <div class="fila-direcciones">
                        <input type="text" name="direccionOri" id="direccionOri"
                            placeholder="Dirección Origen (Ciudad, Población, código postal, nº, etc.)" value="<?= $_SESSION["datos"]["direccionOri"] ?? "" ?>" aria-describedby="direccionOri">
                        <img src="assets/img/flecha.png">
                        <input type="text" name="direccionDes" id="direccionDes"
                            placeholder="Dirección Destino (Ciudad, Población, código postal, nº, etc.)" value="<?= $_SESSION["datos"]["direccionDes"] ?? "" ?>" aria-describedby="direccionDes">
                    </div>
                    <?= isset($errores["direccionOri"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "direccionOri") . '</div>' : ""; ?>
                    <?= isset($errores["direccionDes"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "direccionDes") . '</div>' : ""; ?>
                    <textarea name="descripcion" id="descripcion" rows="10" cols="100"
                        placeholder="Describe toda la información posible de la mudanza, que tipos de muebles se van a trasladar, cuantos son los muebles a trasladar, etc."
                        aria-describedby="descripcion"><?= $_SESSION["datos"]["descripcion"] ?? "" ?></textarea>
                    <button type="submit">Envíar formulario</button>

                    <?php
                    //Una vez mostrados los errores, los eliminamos
                    unset($_SESSION["datos"]);
                    unset($_SESSION["errores"]);
                    ?>

                </form>
            </div>

            <div class="inicio-3-info">
                <h2 class="encabezado">Información de Contacto</h2>
                <div class="contacto-detalles">
                    <p><i class="fas fa-map-marker-alt"></i> <strong>Dirección Elche:</strong> Ptda. Algorós 1254 Pol.16 pac. 48 Elche, Alicante</p>
                    <p><i class="fas fa-map-marker-alt"></i> <strong>Dirección Alicante:</strong> Calle García Andreu, 31, 1º A Alicante</p>
                    <p><i class="fas fa-phone"></i> <strong>Teléfono:</strong> <a href="tel:+34123456789">+34 642 657 489</a></p>
                    <p><i class="fas fa-phone"></i> <strong>Teléfono:</strong> <a href="tel:+34123456789">+34 603 169 821</a></p>
                    <p><i class="fas fa-phone"></i> <strong>Teléfono:</strong> <a href="tel:+34123456789">+34 865 555 867</a></p>
                    <p><i class="fas fa-envelope"></i> <strong>Email:</strong> <a href="mailto:info@mudanzaslogistica.com">info@mudanzaslogistica.com</a></p>
                    <p><i class="fas fa-clock"></i> <strong>Horario:</strong> Lunes a Viernes de 9:00 a 19:00</p>
                </div>
            </div>

        </div>
    </div>

    <div class="margen contacto-mapas">
        <h2 class="encabezado">Nuestras Localizaciones</h2>
        <div class="mapas">
            <div class="mapa">
                <h3 class="encabezado-2">Elche</h3>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3133.5547740219895!2d-0.7267677878974332!3d38.24343747175363!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd63b1e9e716b8fb%3A0xbc772addf2891d25!2sMudanzas%20Log%C3%ADstica!5e0!3m2!1ses!2ses!4v1749086339727!5m2!1ses!2ses"
                    width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
            <div class="mapa">
                <h3 class="encabezado-2">Alicante</h3>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5288.005244377203!2d-0.4991695144965667!3d38.34149345674298!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd62374bebb99db1%3A0xaa0d47f8daad7c73!2sMudanzas%20Logistica!5e0!3m2!1ses!2ses!4v1749086098768!5m2!1ses!2ses"
                    width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>

    <div class="margen contacto-cal">
        <h2 class="encabezado">Calendario</h2>
        <div id='calendar'></div>
    </div>
</main>