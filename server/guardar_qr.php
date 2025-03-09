<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $qr_url = $_POST['qr_url'];

    if (!empty($qr_url)) {
        $sql = "INSERT INTO qr (qr_url) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $qr_url);

        if ($stmt->execute()) {
            echo "QR guardado correctamente.";
            exit();
        } else {
            echo "Error al guardar el QR: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "La URL del QR no puede estar vacía.";
    }
}

$conn->close();
?>