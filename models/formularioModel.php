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

    public function read(int $id): ?stdClass
    {
        $sentencia = $this->conexion->prepare("SELECT * FROM clients WHERE id=:id");
        $arrayDatos = [":id" => $id];
        $resultado = $sentencia->execute($arrayDatos);
        // ojo devuelve true si la consulta se ejecuta correctamente
        // eso no quiere decir que hayan resultados
        if (!$resultado) return null;
        //como sólo va a devolver un resultado uso fetch
        // DE Paso probamos el FETCH_OBJ
        $client = $sentencia->fetch(PDO::FETCH_OBJ);
        //fetch duevelve el objeto stardar o false si no hay persona
        return ($client == false) ? null : $client;
    }

    public function readAll(): array
    {
        $sentencia = $this->conexion->prepare("SELECT * FROM clients;");
        $resultado = $sentencia->execute();
        $clientes = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $clientes;
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM clients WHERE id =:id";
        try {
            $sentencia = $this->conexion->prepare($sql);
            //devuelve true si se borra correctamente
            //false si falla el borrado
            $resultado = $sentencia->execute([":id" => $id]);
            return ($sentencia->rowCount() <= 0) ? false : true;
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "<bR>";
            return false;
        }
    }

    public function edit(int $idAntiguo, array $arrayClient): bool
    {
        try {
            $sql = "UPDATE clients SET idFiscal = :idFiscal, contact_name=:name, ";
            $sql .= "contact_email = :email, contact_phone_number = :phone, company_name = :company_name, company_address= :address, company_phone_number = :company_phone ";
            $sql .= " WHERE id = :id;";
            /*$arrayDatos=[
                    ":id"=>$idAntiguo,
                    ":usuario"=>$arrayCliente["usuario"],
                    ":password"=>$arrayCliente["password"],
                    ":name"=>$arrayCliente["name"],
                    ":email"=>$arrayCliente["email"],
                ];*/

            $arrayDatos = [
                ":id" => $idAntiguo,
                ":idFiscal" => $arrayClient["idFiscal"],
                ":name" => $arrayClient["contact_name"],
                ":email" => $arrayClient["contact_email"],
                ":phone" => $arrayClient["contact_phone_number"],
                ":company_name" => $arrayClient["company_name"],
                ":address" => $arrayClient["company_address"],
                ":company_phone" => $arrayClient["company_phone_number"],
            ];
            $sentencia = $this->conexion->prepare($sql);
            return $sentencia->execute($arrayDatos);
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "<bR>";
            return false;
        }
    }

    public function search(string $cliente, string $campo, string $modo): array
    {
        $sentencia = $this->conexion->prepare("SELECT * FROM clients WHERE $campo LIKE :cliente");
        //ojo el si ponemos % siempre en comillas dobles "
        switch ($modo) {
            case 'empieza':
                $arrayDatos = [":cliente" => "$cliente%"];
                break;

            case 'acaba':
                $arrayDatos = [":cliente" => "%$cliente"];
                break;

            case 'contiene':
                $arrayDatos = [":cliente" => "%$cliente%"];
                break;

            default:
                $arrayDatos = [":cliente" => $cliente];
                break;
        }

        $resultado = $sentencia->execute($arrayDatos);
        if (!$resultado) return [];
        $clients = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $clients;
    }

    public function exists(string $campo, string $valor, int $idExcluido = null): bool
    {
        $sql = "SELECT * FROM clients WHERE $campo = :valor";
        $params = [":valor" => $valor];

        if ($idExcluido !== null) {
            $sql .= " AND id != :id";
            $params[":id"] = $idExcluido;
        }

        $sentencia = $this->conexion->prepare($sql);
        $resultado = $sentencia->execute($params);
        return ($resultado && $sentencia->rowCount() > 0);
    }
}
