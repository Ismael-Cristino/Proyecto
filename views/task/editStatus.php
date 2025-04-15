<?php
require_once "controllers/tasksController.php";
require_once "assets/php/funciones.php";
require_once "controllers/usersController.php";

if (isset($_REQUEST["error"])) {
    $errores = ($_SESSION["errores"]) ?? [];
    $datos = ($_SESSION["datos"]) ?? [];
    $cadena = "Atención Se han producido Errores";
    $visibilidad = "visible";
}
//recoger datos
if (!isset($_REQUEST["id"])) {
    header('location:index.php?accion=ver&tabla=project&id=".$projectId."&task_id={$id}&name={$taskBorrar->name}');
    unset($_SESSION["datos"]);
    unset($_SESSION["errores"]);
    exit();
}

if (!isset($_REQUEST["project_id"])) {
    header('location:index.php?accion=buscar&tabla=project&evento=todos');
    unset($_SESSION["datos"]);
    unset($_SESSION["errores"]);
    exit();
}
$project_id = $_REQUEST["project_id"];

$cadenaErrores = "";
$cadena = "";
$errores = [];
$datos = [];
const STATUS = ['Abierta', 'Cerrada', 'En progreso', 'Cancelada'];
$visibilidad = "invisible";

$contlUsers = new UsersController();
$users = $contlUsers->listar();

$id = $_REQUEST["id"];
$controlador = new TasksController();
$task = $controlador->ver($id);

$visibilidad = "hidden";
$mensaje = "";
$clase = "alert alert-success";
$mostrarForm = true;
if ($task == null) {
    $visibilidad = "visibility";
    $mensaje = "La tarea con id: {$id} no existe. Por favor vuelva a la pagina anterior";
    $clase = "alert alert-danger";
    $mostrarForm = false;
} else if (isset($_REQUEST["evento"]) && $_REQUEST["evento"] == "modificar") {
    $visibilidad = "visibility";
    $mensaje = "Tarea {$task->name} con id {$id} Modificado con éxito";
    if (isset($_REQUEST["error"])) {
        $mensaje = "No se ha podido modificar la tarea {$task->name} con id {$id}";
        $clase = "alert alert-danger";
    }
}
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3">Editar Estado de la Tarea <?= $task->name ?> con Id: <?= $id ?> </h1>
    </div>
    <div id="contenido">
        <div id="msg" name="msg" class="<?= $clase ?>" <?= $visibilidad ?>> <?= $mensaje ?> </div>
        <?php
        if ($mostrarForm) {
            $errores = $_SESSION["errores"] ?? [];
        ?>
            <form action="index.php?accion=guardar&tabla=task&evento=modificar" method="POST">
                <input type="hidden" id="client_id" name="client_id" value="<?= $task->client_id ?>">
                <input type="hidden" id="name" name="name" value="<?= $task->name ?>">
                <input type="hidden" id="description" name="description" value="<?= $task->description ?>">
                <input type="hidden" id="deadline" name="deadline" value="<?= $task->deadline ?>">
                <input type="hidden" id="user_id" name="user_id" value="<?= $task->user_id ?>">
                <input type="hidden" id="project_id" name="project_id" value="<?= $project_id ?>"> 
                <input type="hidden" id="id" name="id" value="<?= $id ?>">
                <div class="form-group">
                    <label for="task_status">Estado </label>
                    <select id="task_status" name="task_status" class="form-select" aria-label="Default select example">
                        <?php
                        foreach (STATUS as $estado) :
                            $selected="";
                            if($task->task_status == $estado){
                                $selected =  "selected";
                            }
                            echo "<option {$selected}>{$estado}</option>";
                        endforeach;
                        ?>
                    </select>
                    <?= isset($errores["task_status"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "task_status") . '</div>' : ""; ?>
                </div>
                <p></p>
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a class="btn btn-danger" href="index.php">Cancelar</a>
            </form>
        <?php
        } else {
        ?>
            <a href="index.php" class="btn btn-primary">Volver a Inicio</a>
        <?php
        }
        //Una vez mostrados los errores, los eliminamos
        unset($_SESSION["datos"]);
        unset($_SESSION["errores"]);
        ?>
    </div>
</main>