<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $qr_id = $_POST['qr_id'];
    $qr_url = $_POST['qr_url'];

    if (!empty($qr_id) && !empty($qr_url)) {
        $sql = "UPDATE qr SET qr_url = ? WHERE qr_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $qr_url, $qr_id);

        if ($stmt->execute()) {
            echo "QR actualizado correctamente.";
            exit();
        } else {
            echo "Error al actualizar el QR: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "ID o URL del QR no pueden estar vacíos.";
    }
}

$conn->close();
?>
