<?php
require '../server/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && isset($_POST["estado"])) {
    $idUsuario = intval($_POST["id"]);
    $nuevoEstado = $_POST["estado"];

    $query = "UPDATE usuario SET estado = ? WHERE idUsuario = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $nuevoEstado, $idUsuario);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
    $conn->close();
}
?>
