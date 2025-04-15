<?php
require_once "controllers/tasksController.php";

$mensaje = "";
$clase = "alert alert-success";
$visibilidad = "hidden";
$mostrarDatos = false;
$controlador = new TasksController();
$campo = "tasks.name";
$metodo = "contiene";
$texto = "";

if (isset($_REQUEST["evento"])) {
    $mostrarDatos = true;
    switch ($_REQUEST["evento"]) {
        case "todos":
            $tasks = $controlador->listarTodos(comprobarSiEsBorrable: true);
            $mostrarDatos = true;
        break;
            //Modificamos el filtrar    
        case "filtrar":
            $campo = ($_REQUEST["campo"]) ?? "tasks.name";
            $metodo = ($_REQUEST["metodoBusqueda"]) ?? "contiene";
            $texto = ($_REQUEST["busqueda"]) ?? "";
            //es borrable Parametro con nombre
            if (!isset ($_REQUEST["misTareas"]))$tasks= $controlador->buscar($campo, $metodo, $texto, comprobarSiEsBorrable: true); 
            else $tasks= $controlador->buscarPorUsuarioSesion($_SESSION["usuario"],$campo, $metodo, $texto, comprobarSiEsBorrable: true); //solo añadimos esto
            break;
        case "borrar":
            $visibilidad = "visibility";
            $mostrarDatos = true;
            $clase = "alert alert-success";
            //Mejorar y poner el nombre/usuario
            $mensaje = "El proyecto o {$_REQUEST['id']} -  {$_REQUEST['name']} Borrado correctamente";
            if (isset($_REQUEST["error"])) {
                $clase = "alert alert-danger ";
                $mensaje = "ERROR!!! No se ha podido borrar la tarea {$_REQUEST['id']} -  {$_REQUEST['name']}";
            }
            $tasks = $controlador->listarTodos(comprobarSiEsBorrable: true);
            break;
    }
}
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3">Buscar Tarea</h1>
    </div>
    <div id="contenido">
        <div class="<?= $clase ?>" <?= $visibilidad ?> role="alert"> <?= $mensaje ?>
        </div>
        <div>
            <form action="index.php?accion=buscar&tabla=task&evento=filtrar" method="POST">
                <div class="form-group">
                    <select class="form-select" name="campo" id="campo">
                        <option value="id" <?= $campo == "id" ? "selected" : "" ?>>ID</option>
                        <option value="tasks.name" <?= $campo == "tasks.name" ? "selected" : "" ?>>Nombre Tarea</option>
                        <option value="description" <?= $campo == "description" ? "selected" : "" ?>>Descripcion </option>
                        <option value="user_id" <?= $campo == "user_id" ? "selected" : "" ?>>Id de Usuario</option>
                        <option value="users.name" <?= $campo == "users.name" ? "selected" : "" ?>>Nombre de Usuario</option>
                        <option value="users.usuario" <?= $campo == "users.usuario" ? "selected" : "" ?>>Nick de Usuario</option>
                        <option value="project_id" <?= $campo == "project_id" ? "selected" : "" ?>>Id del proyecto</option>
                        <option value="clients.contact_name" <?= $campo == "clients.contact_name" ? "selected" : "" ?>>Nombre Contacto Cliente</option>
                        <option value="clients.idFiscal" <?= $campo == "clients.idFiscal" ? "selected" : "" ?>> Id Fiscal de Cliente de Usuario </option>
                        <option value="clients.company_name" <?= $campo == "clients.company_name" ? "selected" : "" ?>>Nombre Empresa Cliente </option>
                    </select>
                    <select class="form-select" name="metodoBusqueda" id="metodoBusqueda">
                        <option value="empieza" <?= $metodo == "empieza" ? "selected" : "" ?>>Empieza Por</option>
                        <option value="acaba" <?= $metodo == "acaba" ? "selected" : "" ?>>Acaba En </option>
                        <option value="contiene" <?= $metodo == "contiene" ? "selected" : "" ?>>Contiene </option>
                        <option value="igual" <?= $metodo == "igual" ? "selected" : "" ?>>Es Igual A</option>

                    </select>
                    <input type="text"  class="form-control" id="busqueda" name="busqueda" value="<?= $texto ?>" placeholder="texto a Buscar">
                    <input class="form-check-input" type="checkbox" value="checked" name="misTareas" id="misTareas" <?= $_REQUEST["misTareas"]??"" ?> >
                    <label class="form-check-label" for="misTareas">
                        Mis Proyectos 
                    </label>
                <DIV>
                <button type="submit" class="btn btn-success" name="Filtrar">Buscar</button>
                <a href="index.php?accion=buscar&tabla=task&evento=todos" class="btn btn-info" name="Todos" role="button">Ver todos</a>
            </form>

        </div>
        <?php
        if ($mostrarDatos) {
            if (count($tasks) <= 0) :
                echo "No hay Datos a Mostrar";
            else :
        ?>
                <table class="table table-light table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col">Fecha Finalización</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Modificar Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tasks as $task) :
                            $id = $task->id;
                        ?>
                            <tr>
                                <th scope="row"><?= $task->id ?></th>
                                <td><?= $task->name ?></td>
                                <td><?= $task->description ?></td>
                                <td><?= date('d-m-Y', strtotime($task->deadline)) ?></td>
                                <td><?= $task->task_status ?></td>
                                <td><?= "{$task->user_id} - {$task->usuario_user} {$task->name_user} " ?></td>
                                <?php if(is_null($task->client_id)) :
                                    echo "<td>No hay cliente</td>";
                                    else :
                                    ?>
                                <td><?= "{$task->client_id} - {$task->contact_name_client} {$task->company_name_client} " ?></td>
                                <?php
                                    endif;
                                ?>
                                <td><a class="btn btn-warning" href="index.php?tabla=task&accion=editStatus&id=<?=$task->id?>&project_id=<?=$task->project_id?>"><i class="fas fa-eye"></i> Modificar Estado </a></td>
                            </tr>
                        <?php
                        endforeach;

                        ?>
                    </tbody>
                </table>
        <?php
            endif;
        }
        ?>
    </div>
</main>