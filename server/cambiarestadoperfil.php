<?php
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["perfil"]) && isset($_POST["estado"])) {
    $perfil = $_POST["perfil"]; 
    $nuevoEstado = $_POST["estado"];

    if ($nuevoEstado === "Inactivo") {
        $queryinner = "SELECT COUNT(*) as total FROM usuario WHERE perfil = '$perfil'";
        $resultado = $conn->query($queryinner);
        if ($resultado) {
            $num = $resultado->fetch_assoc();
            if ($num['total'] > 0) {
                echo "error";
                $conn->close();
                return;
            }
        }

        $stmtc->close();
    }

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
