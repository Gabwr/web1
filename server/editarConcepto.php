<?php
require_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['idconcepto']) && !empty($_POST['idconcepto']) &&
        isset($_POST['nombre']) && !empty($_POST['nombre']) &&
        isset($_POST['tipo']) && !empty($_POST['tipo']) &&
        isset($_POST['qr_id']) && !empty($_POST['qr_id'])) {

        $idconcepto = $_POST['idconcepto'];
        $nombre = $_POST['nombre'];
        $tipo = $_POST['tipo'];
        $qr_id = $_POST['qr_id'];

        $sql = "UPDATE concepto SET nombre = ?, tipo = ?, qr_id = ? WHERE idconcepto = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssii", $nombre, $tipo, $qr_id, $idconcepto);

            if ($stmt->execute()) {
                echo "Concepto editado correctamente.";
                header("Location: ../html/MenuInicio.php");
                exit();
            } else {
                echo "Error al actualizar el concepto: " . $conn->error;
            }
        } else {
            echo "Error al preparar la consulta: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "Por favor, complete todos los campos.";
    }
}

$conn->close();
?>
