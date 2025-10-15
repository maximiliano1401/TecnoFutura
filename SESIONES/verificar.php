<?php
session_start();

if(isset($_SESSION['id'])){
    echo"Bienvenido " . $_SESSION['usuario'];
}else{
    header("Location: login.html");
    exit();
}
?>