<?php
require 'conexion.php';

if (isset($_POST['usuario'])) {
    $usuario = mysqli_real_escape_string($conn, $_POST['usuario']); 

    $query = "SELECT perfil FROM usuario WHERE usuario = '$usuario'";
    $resultado = mysqli_query($conn, $query);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_assoc($resultado);
        $perfil = $fila['perfil'];
        $Perfil = "SELECT * FROM perfiles WHERE perfil = '$perfil'";
        $resultperf = mysqli_query($conn, $Perfil);

        if ($resultperf && mysqli_num_rows($resultperf) > 0) {
            $perfildt = mysqli_fetch_assoc($resultperf);
            echo json_encode($perfildt);
        } else {
            echo json_encode(["error" => "Perfil no encontrado"]);
        }
    } else {
        echo json_encode(["error" => "Usuario no encontrado"]);
    }
} else {
    echo json_encode(["error" => "Solicitud inválida"]);
}
?>
