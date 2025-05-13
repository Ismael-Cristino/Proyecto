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
            "ir" => "../inicio.php",
        ],
        "servicios" => [ //defino las acciones permitidas para esa tabla
            "mudanza" => "mudanza.php",
            "trastero" => "trastero.php",
        ],
        "contacto" => [ //defino las acciones permitidas para esa tabla
            "ir" => "contacto.php",
        ],
    ];

    $tabla = $_REQUEST["tabla"];
    if (!isset($tablas[$tabla])) return "views/404.php";

    // si no hay accion definimos por defecto la accion listar
    if (!isset($_REQUEST["accion"])) return "views/{$tabla}/list.php";
    // Si la acción no está permitda
    $accion = $_REQUEST["accion"];
    if (!isset($tablas[$tabla][$accion])) return "views/404.php";

    if ($tabla === "calendario" && $accion === "obtener") {
        require_once "controller/calendarioController.php";
        $controller = new calendarioController();
        $GLOBALS["fechas"] = $controller->obtenerCalendario(); // Así lo compartes con la vista
    }

    // Por ejemplo si recibo la tabla=user y accion= listar
    // esto llamará a la vista
    // views/user/list.php dentro del require
    return "views/{$tabla}/{$tablas[$tabla][$accion]}";
}
