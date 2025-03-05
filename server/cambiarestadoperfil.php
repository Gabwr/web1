<?php
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["perfil"]) && isset($_POST["estado"])) {
    $perfil = $_POST["perfil"]; 
    $nuevoEstado = $_POST["estado"];

    $query = "UPDATE perfiles SET estado = ? WHERE perfil = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $nuevoEstado, $perfil);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
    $conn->close();
}

?>
