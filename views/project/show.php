<?php
require_once "controllers/projectsController.php";
require_once "controllers/tasksController.php";
if (!isset($_REQUEST['id'])) {
    header("location:index.php");
    exit();
    // si no ponemos exit despues de header redirecciona al finalizar la pagina 
    // ejecutando el código que viene a continuación, aunque no llegues a verlo
    // No poner exit puede provocar acciones no esperadas dificiles de depurar
}

$id = $_REQUEST['id'];
$controlador = new ProjectsController();
$controladorTarea = new TasksController();
$project = $controlador->ver($id);
$tasks = $controladorTarea->listar(true, $id);
$client_id = $project->client_id;
$clase = "alert alert-success";
$visibilidad = "hidden";
$mostrarDatos = false;

if (isset($_REQUEST["evento"])) {
    $mostrarDatos = true;
    if ($_REQUEST["evento"]=="borrar"){
            $visibilidad = "visibility";
            $mostrarDatos = true;
            $clase = "alert alert-success";
            //Mejorar y poner el nombre/usuario
            $mensaje = "La tarea con id {$_REQUEST['task_id']} - y nombre  {$_REQUEST['name']} Borrado correctamente";
            if (isset($_REQUEST["error"])) {
                $clase = "alert alert-danger ";
                $mensaje = "ERROR!!! No se ha podido borrar el proyecto {$$_REQUEST['task_id']} -  {$_REQUEST['name']}";
            }
    }
    if ($_REQUEST["evento"]=="modificar"){
        $visibilidad = "visibility";
        $mostrarDatos = true;
        $clase = "alert alert-success";
        //Mejorar y poner el nombre/usuario
        $mensaje = "La tarea con id {$_REQUEST['task_id']} - y nombre  {$_REQUEST['name']} se ha editado correctamente";
        if (isset($_REQUEST["error"])) {
            $clase = "alert alert-danger ";
            $mensaje = "ERROR!!! No se ha podido editar el proyecto {$$_REQUEST['task_id']} -  {$_REQUEST['name']}";
        }
}
}

?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3">Ver Proyecto</h1> <?= ($project->user_id == $_SESSION["usuario"]->id) ? "<a class='btn btn-success' href='index.php?tabla=project&accion=editar&id={$id}'><i class='fas fa-pencil-alt'></i> Editar Proyecto</a>" : ""; ?>
    </div>
    <div id="contenido">
        <h5 class="card-title">ID: <?= $project->id ?> NOMBRE: <?= $project->name ?> </h5>
        <p>
            <b>Descripción:</b> <?= $project->description ?> <br>
            <b>Fecha Límite:</b> <?= date('d-m-Y', strtotime($project->deadline)) ?><br>
            <b>Estado:</b><?= $project->status ?><br>
            <b>Respnsable Proyecto:</b><?= " {$project->usuario_user} - {$project->name_user}" ?><br>
            <b>Cliente:</b><?= "{$project->idFiscal_client} - {$project->company_name_client} <b>Persona Contacto:</b>{$project->contact_name_client}"  ?><br>
        </p>
        <?= ($project->user_id == $_SESSION["usuario"]->id) ? "<a class='btn btn-primary' href='index.php?tabla=task&accion=crear&project_id={$project->id}&client_id={$client_id}'><i class='fas fa-solid fa-plus'></i> Añadir Tarea</a>"  : ""; ?>
        <p></p>
        <div class="<?= $clase ?>" <?= $visibilidad ?> role="alert"> <?= $mensaje ?>
        </div>
        <?php
            if (count($tasks) <= 0) :
                echo "No hay Tareas a Mostrar";
            else : ?>
        <table class="table table-light table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre de la tarea</th>
                    <th>Descripción</th>
                    <th>Fecha límite</th>
                    <th>Estado</th>
                    <th>Responsable</th>
                    <th>Borrar</th>
                    <th>Editar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                /*<tr>
                    <td>Tarea 1</td>
                    <td> Descripcion Tarea 1 </td>
                    <td> Boton Borrar</td>
                    <td> Boton Modificar</td>
                </tr>
                <tr>
                    <td>Tarea 2</td>
                    <td> Descripcion Tarea 1 </td>
                    <td> Boton Borrar</td>
                    <td> Boton Modificar</td>
                </tr>*/
                    foreach ($tasks as $key => $task) {
                        if ($project->user_id != $_SESSION["usuario"]->id) {
                            $disable = "disabled";
                            $rutaBorrar = "#";
                            $rutaEditar = "#";
                        }else{
                            $disable = "";
                            $rutaBorrar = "index.php?tabla=task&accion=borrar&id=$task->id&project_id=$task->project_id";
                            $rutaEditar = "index.php?tabla=task&accion=editar&id=$task->id&project_id=$task->project_id";
                        }
                        
                        echo "<tr><td>".$task->id."</td>";
                        echo "<td>".$task->name."</td>";
                        echo "<td>".$task->description."</td>";
                        echo "<td>".$task->deadline."</td>";
                        echo "<td>".$task->task_status."</td>";
                        echo "<td>".$task->user_id. " - " .$task->usuario_user." - ".$task->name_user."</td>";
                        
                        echo "<td><a class='btn btn-danger $disable' href='$rutaBorrar'><i class='fa fa-trash'></i> Borrar</a></td>";
                        echo "<td><a class='btn btn-success $disable' href='$rutaEditar'><i class='fas fa-pencil-alt'></i>Editar</a></td></tr>";
                    }
                ?>
            <tbody>
        </table>
        <?php
            endif;
            ?>
        </P>
    </div>
    <div>
        <center><a href="index.php?accion=buscar&tabla=project&evento=todos" class="btn btn-info" name="Todos" role="button">Volver</a></center>
    </div>