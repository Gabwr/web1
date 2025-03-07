<?php
session_start();
include "conexion.php";
date_default_timezone_set('America/Guayaquil');//Zona horaria de ecuador
$usuario=$_SESSION['usuario']['idUsuario'];
$last_con=date("Y-m-d H:i:s");//Hora y fecha actuales
$ultimaCon="UPDATE usuario SET conexion='$last_con' where idUsuario='$usuario'";
mysqli_query($conn,$ultimaCon);
session_destroy();
header("Location: ../index.php");
exit();
?>