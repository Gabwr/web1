<?php
require 'conexion.php';

if (isset($_POST['perfil'])) {
    $perfil = mysqli_real_escape_string($conn, $_POST['perfil']);
    
    $query = "SELECT * FROM perfiles WHERE perfil = '$perfil'";
    $resultado = mysqli_query($conn, $query);
    
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $datosPerfil = mysqli_fetch_assoc($resultado);

        $queryPermisos = "SELECT COLUMN_NAME 
                          FROM INFORMATION_SCHEMA.COLUMNS 
                          WHERE TABLE_NAME = 'perfiles' 
                          AND TABLE_SCHEMA = 'economiaf'
                          AND DATA_TYPE = 'tinyint'
                          AND COLUMN_NAME != 'estado'";

        $resultadoPermisos = mysqli_query($conn, $queryPermisos);
        $permisos = [];

        while ($fila = mysqli_fetch_assoc($resultadoPermisos)) {
            $permisos[$fila['COLUMN_NAME']] = isset($datosPerfil[$fila['COLUMN_NAME']]) && $datosPerfil[$fila['COLUMN_NAME']] == 1 ? true : false;
        }

        echo json_encode($permisos);
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}
?>
