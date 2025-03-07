<?php 
session_start();
$id_u=$_SESSION['usuario']['idUsuario'];
include 'conexion.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $concepto = trim($_POST['concepto']);
    $fecha = date("Y-m-d");
    $fuente = trim($_POST['fuente']);
    $medio = trim($_POST['medio']);
    $valor = $_POST['valor'];
	$descripcion=trim($_POST['descripcion']);
	
	$c_concepto="SELECT idconcepto FROM concepto WHERE nombre='$concepto'";
	$r_concepto=mysqli_query($conn, $c_concepto);
	$id_c=mysqli_fetch_assoc($r_concepto)['idconcepto'];
	
    $insercion = "INSERT INTO `ingreso`(`idconcepto`, `idUsuario`, `fecha`, `valor`, `medio_de_pago`, `fuente_beneficiario`, `descripcion`) VALUES ('$id_c', '$id_u','$fecha','$valor','$medio','$fuente','$descripcion')";

    if (mysqli_query($conn, $insercion)) {
        echo "Ingreso registrado exitosamente";  
        echo "success";
    } else {
        echo "Error";
    }
} else {
    echo "Acceso no permitido";
}
?>