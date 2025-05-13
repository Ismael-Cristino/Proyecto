<?php
require_once('config/db.php');

class calendarioModel
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = db::conexion(); // Método estático para obtener PDO
    }

    public function obtenerFechasMes(int $anio, int $mes): array
    {
        $inicioMes = "$anio-" . str_pad($mes, 2, '0', STR_PAD_LEFT) . "-01";
        $finMes = date("Y-m-t", strtotime($inicioMes));

        $sql = "SELECT 
                    DATE(f.fecha) as dia,
                    COUNT(*) as total_mudanzas,
                    SUM(f.duracion) as total_horas
                FROM fechas f
                INNER JOIN pedidos p ON p.id_fecha = f.id
                WHERE 
                    f.estado IN ('pagado', 'reservado') AND
                    f.fecha BETWEEN :inicio AND :fin
                GROUP BY dia";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([
            ":inicio" => $inicioMes,
            ":fin" => $finMes
        ]);

        $resultados = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultados[$row['dia']] = [
                "cantidad" => (int)$row['total_mudanzas'],
                "horas" => (float)$row['total_horas']
            ];
        }

        return $resultados;
    }
}