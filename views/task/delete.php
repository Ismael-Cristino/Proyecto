<?php
require_once "controllers/tasksController.php";
//pagina invisible
if (!isset ($_REQUEST["id"], $_REQUEST["project_id"])){
   header('location:index.php' );
   exit();
}
//recoger datos
$id=$_REQUEST["id"];
$project_id=$_REQUEST["project_id"];

$controlador= new TasksController();
$borrado=$controlador->borrar ($id, $project_id);