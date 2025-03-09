<?php
session_start(); 
require_once 'conexion.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $tipo = trim($_POST["tipo"]);
    $qr_id = trim($_POST["qr_id"]);

    if (empty($nombre) || empty($tipo) || empty($qr_id)) {
        die("Error: Todos los campos son obligatorios.");
    }

    $sql = "INSERT INTO concepto (qr_id, nombre, tipo) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        die("Error en la consulta: " . $conn->error);
    }

    $stmt->bind_param("iss", $qr_id, $nombre, $tipo);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Concepto guardado correctamente.";  
        header("Location: ../html/MenuInicio.php");
        exit();
    } else {
        echo "Error al guardar el concepto: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
