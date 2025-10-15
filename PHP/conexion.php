<?php

$host = "localhost";
$dbname = "u373598520_tecnofutura";
$usuario = "root";
$contrasena = "123456";

$conexion = mysqli_connect($host, $usuario, $contrasena, $dbname);

if(!$conexion){
    die("Error al realizar la conexion ". mysqli_connect_error());
}
// NO cerrar la etiqueta PHP para evitar espacios en blanco que corrompan JSON/headers
