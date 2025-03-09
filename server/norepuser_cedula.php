<?php
include("conexion.php");

if(isset($_POST['user']) && isset($_POST['cedula']) && isset($_POST['es'])){
    $resfinal="No hay repeticion";
$usuario = mysqli_real_escape_string($conn, $_POST['user']); 
$cedula = mysqli_real_escape_string($conn, $_POST['cedula']); 
$tipo = ($_POST['es'] === "edit");
if($tipo){    
    $id = $_POST['id'];
    $sqlu = "SELECT * FROM usuario WHERE usuario = '$usuario' AND idUsuario != '$id'";
    $sqlc = "SELECT * FROM usuario WHERE cedula = '$cedula'AND idUsuario != '$id'";
    $resultadoued = mysqli_query($conn, $sqlu);
    $resultadoced = mysqli_query($conn, $sqlc);

    if ($resultadoued && mysqli_num_rows($resultadoued) > 0) {
        $resfinal ="Usuario repetido";
    }
    
    if ($resultadoced && mysqli_num_rows($resultadoced) > 0) {
        $resfinal = "Cedula repetida";
    }

}else{
    $sqlu = "SELECT * FROM usuario WHERE usuario = '$usuario'";
    $sqlc = "SELECT * FROM usuario WHERE cedula = '$cedula'";
    $resultadou = mysqli_query($conn, $sqlu);
    $resultadoc = mysqli_query($conn, $sqlc);
    if ($resultadou && mysqli_num_rows($resultadou) > 0 ) {
        $resfinal ="Usuario repetido";
    }
     if ($resultadoc && mysqli_num_rows($resultadoc) > 0) {
        $resfinal = "Cedula repetida";
    }
}
echo $resfinal;
}
$conn->close();
?>