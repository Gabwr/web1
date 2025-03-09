<?php
require 'conexion.php';

if (isset($_POST['usuario'])&&isset($_POST['cedula'])) {

    $usuario= mysqli_real_escape_string($conn, $_POST['usuario']);
    $cedula = mysqli_real_escape_string($conn, $_POST['cedula']);
    $query = "SELECT idUsuario FROM usuario WHERE cedula = '$cedula' AND usuario='$usuario'";
    $resultado = mysqli_query($conn, $query);
    
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $id= mysqli_fetch_assoc($resultado); 
        echo $id['idUsuario'];
    } else {
        echo "error, usuario no encontrado";
    }
} else {
    echo "error, datos invalidos";
}
?>