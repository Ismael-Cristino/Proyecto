<?php
require_once "assets/php/funciones.php";
$cadenaErrores = "";
$cadena = "";
$errores = [];
$datos = [];
$visibilidad = "invisible";
if (isset($_REQUEST["error"])) {
  $errores = ($_SESSION["errores"]) ?? [];
  $datos = ($_SESSION["datos"]) ?? [];
  $cadena = "Atención Se han producido Errores";
  $visibilidad = "visible";
}
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h3">Añadir cliente</h1>
  </div>
  <div id="contenido">
  <?php
    $cadena=(isset($_REQUEST["error"]))?"Error, ha fallado la inserción":"";
    $visibilidad=(isset($_REQUEST["error"]))?"visible":"invisible";
  ?>
<div class="alert alert-danger <?=$visibilidad?>" ><?=$cadena?></div>
    <form action="index.php?tabla=client&accion=guardar&evento=crear" method="POST">
      <div class="form-group">
        <label for="idFiscal">Id Fiscal </label>
        <input type="text" required class="form-control" id="idFiscal" name="idFiscal" aria-describedby="idFiscal" placeholder="Introduce tu Id Fiscal">
        <small id="idFiscal" class="form-text text-muted">Compartir tu idFiscal lo hace menos seguro.</small>
        <?= isset($errores["idFiscal"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "idFiscal") . '</div>' : ""; ?>
      </div>
      <div class="form-group">
        <label for="contact_name">Nombre del Cliente</label>
        <input type="text" required class="form-control" id="contact_name" name="contact_name" placeholder="introduce tu Nombre">
        <?= isset($errores["contact_name"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "contact_name") . '</div>' : ""; ?>
      </div>
      <div class="form-group">
        <label for="contact_email">Email</label>
        <input type="text" required class="form-control" id="contact_email" name="contact_email" placeholder="Introduce tu Email">
        <?= isset($errores["contact_email"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "contact_email") . '</div>' : ""; ?>
      </div>
      <div class="form-group">
        <label for="contact_phone_number">Numero de contacto</label>
        <input type="text" required class="form-control" id="contact_phone_number" name="contact_phone_number" placeholder="Introduce tu numero de contacto">
        <?= isset($errores["contact_phone_number"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "contact_phone_number") . '</div>' : ""; ?>
      </div>
      <div class="form-group">
        <label for="company_name">Nombre de la compañia</label>
        <input type="text" required class="form-control" id="company_name" name="company_name" placeholder="Introduce el nombre de tu compañia">
        <?= isset($errores["company_name"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "company_name") . '</div>' : ""; ?>
      </div>
      <div class="form-group">
        <label for="company_address">Direccion de la compañia</label>
        <input type="text" class="form-control" id="company_address" name="company_address" placeholder="Introduce la direccion de la compañia">
        <?= isset($errores["company_address"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "company_address") . '</div>' : ""; ?>
      </div>
      <div class="form-group">
        <label for="company_phone_number">Telefono de la compañia </label>
        <input type="text" class="form-control" id="company_phone_number" name="company_phone_number" placeholder="Introduce el numero de la compañia">
        <?= isset($errores["company_phone_number"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "company_phone_number") . '</div>' : ""; ?>
      </div>
      <button type="submit" class="btn btn-primary">Guardar</button>
      <a class="btn btn-danger" href="index.php">Cancelar</a>
    </form>
  </div>
  <?php
    //Una vez mostrados los errores, los eliminamos
    unset($_SESSION["datos"]);
    unset($_SESSION["errores"]);
    ?>
</main>