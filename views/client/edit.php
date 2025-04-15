<?php
require_once "controllers/clientsController.php";
//recoger datos
if (!isset($_REQUEST["id"])) {
    header('location:index.php?tabla=clients&accion=listar');
    unset($_SESSION["datos"]);
    unset($_SESSION["errores"]);
    exit();
}
$id = $_REQUEST["id"];
$controlador = new ClientsController();
$client = $controlador->ver($id);

$visibilidad = "hidden";
$mensaje = "";
$clase = "alert alert-success";
$mostrarForm = true;
if ($client == null) {
    $visibilidad = "visible";
    $mensaje = "El cliente con id: {$id} no existe. Por favor vuelva a la pagina anterior";
    $clase = "alert alert-danger";
    $mostrarForm = false;
}
else if (isset($_REQUEST["evento"]) && $_REQUEST["evento"] == "modificar") {
    $visibilidad = "visible";
    $mensaje = "Cliente {$_REQUEST['name']}, con id {$id} y nombre de la compañia {$_REQUEST['company_name']} Modificado con éxito";
    if (isset($_REQUEST["error"])) {
        $mensaje = "No se ha podido modificar el id {$id}";
        $clase = "alert alert-danger";
    }
}
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3">Editar Cliente con Id: <?= $id ?></h1>
    </div>
    <div id="contenido">
        <div id="msg" name="msg" class="<?= $clase ?>" <?= $visibilidad ?> > <?= $mensaje ?> </div>
        <?php
        if ($mostrarForm) {
		$errores=$_SESSION["errores"]??[];
        ?>
            <form action="index.php?tabla=client&accion=guardar&evento=modificar" method="POST">
                <input type="hidden" id="id" name="id" value="<?= $client->id ?>">
                <input type="hidden" id="idFiscal" name="idFiscal" value="<?= $client->idFiscal ?>">
                <div class="form-group">
                    <label for="contact_name">Nombre </label>
                    <input type="text" required class="form-control" id="contact_name" name="contact_name" aria-describedby="contact_name" placeholder="Introduce tu nuevo Nombre" value="<?= $client->contact_name ?>">
                    <small id="contact_name" class="form-text text-muted">Compartir tu Nombre lo hace menos seguro.</small>
                    <?= isset($errores["contact_name"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "contact_name") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="contact_email">Email</label>
                    <input type="text" required class="form-control" id="contact_email" name="contact_email" value="<?= $client->contact_email ?>">
                    <?= isset($errores["contact_email"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "contact_email") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="contact_phone_number">Numero de contacto</label>
                    <input type="text" class="form-control" id="contact_phone_number" name="contact_phone_number" value="<?= $client->contact_phone_number?>">
                    <?= isset($errores["contact_phone_number"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "contact_phone_number") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="company_name">Nombre de la compañia </label>
                    <input type="text" class="form-control" id="company_name" name="company_name" value="<?= $client->company_name ?>">
                    <?= isset($errores["company_name"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "company_name") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="company_address">Direccion de la compañia </label>
                    <input type="text" class="form-control" id="company_address" name="company_address" value="<?= $client->company_address ?>">
                    <?= isset($errores["company_address"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "company_address") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="company_phone_number">Telefono de la compañia </label>
                    <input type="text" class="form-control" id="company_phone_number" name="company_phone_number" value="<?= $client->company_phone_number ?>">
                    <?= isset($errores["company_phone_number"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "company_phone_number") . '</div>' : ""; ?>
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
                <a class="btn btn-danger" href="index.php?tabla=client&accion=listar">Cancelar</a>
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