<?php
require_once __DIR__ . '/../models/calendarioModel.php';

class calendarioController
{
    public function obtenerCalendario()
    {
        header('Content-Type: application/json; charset=utf-8');
        $model = new calendarioModel();
        $eventos = $model->obtenerEventos();

        echo json_encode($eventos, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }
}
