<?php
require '../server/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && isset($_POST["estado"])) {
    $idIngreso = intval($_POST["id"]);
    $nuevoEstado = $_POST["estado"];

    $query = "UPDATE ingreso SET estado = ? WHERE idIngreso = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $nuevoEstado, $idIngreso);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
    $conn->close();
}
?>