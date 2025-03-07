<?php 
session_start();
include 'conexion.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$id=$_POST['id'];
    $concepto = trim($_POST['concepto']);
    $fuente = trim($_POST['fuente']);
    $medio = trim($_POST['medio']);
    $valor = $_POST['valor'];
	$descripcion=trim($_POST['descripcion']);
	
	$c_concepto="SELECT idconcepto FROM concepto WHERE nombre='$concepto'";
	$r_concepto=mysqli_query($conn, $c_concepto);
	$id_c=mysqli_fetch_assoc($r_concepto)['idconcepto'];
	
    $actualizacion = "UPDATE `ingreso` SET `idconcepto`='$id_c',`valor`='$valor',`medio_de_pago`='$medio',`fuente_beneficiario`='$fuente',`descripcion`='$descripcion' WHERE idIngreso='$id'";

    if (mysqli_query($conn, $actualizacion)) {
        echo "Ingreso actualizado exitosamente";  
        echo "success";
    } else {
        echo "Error";
    }
} else {
    echo "Acceso no permitido";
}
?>