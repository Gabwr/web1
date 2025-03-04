<?php
require '../server/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombrePerfil = mysqli_real_escape_string($conn, $_POST["nombrePerfil"]);
    $permisos = $_POST["permisos"]; 

    $permisosCampos = [
        "lectura_ingresos", "Insercion_ingresos", "edicion_ingresos",
        "lectura_gastos", "insercion_gastos", "edicion_gastos",
        "lectura_usuarios", "insercion_usuarios", "edicion_usuarios",
        "lectura_perfiles", "insercion_perfiles", "edicion_perfiles",
        "lectura_conceptos", "insercion_conceptos", "edicion_conceptos",
        "lectura_qr"
    ];
    $valores = [];
    foreach ($permisosCampos as $permiso) {
        $valores[$permiso] = in_array($permiso, $permisos) ? "TRUE" : "FALSE";
    }

    $sql = "INSERT INTO perfiles (perfil, " . implode(", ", array_keys($valores)) . ") 
            VALUES ('$nombrePerfil', " . implode(", ", $valores) . ")";

    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "error";
    }
}
?>
