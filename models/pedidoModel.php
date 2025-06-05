<?php
require_once __DIR__ . '/../config/db.php';

class Pedido
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = db::conexion(); // Devuelve instancia PDO
    }

    public function obtenerEventos()
    {
        $sql = "
            SELECT p.descripcion, p.estado, f.fecha_inicio, f.fecha_fin
            FROM pedidos p
            INNER JOIN fechas f ON p.id_fecha = f.id_fecha
            WHERE p.estado IN ('reservado', 'pagado', 'completado')
        ";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $eventos = [];
        foreach ($pedidos as $pedido) {
            $color = match ($pedido['estado']) {
                'completado' => '#28a745',
                'pagado'     => '#17a2b8',
                'reservado'  => '#007bff',
                default      => '#6c757d',
            };

            $eventos[] = [
                'title' => $pedido['descripcion'],
                'start' => date(DATE_ISO8601, strtotime($pedido['fecha_inicio'])),
                'end'   => date(DATE_ISO8601, strtotime($pedido['fecha_fin'])),
                'color' => $color
            ];
        }

        return $eventos;
    }
}
