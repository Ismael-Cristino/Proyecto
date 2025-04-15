<?php
require_once "models/clientModel.php";
require_once "assets/php/funciones.php";
require_once "controllers/projectsController.php";

class ClientsController { 
    private $model;

    public function __construct(){
        $this->model = new ClientModel();
    }

    public function crear (array $arrayClient):void {
        $error = false;
        $errores = [];
        //vaciamos los posibles errores
        $_SESSION["errores"] = [];
        $_SESSION["datos"] = [];
        
        // ERRORES DE TIPO
        if (!is_valid_idFiscal($arrayClient["idFiscal"])) {
            $error = true;
            $errores["idFiscal"][] = "El ID Fiscal es incorrecto";
        }

        if (!is_valid_email($arrayClient["contact_email"])) {
            $error = true;
            $errores["contact_email"][] = "El email tiene un formato incorrecto";
        }

        //campos NO VACIOS
        $arrayNoNulos = ["idFiscal", "contact_name", "contact_email"];
        $nulos = HayNulos($arrayNoNulos, $arrayClient);
        if (count($nulos) > 0) {
            $error = true;
            for ($i = 0; $i < count($nulos); $i++) {
                $errores[$nulos[$i]][] = "El campo {$nulos[$i]} es nulo";
            }
        }

        //CAMPOS UNICOS
        $arrayUnicos = ["idFiscal", "contact_email"];

        foreach ($arrayUnicos as $CampoUnico) {
            if ($this->model->exists($CampoUnico, $arrayClient[$CampoUnico])) {
                $errores[$CampoUnico][] = "El {$arrayClient[$CampoUnico]} de {$CampoUnico} ya existe";
                $error = true;
            }
        }
        $id = null;
        if (!$error) $id = $this->model->insert($arrayClient);

        if ($id == null) {
            $_SESSION["errores"] = $errores;
            $_SESSION["datos"] = $arrayClient;
            header("location:index.php?tabla=client&accion=crear&error=true&id={$id}");
            exit();
        } else {
            unset($_SESSION["errores"]);
            unset($_SESSION["datos"]);
            header("location:index.php?tabla=client&accion=ver&id=".$id);
            exit();
        }
    }

    public function ver(int $id): ?stdClass {
        return $this->model->read($id);
    }

    public function listar (bool  $comprobarSiEsBorrable = false){
        $clients = $this->model->readAll ();

        if ($comprobarSiEsBorrable) {
            foreach ($clients as $client) {
                $client->esBorrable = $this->esBorrable($client);
            }
        }
        return $clients;
    }

    public function borrar(int $id): void {
        $cliente=$this->ver($id);
        $borrado = $this->model->delete($id);
        $redireccion = "location:index.php?accion=listar&tabla=client&evento=borrar&id={$id}&idFiscal={$cliente->idFiscal}&nombre={$cliente->contact_name}";
        
        if ($borrado == false) $redireccion .= "&error=true";
        header($redireccion);
        exit();
    }

    public function editar (int $id, array $arrayClient):void {
        /*$cliente=$this->ver($id);
        $editadoCorrectamente=$this->model->edit ($id, $arrayClient, $cliente->idFiscal);
        //lo separo para que se lea mejor en el word
        $redireccion="location:index.php?tabla=client&accion=editar";
        $redireccion.="&evento=modificar&id={$id}&company_name={$cliente->company_name}&name={$cliente->contact_name}";
        $redireccion.=($editadoCorrectamente==false)?"&error=true":"";
        //vuelvo a la pagina donde estaba
        header ($redireccion);
        exit();*/
        $cliente=$this->ver($id);
        $error = false;
        $errores = [];
        if (isset($_SESSION["errores"])) {
            unset($_SESSION["errores"]);
            unset($_SESSION["datos"]);
        }

        // ERRORES DE TIPO
        if (!is_valid_idFiscal($arrayClient["idFiscal"])) {
            $error = true;
            $errores["idFiscal"][] = "El ID Fiscal es incorrecto";
        }

        if (!is_valid_email($arrayClient["contact_email"])) {
            $error = true;
            $errores["contact_email"][] = "El email tiene un formato incorrecto";
        }

        //campos NO VACIOS
        $arrayNoNulos = ["idFiscal", "contact_name", "contact_email"];
        $nulos = HayNulos($arrayNoNulos, $arrayClient);
        if (count($nulos) > 0) {
            $error = true;
            for ($i = 0; $i < count($nulos); $i++) {
                $errores[$nulos[$i]][] = "El campo {$nulos[$i]} es nulo";
            }
        }

        //CAMPOS UNICOS
        $arrayUnicos = [];
        if ($arrayClient["contact_email"] != $arrayClient["contact_emailOriginal"]) $arrayUnicos[] = "contact_email";
        if ($arrayClient["idFiscal"] != $arrayClient["idFiscalOriginal"]) $arrayUnicos[] = "idFiscal";

        foreach ($arrayUnicos as $CampoUnico) {
            if ($this->model->exists($CampoUnico, $arrayClient[$CampoUnico], $id)) {
                $errores[$CampoUnico][] = "El {$CampoUnico}  {$arrayClient[$CampoUnico]}  ya existe";
                $error = true;
            }
        }

        //todo correcto
        $editado = false;
        if (!$error) $editado = $this->model->edit($id, $arrayClient);

        if ($editado == false) {
            $_SESSION["errores"] = $errores;
            $_SESSION["datos"] = $arrayClient;
            //lo separo para que se lea mejor en el word
            $redireccion="location:index.php?tabla=client&accion=editar";
            $redireccion.="&evento=modificar&id={$id}&company_name={$cliente->company_name}&name={$cliente->contact_name}";
            $redireccion.="&error=true";
        } else {
            //vuelvo a limpiar por si acaso
            unset($_SESSION["errores"]);
            unset($_SESSION["datos"]);
            //este es el nuevo numpieza
            $id = $arrayClient["id"];
            $redireccion="location:index.php?tabla=client&accion=editar";
            $redireccion.="&evento=modificar&id={$id}&company_name={$cliente->company_name}&name={$cliente->contact_name}";
        }
        header($redireccion);
        exit();
        //vuelvo a la pagina donde estaba
    }

    public function buscar (string $cliente, string $campo, string $modo, bool  $comprobarSiEsBorrable = false):array {
        
        $clients = $this->model->search ($cliente, $campo, $modo);

        if ($comprobarSiEsBorrable) {
            foreach ($clients as $client) {
                $client->esBorrable = $this->esBorrable($client);
            }
        }
        return $clients;
    }

    private function esBorrable(stdClass $client): bool
    {
        $projectController = new ProjectsController();
        $borrable = true;
        // si ese usuario está en algún proyecto, No se puede borrar.
        if (count($projectController->buscar("client_id", "igual", $client->id)) > 0)
            $borrable = false;

        return $borrable;
    }
}