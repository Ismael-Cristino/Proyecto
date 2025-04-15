<?php
require_once('config/db.php');

class TaskModel
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = db::conexion();
    }

    public function search(string $campo = "id", string $metodo = "contiene", string $dato = ""): array
    {
        $sentencia = $this->conexion->prepare("SELECT tasks.*, users.usuario AS usuario_user, 
        users.name AS name_user, clients.contact_name AS contact_name_client, 
        clients.idFiscal AS idFiscal_client, clients.company_name AS company_name_client
        FROM 
            tasks
        LEFT JOIN 
            users ON tasks.user_id = users.id
        LEFT JOIN 
            clients ON tasks.client_id = clients.id
        WHERE 
            $campo LIKE :dato");

        //ojo el si ponemos % siempre en comillas dobles "
        switch ($metodo) {
            case "contiene":
                $arrayDatos = [":dato" => "%$dato%"];
                break;
            case "empieza":
                $arrayDatos = [":dato" => "$dato%"];
                break;
            case "acaba":
                $arrayDatos = [":dato" => "%$dato"];
                break;
            case "igual":
                $arrayDatos = [":dato" => "$dato"];
                break;
            default:
                $arrayDatos = [":dato" => "%$dato%"];
                break;
        }
        
        $resultado = $sentencia->execute($arrayDatos);
        // if (!$resultado) return [];
        // $tasks = $sentencia->fetchAll(PDO::FETCH_OBJ);
        // return $tasks;
        // lo anterior se puede sustituir sólo por 
        return $resultado?$sentencia->fetchAll(PDO::FETCH_OBJ):[];
    }

    public function insert(array $nuevaTask): ?int //devuelve entero o null
    {

        try {
            $sql = "INSERT INTO tasks (name, description, deadline, task_status, user_id, client_id, project_id)";
            $sql.=" VALUES (:name, :description,:deadline, :task_status, :user_id, :client_id, :project_id);";
            $sentencia = $this->conexion->prepare($sql);
            $arrayDatos = [
                ":name" => $nuevaTask["name"],
                ":description" => $nuevaTask["description"],
                ":deadline" => $nuevaTask["deadline"],
                ":task_status" => $nuevaTask["task_status"],
                ":user_id" => $nuevaTask["user_id"],
                ":client_id" => $nuevaTask["client_id"],
                ":project_id" => $nuevaTask["project_id"],
            ];
            var_dump($arrayDatos);
            $resultado = $sentencia->execute($arrayDatos);
            return ($resultado == true) ? $this->conexion->lastInsertId() : null;
        } catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "<bR>";
            return null;
        }
    }

    public function edit(int $idAntiguo, array $arrayTask): bool
    {
        try {
            $sql = "UPDATE tasks SET name = :name, description=:description, ";
            $sql .= "deadline = :deadline, task_status= :task_status, user_id=:user_id,client_id=:client_id,project_id=:project_id";
            $sql .= " WHERE id = :id;";
            $arrayDatos = [
                ":id" => $idAntiguo,
                ":name" => $arrayTask["name"],
                ":description" => $arrayTask["description"],
                ":deadline" => $arrayTask["deadline"],
                ":task_status" => $arrayTask["task_status"],
                ":user_id" => $arrayTask["user_id"],
                ":client_id" => $arrayTask["client_id"],
                ":project_id" => $arrayTask["project_id"],
            ];
            $sentencia = $this->conexion->prepare($sql);
            return $sentencia->execute($arrayDatos);
        } catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "<bR>";
            return false;
        }
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM tasks WHERE id =:id";
        try {
            $sentencia = $this->conexion->prepare($sql);
            //devuelve true si se borra correctamente
            //false si falla el borrado
            $resultado = $sentencia->execute([":id" => $id]);
            return ($sentencia->rowCount() <= 0) ? false : true;
        } catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "<bR>";
            return false;
        }
    }

    public function readAll(): array {
        //$sentencia = $this->conexion->query("SELECT * FROM projects;");
        $sql= "select tasks.*,  users.name as name_user,users.usuario as usuario_user, ";
        $sql.="clients.contact_name as contact_name_client, clients.idFiscal as idFiscal_client, ";
        $sql.="clients.company_name as company_name_client ";
        $sql.="from tasks ";
        $sql.="left join clients  on  (tasks.client_id=clients.id) "; 
        $sql.="inner join users  on  (tasks.user_id=users.id);";
        //usamos método query
        $sentencia = $this->conexion->query($sql);
        $tasks = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $tasks;
    }

    public function read(int $id): ?stdClass
    {
        $sql= "select tasks.*,  users.name as name_user,users.usuario as usuario_user, ";
        $sql.="clients.contact_name as contact_name_client, clients.idFiscal as idFiscal_client, ";
        $sql.="clients.company_name as company_name_client ";
        $sql.="from tasks ";
        $sql.="left join clients  on  (tasks.client_id=clients.id) "; 
        $sql.="inner join users  on  (tasks.user_id=users.id) ";
        $sql.= " WHERE tasks.id=:id ";
        
        $sentencia = $this->conexion->prepare($sql);
        $arrayDatos = [":id" => $id];
        $resultado = $sentencia->execute($arrayDatos);
        // ojo devuelve true si la consulta se ejecuta correctamente
        // eso no quiere decir que hayan resultados
        if (!$resultado) return null;
        //como sólo va a devolver un resultado uso fetch
        // DE Paso probamos el FETCH_OBJ
        $task = $sentencia->fetch(PDO::FETCH_OBJ);
        //fetch duevelve el objeto stardar o false si no hay persona
        return ($task == false) ? null : $task;
    }

    public function searchbyUser(stdClass $task, string $campo = "id", string $metodo = "contiene", string $dato = ""): array
    {
        $sql= "select tasks.*,  users.name as name_user,users.usuario as usuario_user, ";
        $sql.="clients.contact_name as contact_name_client, clients.idFiscal as idFiscal_client, ";
        $sql.="clients.company_name as company_name_client ";
        $sql.="from tasks ";
        $sql.="left join clients  on  (tasks.client_id=clients.id) "; 
        $sql.="inner join users  on  (tasks.user_id=users.id) ";
        $sql.= " WHERE tasks.user_id= :user_id AND $campo LIKE :dato ;";
        $sentencia = $this->conexion->prepare($sql);
        //ojo el si ponemos % siempre en comillas dobles "
        $arrayDatos[":user_id"]= $task->id;
        switch ($metodo) {
            case "contiene":
                $arrayDatos [":dato"] = "%$dato%";
                break;
            case "empieza":
                $arrayDatos [":dato"] = "$dato%";
                break;
            case "acaba":
                $arrayDatos [":dato"] = "%$dato";
                break;
            case "igual":
                $arrayDatos [":dato"] = "$dato";
                break;
            default:
            $arrayDatos [":dato"] = "%$dato%";
                break;
        }

        $resultado = $sentencia->execute($arrayDatos);
        if (!$resultado) return [];
        $tasks = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $tasks;
    }
}