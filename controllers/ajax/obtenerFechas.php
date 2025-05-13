<?php
require_once '../../models/calendarioModel.php';

$calendario = new CalendarioModel();
$fechas = $calendario->obtenerFechas();

header('Content-Type: application/json');
echo json_encode($fechas);