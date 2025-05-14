<?php
require_once __DIR__ . '/../config/db.php';

class calendarioModel
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = db::conexion(); // Método estático para obtener PDO
    }

    public function obtenerFechas()
    {
        $sql = "
            SELECT f.fecha, COUNT(p.id_pedido) as total_mudanzas,
                   SUM(p.horas) as total_horas, p.descripcion, f.id_fecha
            FROM fechas f
            LEFT JOIN pedidos p ON p.id_fecha = f.id_fecha
            WHERE f.estado IN ('reservado', 'pagado')
            GROUP BY f.fecha
        ";
        $stmt = $this->conexion->query($sql);
        $fechas = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $color = '#28a745'; // Verde por defecto (libre)

            if (date('w', strtotime($row['fecha'])) == 0) {
                $color = '#dc3545'; // Domingo (no laboral)
            } elseif ($row['total_mudanzas'] >= 5 || $row['total_horas'] > 8) {
                $color = '#dc3545'; // Rojo
            } elseif ($row['total_mudanzas'] >= 1 || $row['total_horas'] <= 6) {
                $color = '#ffc107'; // Amarillo
            }

            $horas = (float) $row['total_horas'];

            // Si hay más de 6h, marcar todo el día como ocupado
            if ($horas > 6) {
                $start = (new DateTime($row['fecha']))->format('Y-m-d');
                $end = (new DateTime($row['fecha']))->format('Y-m-d');
            } else {
                // Fecha con hora específica
                $startDateTime = new DateTime($row['fecha']);
                $horasEnteras = floor($horas);
                $minutos = ($horas - $horasEnteras) * 60;

                $interval = new DateInterval(sprintf('PT%dH%dM', $horasEnteras, $minutos));
                $endDateTime = clone $startDateTime;
                $endDateTime->add($interval);

                $start = $startDateTime->format('Y-m-d\TH:i:s');
                $end = $endDateTime->format('Y-m-d\TH:i:s');
            }

            $fechas[] = [
                'start' => $start,
                'end' => $end,
                'display' => 'background',
                'color' => $color,
                'title' => $row['descripcion'] ?? '',
                'constraint' => $row['id_fecha'],
            ];
        }


        return $fechas;
    }
}
