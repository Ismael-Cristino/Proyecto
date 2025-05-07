<?php
require_once "controllers/formularioController.php";

//pagina invisible
$controlador = new FormularioController();

$datos = [
    "nombre" => $_REQUEST["nombre"],
    "numero" => $_REQUEST["numero"],
    "email" => $_REQUEST["email"],
    "fecha" => $_REQUEST["fecha"],
    "servicio" => $_REQUEST["servicio"],
    "direccionOri" => $_REQUEST["direccionOri"],
    "direccionDes" => $_REQUEST["direccionDes"],
    "descripcion" => $_REQUEST["descripcion"],
];

if ($_REQUEST["evento"] == "enviar") {
    $controlador->solicitar($datos);
}
