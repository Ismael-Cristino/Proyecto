<?php
require_once "models/calendarioModel.php";

class calendarioController
{
    private $model;

    public function __construct()
    {
        $this->model = new calendarioModel();
    }

    public function obtenerCalendario(): array
    {
        $anio = $_GET['anio'] ?? date('Y');
        $mes = $_GET['mes'] ?? date('m');
        return $this->model->obtenerFechasMes($anio, $mes);
    }
}
