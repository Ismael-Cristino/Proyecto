<?php

function GenerarRutaJs(string $route): string
{
    $ultimo = strrpos($route, "/");
    $ruta = substr($route, 0, $ultimo);
    $partes = (explode("/", $route));
    $fichero = end($partes);
    $partes2 = explode(".", $fichero);
    $nombreFichero = $partes2[0] . ".js";
    $path = $ruta . "/js/" . $nombreFichero;
    return $path;
}

function router()
{
    $url = $_SERVER["REQUEST_URI"];

    // si pongo sólo la barra asumo que es ruta por defecto
    if (substr($url, -1) == "/") return "views/inicio.php";

    if (!strpos($url, "index.php")) return "views/404.php";

    // si hay index y no hay tabla Vista por defecto
    if (!isset($_REQUEST["tabla"])) return "views/inicio.php";

    $tablas = [
        "formulario" => [ //defino las acciones permitidas para esa tabla
            "enviar" => "enviarForm.php",
        ],
        "inicio" => [ //defino las acciones permitidas para esa tabla
            "ir" => "inicio.php",
        ],
        "servicios" => [ //defino las acciones permitidas para esa tabla
            "mudanza" => "mudanza.php",
            "trastero" => "trastero.php",
        ],
        "contacto" => [ //defino las acciones permitidas para esa tabla
            "ir" => "contacto.php",
        ],
        "calendario" => [
            "obtener" => null // no necesita archivo porque se maneja manualmente
        ],
    ];

    $tabla = $_REQUEST["tabla"];
    $accion = $_REQUEST["accion"] ?? null;

    // 👇 Añade esta parte justo después de extraer tabla y acción
    if ($tabla === "calendario" && $accion === "obtener") {
        require_once "controllers/calendarioController.php";
        $controller = new calendarioController();
        $controller->obtenerCalendario();
        exit;
    }


    // Verifica que la tabla existe
    if (!isset($tablas[$tabla])) return "views/404.php";

    // Si no hay acción, defino por defecto
    if ($accion === null) return "views/{$tabla}/list.php";

    // Acción no permitida
    if (!isset($tablas[$tabla][$accion])) return "views/404.php";

    // Continúa normalmente si no es calendario
    return "views/{$tabla}/{$tablas[$tabla][$accion]}";
}
