<?php
$rutaJs = GenerarRutaJs($vista);
echo (file_exists($rutaJs)) ? "<script src={$rutaJs}></script>" : "";
?>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>

<footer class="footer">
    <div class="footer-contenido margen">
        <div class="footer-col logo">
            <img src="assets/img/truck.png" alt="Logo de la empresa">
        </div>

        <div class="footer-col">
            <h4>Enlaces</h4>
            <div>
                <a href="index.php">Inicio</a><br>
                <a href="index.php?tabla=servicios&accion=mudanza">Mudanzas y otros servicios</a><br>
                <a href="index.php?tabla=servicios&accion=trastero">Trasteros y Guardamuebles</a><br>
                <a href="index.php?tabla=contacto&accion=ir">Contacto</a>
            </div>
        </div>

        <div class="footer-col contacto">
            <h4>Contacto</h4>
            <p><i class="fas fa-phone"></i> +34 642 657 489</p>
            <p><i class="fas fa-phone"></i> +34 603 169 821</p>
            <p><i class="fas fa-phone"></i> +34 865 555 867</p>
            <p><i class="fas fa-map-marker-alt"></i> Calle García Andreu, 31, 1º A Alicante</p>
            <p><i class="fas fa-map-marker-alt"></i> Ptda. Algorós 1254 Pol.16 pac. 48 Elche, Alicante</p>
            <p><i class="fas fa-envelope"></i> <a href="mailto:info@mudanzaslogistica.com">info@mudanzaslogistica.com</a></p>
        </div>

        <div class="footer-col redes">
            <h4>Síguenos</h4>
            <div class="redes-iconos">
                <a href="https://www.facebook.com/mudanzaslogisticaalicante" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.instagram.com/mudanzaslogisticaalicante/" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="#" target="_blank"><i class="fab fa-whatsapp"></i></a>
            </div>
        </div>
    </div>

    <div class="footer-inferior">
        <img src="assets/img/logos.png" alt="Financiado por la UE">
    </div>
</footer>

</body>

</html>