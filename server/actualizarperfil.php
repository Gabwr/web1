<?php
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $perfil = mysqli_real_escape_string($conn, $_POST["perfil"]);
    $nuevoPerfil = mysqli_real_escape_string($conn, $_POST["nuevoPerfil"]);
    $permisos = $_POST["permisos"]; 

    $todosLosPermisos = [
        "lectura_ingresos", "Insercion_ingresos", "edicion_ingresos", "lectura_gastos", 
        "insercion_gastos", "edicion_gastos", "lectura_usuarios", "insercion_usuarios", 
        "edicion_usuarios", "lectura_perfiles", "insercion_perfiles", "edicion_perfiles", 
        "lectura_conceptos", "insercion_conceptos", "edicion_conceptos", "lectura_qr"
    ];

    $setPermisos = [];
    foreach ($todosLosPermisos as $permiso) {
        $estado = in_array($permiso, $permisos) ? 'TRUE' : 'FALSE';
        $setPermisos[] = "$permiso = $estado";
    }


    $setPermisosSQL = implode(", ", $setPermisos);

    $sql = "UPDATE perfiles SET perfil = '$nuevoPerfil', $setPermisosSQL WHERE perfil = '$perfil'";

    error_log("Consulta SQL: " . $sql);

    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        error_log("Error en la consulta SQL: " . mysqli_error($conn)); 
        echo "no";
    }
}
?>
