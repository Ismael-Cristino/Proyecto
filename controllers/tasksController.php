<?php
require_once "models/taskModel.php";
require_once "assets/php/funciones.php";


class TasksController
{
    private $model;

    public function __construct()
    {
        $this->model = new TaskModel();
    }

    public function crear(array $arrayTask): void
    {
        $error = false;
        $errores = [];

        //vaciamos los posibles errores
        $_SESSION["errores"] = [];
        $_SESSION["datos"] = [];

        // ERRORES DE TIPO

        //campos NO VACIOS
        $arrayNoNulos = ["name", "task_status"];
        $nulos = HayNulos($arrayNoNulos, $arrayTask);
        if (count($nulos) > 0) {
            $error = true;
            for ($i = 0; $i < count($nulos); $i++) {
                $errores[$nulos[$i]][] = "El campo {$nulos[$i]} es nulo";
            }
        }

        //CAMPOS UNICOS NINGUNO

        $id = null;
        if (!$error) $id = $this->model->insert($arrayTask);

          if ($id == null) {
            $_SESSION["errores"] = $errores;
            $_SESSION["datos"] = $arrayTask;
            header("location:index.php?accion=crear&tabla=task&error=true&project_id={$arrayTask["project_id"]}&client_id={$arrayTask["client_id"]}");
            exit();
        } else {
            unset($_SESSION["errores"]);
            unset($_SESSION["datos"]);
            
            header("location:index.php?accion=ver&tabla=project&id=" . $arrayTask["project_id"]);
            exit();
        }
    }
  
    public function buscar(string $campo = "id", string $metodo = "contiene", string $texto = "", bool  $comprobarSiEsBorrable = false): array
    {
        $tasks = $this->model->search($campo, $metodo, $texto);
    
        $tasksAlt=[];
        if ($comprobarSiEsBorrable) {
            foreach ($tasks as $task) {
                if($task->user_id==$_SESSION["usuario"]->id){
                    $task->esBorrable = $this->esBorrable($task);
                    $tasksAlt[]=$task;
                }
            }
        }

        return $tasksAlt;
    }

    public function listar(bool $comprobarSiEsBorrable=false, string $projectId)
    {
        $tasks= $this->model->readAll();
        $tasksAlt=[];
        if ($comprobarSiEsBorrable) {
            foreach ($tasks as $task) {
                if($task->project_id==$projectId){
                    $task->esBorrable = $this->esBorrable($task) && ($task->user_id==$_SESSION["usuario"]->id);
                    $tasksAlt[]=$task;
                }
            }
        }
        return $tasksAlt;
    }

    public function listarTodos(bool $comprobarSiEsBorrable=false)
    {
        $tasks= $this->model->readAll();
        $tasksAlt=[];
        if ($comprobarSiEsBorrable) {
            foreach ($tasks as $task) {
                if($task->user_id==$_SESSION["usuario"]->id){
                    $task->esBorrable = $this->esBorrable($task) && ($task->user_id==$_SESSION["usuario"]->id);
                    $tasksAlt[]=$task;
                }
            }
        }
        return $tasksAlt;
    }

    public function ver(int $id): ?stdClass
    {
        return $this->model->read($id);
    }

    public function borrar(int $id, $projectId): void
    {
        $taskBorrar = $this->ver($id);
        $borrado = $this->model->delete($id);
        //$redireccion = "location:index.php?accion=buscar&tabla=task&evento=borrar&id={$id}&name={$taskBorrar->name}";
        $redireccion = "location:index.php?accion=ver&tabla=project&id=".$projectId."&evento=borrar&task_id={$id}&name={$taskBorrar->name}";

        if ($borrado == false) $redireccion .=  "&error=true";
       // var_dump ($redireccion);
        header($redireccion);
        exit();
    }

    public function editar(string $id, array $arrayTask): void
    {
        $error = false;
        $errores = [];
        if (isset($_SESSION["errores"])) {
            unset($_SESSION["errores"]);
            unset($_SESSION["datos"]);
        }

        // ERRORES DE TIPO

        //campos NO VACIOS
        $arrayNoNulos = ["name", "task_status"];
        $nulos = HayNulos($arrayNoNulos, $arrayTask);
        if (count($nulos) > 0) {
            $error = true;
            for ($i = 0; $i < count($nulos); $i++) {
                $errores[$nulos[$i]][] = "El campo {$nulos[$i]} NO puede estar vacio ";
            }
        }
        
        //CAMPOS UNICOS NINGUNO
 
        //todo correcto
        $editado = false;
        if (!$error) $editado = $this->model->edit($id, $arrayTask);

        if ($editado == false) {
            $_SESSION["errores"] = $errores;
            $_SESSION["datos"] = $arrayTask;
            $redireccion = ("location:index.php?accion=editar&evento=modificar&tabla=task&error=true&id={$arrayTask["id"]}&project_id={$arrayTask["project_id"]}");
        } else {
            unset($_SESSION["errores"]);
            unset($_SESSION["datos"]);
            
            $redireccion = ("location:index.php?accion=ver&tabla=project&evento=modificar&id={$arrayTask["project_id"]}&task_id={$id}&name={$arrayTask["name"]}");
        }

        header($redireccion);
        exit ();
        //vuelvo a la pagina donde estaba
    }
    
      private function esBorrable(stdClass $task): bool
    {
        // $taskController = new ProjectsController();
        // $borrable = true;
        // // si ese usuario está en algún proyecto, No se puede borrar.
        // if (count($taskController->buscar("user_id", "igual", $task->id)) > 0)
        //     $borrable = false;
    
        // return $borrable;
        return true;
    }
    
    public function buscarPorUsuarioSesion(stdClass $usuario, string $campo = "id", string $metodo = "contiene", string $texto = "", bool  $comprobarSiEsBorrable = false): array
    {
        $tasks = $this->model->searchbyUser($usuario, $campo, $metodo, $texto);
    
        if ($comprobarSiEsBorrable) {
            foreach ($tasks as $task) {
                $task->esBorrable = $this->esBorrable($task);
            }
        }
        return $tasks;
    }
}
