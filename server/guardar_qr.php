<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $qr_url = $_POST['qr_url'];
    $qr_descripcion = $_POST['qr_descripcion'];

    if (!empty($qr_url)) {
        $sql = "INSERT INTO qr (qr_url, qr_descripcion) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ss", $qr_url, $qr_descripcion);
            if ($stmt->execute()) {
                exit();
            } else {
                echo "Error al guardar el QR: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error al preparar la consulta: " . $conn->error;
        }
    } else {
        echo "La URL del QR no puede estar vacía.";
    }
}

$conn->close();
?>