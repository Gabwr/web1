<?php
session_start();
$id_u=$_SESSION['usuario']['idUsuario'];
date_default_timezone_set('America/Guayaquil');//Zona horaria de ecuador
require '../server/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && isset($_POST["estado"])) {
    $idGasto = intval($_POST["id"]);
    $nuevoEstado = $_POST["estado"];
	$cambio = $nuevoEstado == "Inactivo" ? 'Anulación' : 'Reactivación';

    $query = "UPDATE gasto SET estado = ? WHERE idGasto = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $nuevoEstado, $idGasto);

    if ($stmt->execute()) {
		//Registro en auditoría
		$mensaje=$cambio." del gasto N° ".$idGasto;
		$fecha_hora=date("Y-m-d H:i:s");
		$r_auditoria="INSERT INTO `auditoria`(`idUsuario`, `detalle`, `fecha_hora`) VALUES ('$id_u','$mensaje','$fecha_hora')";
		mysqli_query($conn,$r_auditoria);
		//Mensaje de confirmacion
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
    $conn->close();
}
?>