<?php

require_once "assets/php/funciones.php";

$cadena = "";
$errores = [];
$datos = [];
$visibilidad = "invisible";
if (isset($_REQUEST["error"])) {
    $errores = ($_SESSION["errores"]) ?? [];
    $datos = ($_SESSION["datos"]) ?? [];
    $cadena = "Atención Se han producido Errores";
    $visibilidad = "visible";
}

?>

<main class="contenido-Inicio">
    <div class="margen inicio-1">
        <div class="inicio-1-contenedor">
            <div class="inicio-1-texto">
                <h1>MUDANZAS LOGISTICA</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore, fugiat ab excepturi dolore aliquam
                    commodi nesciunt iste aperiam sunt recusandae voluptates eum doloremque assumenda, repellendus at! In
                    earum
                    dolorem a.</p>
            </div>
            <div class="inicio-1-presupuesto">
                <h5>¡Pídenos presupuesto!</h5>
                <small>Sin compromiso</small>
                <hr>
                </hr>
                <p class="inicio-1-presupuesto-numeros"><i class="fa fa-phone"></i> +34 642 657 489</p>
                <p class="inicio-1-presupuesto-numeros"><i class="fa fa-phone"></i> +34 603 169 821</p>
                <p class="inicio-1-presupuesto-numeros"><i class="fa fa-phone"></i> +34 865 555 867</p>
                <hr>
                </hr>
                <p>O a través de nuestro formulario</p>
                <a class="btn btn-info" href="#inicio-4">Solicitud de presupuesto</a>
            </div>
        </div>
    </div>
    <div class="margen inicio-2">
        <div class="inicio-2-contenedor">
            <div class="inicio-2-imagenes">
                <img src="assets/img/waterfall.jpg" class="inicio-2-img1">
                <img src="assets/img/waterfall.jpg" class="inicio-2-img2">
                <img src="assets/img/waterfall.jpg" class="inicio-2-img3">
            </div>
            <div class="inicio-2-texto">
                <h2>Sobre nosotros</h2>
                <p>En Mudanzas Logística somos expertos en mudanzas, ofreciendo un servicio seguro, eficiente y
                    personalizado. Nos encargamos de todo el proceso: embalaje, carga, transporte y descarga,
                    cuidando cada detalle para que no tengas que preocuparte por nada.
                </p>
                <a class="btn btn-info" href="#inicio-4">Solicita más información</a>
                <ul>
                    <li>Servicio de mudanzas locales y nacionales</li>
                    <li>Embalaje profesional de muebles y objetos delicados</li>
                    <li>Trasteros y guardamuebles seguros</li>
                    <li>Personal capacitado</li>
                    <li>Transporte rápido y puntual</li>
                    <li>Presupuestos sin compromiso</li>
                    <li>Amplia experiencia en el sector</li>
                    <li>Compromiso con el cuidado de tus pertenencias</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="margen inicio-3">
        <h2>Calendario</h2>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores, impedit repellat in natus quaerat omnis id
            cumque quas repudiandae vitae, fugiat itaque a suscipit ea deleniti alias autem voluptates soluta!</p>
    </div>
    <div class="margen inicio-4" id="inicio-4">
        <div class="inicio-4-cal">

        </div>
        <div class="inicio-4-form">
            <h2>Formulario</h2>
            <form class="formulario" method="POST" action="index.php?tabla=formulario&accion=enviar&evento=enviar">
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
                    <option value="trasladoOfi" <?= isset($_SESSION["datos"]["servicio"]) && $_SESSION["datos"]["servicio"] == "trasladoOfi" ? "selected" : ""?>>Traslado de oficina</option>
                    <option value="retiro" <?= isset($_SESSION["datos"]["servicio"]) && $_SESSION["datos"]["servicio"] == "retiro" ? "selected" : ""?>>Retiro de objetos en desuso</option>
                    <option value="vaciado" <?= isset($_SESSION["datos"]["servicio"]) && $_SESSION["datos"]["servicio"] == "vaciado" ? "selected" : ""?>>Vaciados de trasteros</option>
                    <option value="otros" <?= isset($_SESSION["datos"]["servicio"]) && $_SESSION["datos"]["servicio"] == "otros" ? "selected" : ""?>>Otros</option>
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
    </div>
    <div class="margen inicio-5">
        <h2>Por qué elegirnos</h2>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores, impedit repellat in natus quaerat omnis id
            cumque quas repudiandae vitae, fugiat itaque a suscipit ea deleniti alias autem voluptates soluta!</p>
    </div>
    <div class="margen inicio-6">
        <h2>Reseñas</h2>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores, impedit repellat in natus quaerat omnis id
            cumque quas repudiandae vitae, fugiat itaque a suscipit ea deleniti alias autem voluptates soluta!</p>
    </div>
    <div class="margen inicio-7">
        <h2>FAQ</h2>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores, impedit repellat in natus quaerat omnis id
            cumque quas repudiandae vitae, fugiat itaque a suscipit ea deleniti alias autem voluptates soluta!</p>
    </div>
</main>