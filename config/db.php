<?php
class db
{
  const HOST = "localhost";
  const DBNAME = "proyecto";
  const USER = "ismael";
  const PASSWORD = "sA2DL7CQ"; // Evidentemente adapta los valores

  static public function conexion()
  {
    $conexion = null;
    try {
      $opciones =  array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
      $conexion = new PDO('mysql:host=localhost;  dbname=' .self::DBNAME,self::USER,self::PASSWORD, $opciones);
    } catch (Exception $e) {
       echo "Ocurrió algo con la base de datos: " . $e->getMessage();
      }
     return $conexion; //Es un objeto de conexion PDO
    }
}