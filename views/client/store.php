<?php
require_once "controllers/clientsController.php";
//recoger datos
if (!isset ($_REQUEST["idFiscal"])){
   header('Location:index.php?tabla=client&accion=crear' );
   exit();
}

$id= ($_REQUEST["id"])??"";//el id me servirá en editar

$arrayClient=[    
            "id"=>$id,
            "idFiscal"=>$_REQUEST["idFiscal"],
            "idFiscalOriginal"=>($_REQUEST["idFiscalOriginal"])??"",
            "contact_name"=>$_REQUEST["contact_name"],
            "contact_email"=>$_REQUEST["contact_email"],
            "contact_emailOriginal"=>($_REQUEST["contact_emailOriginal"])??"",
            "contact_phone_number"=>$_REQUEST["contact_phone_number"],
            "company_name"=>$_REQUEST["company_name"],
            "company_address"=>$_REQUEST["company_address"],
            "company_phone_number"=>$_REQUEST["company_phone_number"],
        ];

//pagina invisible
$controlador= new ClientsController();

if ($_REQUEST["evento"]=="crear"){
    $controlador->crear ($arrayClient);
}

if ($_REQUEST["evento"]=="modificar"){
    $controlador->editar ($id, $arrayClient);
}