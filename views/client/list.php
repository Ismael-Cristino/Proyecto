<?php
require_once "controllers/clientsController.php";

$controlador = new ClientsController();
$clients = $controlador->listar($comprobarSiEsBorrable = true);
$visibilidad = "hidden";
if (isset($_REQUEST["evento"]) && $_REQUEST["evento"] == "borrar") {
    $visibilidad = "visibility";
    $clase = "alert alert-success";
    //Mejorar y poner el nombre/usuario
    $mensaje = "El Cliente con id: {$_REQUEST['id']}, IdFiscal: {$_REQUEST['idFiscal']} y nombre: {$_REQUEST['nombre']}. Borrado correctamente";
    if (isset($_REQUEST["error"])) {
        $clase = "alert alert-danger ";
        $mensaje = "ERROR!!! No se ha podido borrar el usuario con id: {$_REQUEST['id']}";
    }
}
?>
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3">Listar clientes</h1>
    </div>
    <div id="contenido">
        <div class="<?= $clase ?>" <?= $visibilidad ?> role="alert">
            <?= $mensaje ?>
        </div>
        <?php
        if (count($clients) <= 0) :
            echo "No hay Datos a Mostrar";
        else : ?>
            <table class="table table-light table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">ID Fiscal</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Email</th>
                        <th scope="col">Telefono</th>
                        <th scope="col">Compañia</th>
                        <th scope="col">Direccion</th>
                        <th scope="col">T. Compañia</th>
                        <th scope="col">Eliminar</th>
                        <th scope="col">Editar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clients as $client) :
                        $id = $client->id;
                        $nombre = $client->contact_name;
                    ?>
                        <tr>
                            <th scope="row"><?= $client->id ?></th>
                            <td><?= $client->idFiscal ?></td>
                            <td><?= $client->contact_name ?></td>
                            <td><?= $client->contact_email ?></td>
                            <td><?= $client->contact_phone_number ?></td>
                            <td><?= $client->company_name ?></td>
                            <td><?= $client->company_address ?></td>
                            <td><?= $client->company_phone_number ?></td>
                            <td>
                                <?php
                                $disable = "";
                                $ruta = "index.php?tabla=client&accion=borrar&id={$id}";
                                if (isset($client->esBorrable) && $client->esBorrable == false) {
                                    $disable = "disabled";
                                    $ruta = "#";
                                }
                                ?>
                                <a class="btn btn-danger <?= $disable ?>" href="<?= $ruta ?>"><i class="fa fa-trash"></i> Borrar</a>
                            </td>
                            <td><a class="btn btn-success" href="index.php?tabla=client&accion=editar&id=<?= $id ?>"><i class="fas fa-pencil-alt"></i> Editar</a></td>
                        </tr>
                    <?php
                    endforeach;
                    ?>
                </tbody>
            </table>
        <?php
        endif;
        ?>
    </div>
</main>