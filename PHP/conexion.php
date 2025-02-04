<?php

$host = "localhost";
$dbname = "tecnofutura";
$usuario = "root";
$contrasena = "";

$conexion = mysqli_connect($host, $usuario, $contrasena, $dbname);

if(!$conexion){
    die("Error al realizar la conexion ". mysqli_connect_error());
}
?>