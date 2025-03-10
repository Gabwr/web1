<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $qr_id = $_POST['qr_id'];
    $qr_url = $_POST['qr_url'];
    $qr_descripcion = $_POST['qr_descripcion'];

    if (!empty($qr_id) ){
        $sql = "UPDATE qr SET qr_url = ?, qr_descripcion = ? WHERE qr_id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssi", $qr_url, $qr_descripcion, $qr_id);
            if ($stmt->execute()) {
                exit();
            } else {
                echo "Error al actualizar el QR: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error al preparar la consulta: " . $conn->error;
        }
    } else {
        echo "El ID del QR no puede estar vacío.";
    }
}

$conn->close();
?>