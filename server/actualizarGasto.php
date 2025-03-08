<?php 
session_start();
$id_u=$_SESSION['usuario']['idUsuario'];
date_default_timezone_set('America/Guayaquil');//Zona horaria de ecuador
include 'conexion.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$id=$_POST['id'];
    $concepto = trim($_POST['concepto']);
    $destinatario = trim($_POST['destinatario']);
    $medio = trim($_POST['medio']);
    $valor = $_POST['valor'];
	$descripcion=trim($_POST['descripcion']);
	
	$c_concepto="SELECT idconcepto FROM concepto WHERE nombre='$concepto'";
	$r_concepto=mysqli_query($conn, $c_concepto);
	$id_c=mysqli_fetch_assoc($r_concepto)['idconcepto'];
	
    $actualizacion = "UPDATE `gasto` SET `idconcepto`='$id_c',`valor`='$valor',`medio_de_pago`='$medio',`acreedor_cobrador`='$destinatario',`descripcion`='$descripcion' WHERE idGasto='$id'";

    if (mysqli_query($conn, $actualizacion)) {
		//Registro en auditoría
		$mensaje="Modificación del gasto N° ".$id;
		$fecha_hora=date("Y-m-d H:i:s");
		$r_auditoria="INSERT INTO `auditoria`(`idUsuario`, `detalle`, `fecha_hora`) VALUES ('$id_u','$mensaje','$fecha_hora')";
		mysqli_query($conn,$r_auditoria);
		//Mensaje de confirmacion
        echo "Gasto actualizado exitosamente";  
        echo "success";
    } else {
        echo "Error";
    }
} else {
    echo "Acceso no permitido";
}
?>