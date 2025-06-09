<?php
require_once "models/formularioModel.php";
require_once "assets/php/funciones.php";

class formularioController
{
    private $model;

    public function __construct()
    {
        $this->model = new FormularioModel();
    }

    public function solicitar(array $arrayDatos): void
    {

        $baseFolder = str_replace('/index.php', '', $_SERVER['PHP_SELF']);
        define('BASE_URL', $baseFolder . '/');

        $error = false;
        $errores = [];
        //vaciamos los posibles errores
        $_SESSION["errores"] = [];
        $_SESSION["datos"] = [];

        // ERRORES DE TIPO
        // Eliminar espacios y comprobar campos vacíos obligatorios
        $camposObligatorios = ['nombre', 'numero', 'email', 'fecha', 'servicio', 'direccionOri', 'direccionDes'];
        foreach ($camposObligatorios as $campo) {
            if (!isset($arrayDatos[$campo]) || trim($arrayDatos[$campo]) === '') {
                $errores[$campo][] = "El campo '$campo' es obligatorio.";
                $error = true;
            }
        }

        // Validar número de teléfono (ejemplo básico: 9 dígitos, empieza por 6, 7 o 9 en España)
        if (!preg_match('/^[679]\d{8}$/', $arrayDatos['numero'])) {
            $errores["numero"][] = "Número de teléfono no válido.";
            $error = true;
        }

        // Validar email
        if (!filter_var($arrayDatos['email'], FILTER_VALIDATE_EMAIL)) {
            $errores["email"][] = "Correo electrónico no válido.";
            $error = true;
        }

        // Validar fecha: debe ser futura y no domingo
        $fecha = DateTime::createFromFormat('Y-m-d', $arrayDatos['fecha']);
        $hoy = new DateTime('today');
        if (!$fecha || $fecha <= $hoy) {
            $errores["fecha"][] = "La fecha debe ser posterior a hoy.";
            $error = true;
        } elseif ((int)$fecha->format('w') === 0) {
            $errores["fecha"][] = "No se permiten reservas en domingo.";
            $error = true;
        }

        // Validar servicio
        $serviciosValidos = [
            'trasladoDom',
            'trasladoOfi',
            'retiro',
            'vaciado',
            'otros'
        ];
        if (!in_array($arrayDatos['servicio'], $serviciosValidos)) {
            $errores["servicio"][] = "Servicio seleccionado no válido.";
            $error = true;
        }

        //CAMPOS UNICOS

        $id = null;
        if (!$error) $id = $this->model->insert($arrayDatos);

        $origen = $arrayDatos['origen'] ?? 'inicio';

        if ($id == null) {
            $_SESSION["errores"] = $errores;
            $_SESSION["datos"] = $arrayDatos;
            header("tabla=$origen&accion=ir&error=true#inicio-3");
            exit();
        } else {
            unset($_SESSION["errores"]);
            unset($_SESSION["datos"]);
            header("tabla=$origen&accion=ir&enviado=true#inicio-3");
            exit();
        }
    }
}
