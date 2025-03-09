<?php
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $perfil = mysqli_real_escape_string($conn, $_POST["perfil"]);
    $nuevoPerfil = mysqli_real_escape_string($conn, $_POST["nuevoPerfil"]);
    $permisos = json_decode($_POST["permisos"], true); // Decodificamos el JSON

    if (!is_array($permisos)) {
        error_log("Error: Permisos no es un array válido.");
        echo "error";
        exit;
    }

    $todosLosPermisos = [
        "lectura_ingresos", "Insercion_ingresos", "edicion_ingresos", "lectura_gastos",
        "insercion_gastos", "edicion_gastos", "lectura_usuarios", "insercion_usuarios",
        "edicion_usuarios", "lectura_perfiles", "insercion_perfiles", "edicion_perfiles",
        "lectura_conceptos", "insercion_conceptos", "edicion_conceptos", "permiso_qr"
    ];

    $setPermisos = [];
    foreach ($todosLosPermisos as $permiso) {
        $estado = isset($permisos[$permiso]) && $permisos[$permiso] ? 'TRUE' : 'FALSE';
        $setPermisos[] = "$permiso = $estado";
    }

    $setPermisosSQL = implode(", ", $setPermisos);
    $sql = "UPDATE perfiles SET perfil = '$nuevoPerfil', $setPermisosSQL WHERE perfil = '$perfil'";

    error_log("Consulta SQL: " . $sql);

    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        error_log("Error en la consulta SQL: " . mysqli_error($conn));
        echo "error";
    }
}
?>
