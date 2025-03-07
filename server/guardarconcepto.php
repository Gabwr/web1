<?php
require_once '../server/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $tipo = $_POST["tipo"];
    $qr_id = $_POST["qr_id"];

    $sql = "INSERT INTO concepto (qr_id, nombre, tipo) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $qr_id, $nombre, $tipo);

    if ($stmt->execute()) {
        echo "Concepto guardado exitosamente.";
    } else {
        echo "Error al guardar el concepto: " . $stmt->error;
    }   

    $stmt->close();
    $conn->close();
}
?>
