<?php 
session_start();
$id_u=$_SESSION['usuario']['idUsuario'];
date_default_timezone_set('America/Guayaquil');//Zona horaria de ecuador
include 'conexion.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $concepto = trim($_POST['concepto']);
    $fecha = date("Y-m-d");
    $destinatario = trim($_POST['destinatario']);
    $medio = trim($_POST['medio']);
    $valor = $_POST['valor'];
	$descripcion=trim($_POST['descripcion']);
	
	$c_concepto="SELECT idconcepto FROM concepto WHERE nombre='$concepto'";
	$r_concepto=mysqli_query($conn, $c_concepto);
	$id_c=mysqli_fetch_assoc($r_concepto)['idconcepto'];
	
    $insercion = "INSERT INTO `gasto`(`idconcepto`, `idUsuario`, `fecha`, `valor`, `medio_de_pago`, `acreedor_cobrador`, `descripcion`,`estado`) VALUES ('$id_c', '$id_u','$fecha','$valor','$medio','$destinatario','$descripcion','Activo')";

    if (mysqli_query($conn, $insercion)) {
		//Registro en auditoría
		$mensaje='Registro del gasto #'.intval(mysqli_insert_id($conn));
		$fecha_hora=date("Y-m-d H:i:s");
		$r_auditoria="INSERT INTO `auditoria`(`idUsuario`, `detalle`, `fecha_hora`) VALUES ('$id_u','$mensaje','$fecha_hora')";
		mysqli_query($conn,$r_auditoria);
		echo "Gasto registrado exitosamente";  
        echo "success";
    } else {
        echo "Error";
    }
} else {
    echo "Acceso no permitido";
}
?>