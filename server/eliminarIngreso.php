<?php
session_start();
$id_u=$_SESSION['usuario']['idUsuario'];
date_default_timezone_set('America/Guayaquil');//Zona horaria de ecuador
require '../server/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && isset($_POST["estado"])) {
    $idIngreso = intval($_POST["id"]);
    $nuevoEstado = $_POST["estado"];
	$cambio = $nuevoEstado == "Inactivo" ? 'Anulación' : 'Reactivación';

    $query = "UPDATE ingreso SET estado = ? WHERE idIngreso = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $nuevoEstado, $idIngreso);

    if ($stmt->execute()) {
		//Registro en auditoría
		$mensaje=$cambio." del ingreso N° ".$idIngreso;
		$fecha_hora=date("Y-m-d H:i:s");
		$r_auditoria="INSERT INTO `auditoria`(`idUsuario`, `detalle`, `fecha_hora`) VALUES ('$id_u','$mensaje','$fecha_hora')";
		mysqli_query($conn,$r_auditoria);
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
    $conn->close();
}
?>