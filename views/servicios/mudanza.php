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

<main class="contenido-Mudanza">
    <div class="margen mudanza-1">
        <h1>Mudanzas y otros servicios</h1>
    </div>
    <div class="margen mudanza-2">
        <div class="mudanza-2-contenedor">
            <div class="mudanza-2-texto">
                <h2>Tu solución integral para mudanzas y traslados</h2>
                <p>Tanto si se trata de una mudanza local en Alicante o provincia, como un traslado de larga distancia a cualquier otro punto de España,
                    estamos disponibles para ti los 7 días de la semana, las 24 horas del día. En Mudanzas Logística convertimos las dificultades de un
                    traslado en una experiencia sencilla y sin estrés.
                </p>
                <a class="btn btn-info" href="#mudanza-3">Solicita más información</a>
            </div>
            <div class="mudanza-2-imagenes">
                <img src="assets/img/waterfall.jpg" class="mudanza-2-img1">
                <img src="assets/img/waterfall.jpg" class="mudanza-2-img2">
                <img src="assets/img/waterfall.jpg" class="mudanza-2-img3">
            </div>
        </div>
    </div>
    <div class="margen mudanza-3" id="mudanza-3">
        <div class="mudanza-3-cal">
            <h2>Calendario</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores, impedit repellat in natus quaerat omnis id
                cumque quas repudiandae vitae, fugiat itaque a suscipit ea deleniti alias autem voluptates soluta!</p>
        </div>
        <div class="mudanza-3-form">
            <h2>Formulario</h2>
            <div class="alert <?= $tipo ?> <?= $visibilidad ?>"><?= $cadena ?></div>
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
    </div>
    <div class="margen mudanza-5">
        <h2>Por qué elegirnos</h2>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores, impedit repellat in natus quaerat omnis id
            cumque quas repudiandae vitae, fugiat itaque a suscipit ea deleniti alias autem voluptates soluta!</p>
    </div>
    <div class="margen mudanza-6">
        <h2>Reseñas</h2>
        <!-- Elfsight Google Reviews | Untitled Google Reviews -->
        <script src="https://static.elfsight.com/platform/platform.js" async></script>
        <div class="elfsight-app-6ff98a15-1cd5-498a-980f-9627856b749f" data-elfsight-app-lazy></div>
    </div>
    <div class="margen mudanza-7">
        <h2>FAQ</h2>
        <section class="faq-section">
            <h2>Preguntas Frecuentes</h2>

            <div class="faq-item">
                <button class="faq-question">1- ¿Cómo puedo reservar sus servicios?</button>
                <div class="faq-answer">
                    Puede reservar nuestros servicios en línea a través de nuestra página web, o bien puede enviarnos un correo electrónico, un WhatsApp o llamarnos directamente a través de la información proporcionada.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">2- ¿Qué pueden retirar?</button>
                <div class="faq-answer">
                    Tenemos licencia para manipular todos los materiales de desecho no peligrosos. Esto incluye normalmente la mayoría de los artículos que se encuentran dentro de las propiedades y negocios. Le informaremos de cualquier cosa que no tengamos licencia para retirar.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">3- ¿Qué no se puede retirar?</button>
                <div class="faq-answer">
                    No podemos retirar nada peligroso como amianto, aceite, gasolina, gasóleo, botellas de gas, residuos clínicos o biológicos, baterías, neumáticos o pintura.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">4- ¿Qué tipos de pago acepta Mudanzas Logística?</button>
                <div class="faq-answer">
                    Aceptamos transferencias bancarias o efectivo. Se requiere un pequeño depósito de 25€ (veinticinco euros) para confirmar su reserva.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">5- ¿Cuál es el coste?</button>
                <div class="faq-answer">
                    Ofrecemos un presupuesto sin compromiso por teléfono o por correo electrónico. Cobramos por distancia y cantidad a trasladar. Cada trabajo variará en función de la cantidad y el tiempo de carga. Póngase en contacto con nosotros para obtener un presupuesto gratuito y sin compromiso.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">6- ¿Por qué elegir Mudanzas Logística?</button>
                <div class="faq-answer">
                    Estamos bien equipados para manejar cualquier situación de mudanza o traslado. Desde mudanzas locales hasta de larga distancia, mudanzas empresariales y a domicilio, y servicios de embalaje – somos capaces de eliminar el estrés de su mudanza, y llevarle a donde necesita ir.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">7- ¿Qué pasa si tengo que cancelar mi mudanza?</button>
                <div class="faq-answer">
                    A veces, la gente tiene que cancelar las mudanzas. Los traslados y las ofertas de trabajo fracasan, las ventas de casas se frustran y surgen situaciones familiares que hacen inviable la mudanza. Si ha reservado una mudanza y sus planes cambian, lo primero que debe hacer es decidir si se trata realmente de una cancelación o si sólo está posponiendo la mudanza un par de meses.
                    <br><br>
                    Una vez que lo tengas claro, llámanos o envíanos un correo electrónico a <strong>hola@mudanzaslogistica.com</strong> y haznos saber que la mudanza que habías reservado no se realizará ese día.
                    <br><br>
                    La mudanza es un negocio, y como cualquier negocio, agradeceríamos que se avisara con antelación, pero también entendemos que las cancelaciones se producen en el último momento. En el caso de avisar con menos de 72 horas de antelación, perderá su depósito de 25€ (veinticinco euros).
                </div>
            </div>
        </section>
    </div>
    <script>
        // JavaScript para hacer el acordeón funcional
        const faqs = document.querySelectorAll('.faq-question');
        faqs.forEach(faq => {
            faq.addEventListener('click', () => {
                faq.classList.toggle('active');
                const answer = faq.nextElementSibling;
                answer.style.maxHeight = answer.style.maxHeight ? null : answer.scrollHeight + "px";
            });
        });
    </script>
</main>