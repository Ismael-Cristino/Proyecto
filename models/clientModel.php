<?php
require_once('config/db.php');

class ClientModel {
    private $conexion;

    public function __construct() {
        $this->conexion = db::conexion();
    }

    public function insert(array $client): ?int //devuelve entero o null
    {
        try{
            $sql = "INSERT INTO clients(idFiscal, contact_name, contact_email, contact_phone_number, company_name, company_address, company_phone_number)  VALUES (:idFiscal, :name, :email, :phone, :company_name, :address, :company_phone);";
            $sentencia = $this->conexion->prepare($sql);
            $arrayDatos = [
                ":idFiscal"=>$client["idFiscal"],
                ":name"=>$client["contact_name"],
                ":email"=>$client["contact_email"],
                ":phone"=>$client["contact_phone_number"],
                ":company_name"=>$client["company_name"],
                ":address"=>$client["company_address"],
                ":company_phone"=>$client["company_phone_number"],
            ];
            $resultado = $sentencia->execute($arrayDatos);

            /*Pasar en el mismo orden de los ? execute devuelve un booleano. 
            True en caso de que todo vaya bien, falso en caso contrario.*/
            //Así podriamos evaluar
            return ($resultado == true) ? $this->conexion->lastInsertId() : null;

        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "<bR>";
            return false;
        }
    }

    public function read(int $id): ?stdClass {
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

    public function readAll(): array {
        $sentencia = $this->conexion->prepare("SELECT * FROM clients;");
        $resultado = $sentencia->execute();
        $clientes = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $clientes;
    }

    public function delete (int $id):bool {
        $sql="DELETE FROM clients WHERE id =:id";
        try {
            $sentencia = $this->conexion->prepare($sql);
            //devuelve true si se borra correctamente
            //false si falla el borrado
            $resultado= $sentencia->execute([":id" => $id]);
            return ($sentencia->rowCount ()<=0)?false:true;
        }  catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "<bR>";
            return false;
        }
    }

    public function edit (int $idAntiguo, array $arrayClient):bool{
        try {
            $sql="UPDATE clients SET idFiscal = :idFiscal, contact_name=:name, ";
            $sql.= "contact_email = :email, contact_phone_number = :phone, company_name = :company_name, company_address= :address, company_phone_number = :company_phone ";
            $sql.= " WHERE id = :id;";
                /*$arrayDatos=[
                    ":id"=>$idAntiguo,
                    ":usuario"=>$arrayCliente["usuario"],
                    ":password"=>$arrayCliente["password"],
                    ":name"=>$arrayCliente["name"],
                    ":email"=>$arrayCliente["email"],
                ];*/

            $arrayDatos = [
                ":id"=>$idAntiguo,
                ":idFiscal"=>$arrayClient["idFiscal"],
                ":name"=>$arrayClient["contact_name"],
                ":email"=>$arrayClient["contact_email"],
                ":phone"=>$arrayClient["contact_phone_number"],
                ":company_name"=>$arrayClient["company_name"],
                ":address"=>$arrayClient["company_address"],
                ":company_phone"=>$arrayClient["company_phone_number"],
            ];
            $sentencia = $this->conexion->prepare($sql);
            return $sentencia->execute($arrayDatos); 
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "<bR>";
            return false;
        }
    }

    public function search (string $cliente, string $campo, string $modo):array{
        $sentencia = $this->conexion->prepare("SELECT * FROM clients WHERE $campo LIKE :cliente");
        //ojo el si ponemos % siempre en comillas dobles "
        switch ($modo) {
            case 'empieza':
                $arrayDatos=[":cliente"=>"$cliente%" ];
                break;

            case 'acaba':
                $arrayDatos=[":cliente"=>"%$cliente" ];
                break;

            case 'contiene':
                $arrayDatos=[":cliente"=>"%$cliente%" ];
                break;
            
            default:
                $arrayDatos=[":cliente"=>$cliente];
                break;
        }

        $resultado = $sentencia->execute($arrayDatos);
        if (!$resultado) return [];
        $clients = $sentencia->fetchAll(PDO::FETCH_OBJ); 
        return $clients;
    }

    public function exists(string $campo, string $valor, int $idExcluido = null): bool {
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
