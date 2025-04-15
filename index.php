<?php
    ob_start();
    require_once ("router/router.php");

    require_once ("views/layout/head.php");
    $vista=router ();

    if (!file_exists($vista)) "Error, REVISA TUS RUTAS";
    else require_once ($vista);

    require_once ("views/layout/footer.php");
?>
<div class="container-fluid">
    <div class="row">
        <?php

        if (!file_exists($vista)) echo "Error, REVISA TUS RUTAS";
        else require_once($vista);

        ?>
    </div>
</div>
<?php
require_once("views/layout/footer.php");
?>