<?php
require_once('config/db.php');

class FormularioModel
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = db::conexion();
    }

    public function insert(array $datos): ?int
    {
        try {
            $this->conexion->beginTransaction();

            // Insertar en Clientes
            $sqlCliente = "INSERT INTO clientes (nombre, email, tel)
                       VALUES (:nombre, :email, :tel)";
            $stmtCliente = $this->conexion->prepare($sqlCliente);
            $stmtCliente->execute([
                ':nombre' => $datos['nombre'],
                ':email'  => $datos['email'],
                ':tel'    => $datos['numero'],
            ]);
            $id_cliente = $this->conexion->lastInsertId();

            // Insertar en Fechas
            $sqlFecha = "INSERT INTO fechas (fecha, estado)
                     VALUES (:fecha, :estado)";
            $stmtFecha = $this->conexion->prepare($sqlFecha);
            $stmtFecha->execute([
                ':fecha'  => $datos['fecha'],
                ':estado' => 'pendiente', // puedes cambiarlo si hay lógica específica
            ]);
            $id_fecha = $this->conexion->lastInsertId();

            // Inicializar factura para más adelante
            $sqlFact = "INSERT INTO facturas (precio_bruto, iva, precio_final)
                     VALUES (:precio_bruto, :iva, :precio_final)";
            $stmtFact = $this->conexion->prepare($sqlFact);
            $stmtFact->execute([
                ':precio_bruto'  => 0,
                ':iva' => 0,
                ':precio_final'=> 0,
            ]);
            $id_fact = $this->conexion->lastInsertId();

            // Insertar en Pedidos
            $sqlPedido = "INSERT INTO Pedidos (id_cliente, id_fecha, id_factura, servicio, origen, destino, estado, descripcion)
                      VALUES (:id_cliente, :id_fecha, :id_factura, :servicio, :origen, :destino, :estado, :descripcion)";
            $stmtPedido = $this->conexion->prepare($sqlPedido);
            $stmtPedido->execute([
                ':id_cliente'  => $id_cliente,
                ':id_fecha'    => $id_fecha,
                ':id_factura'    => $id_fact,
                ':servicio'    => $datos['servicio'],
                ':origen'      => $datos['direccionOri'],
                ':destino'     => $datos['direccionDes'],
                ':estado'      => 'pendiente', // estado del pedido
                ':descripcion' => $datos['descripcion'] ?? null, // puede no estar definido
            ]);
            $id_pedido = $this->conexion->lastInsertId();

            $this->conexion->commit();
            return $id_pedido;
        } catch (Exception $e) {
            $this->conexion->rollBack();
            echo 'Excepción capturada: ', $e->getMessage(), "<br>";
            return null;
        }
    }
}
