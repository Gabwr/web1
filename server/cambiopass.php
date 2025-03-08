<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $cont = $_POST['contrasenianueva'];
    $hashcont = password_hash($cont, PASSWORD_BCRYPT);

    $sql = "UPDATE usuario SET contrasenia =? WHERE idUsuario=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si",$hashcont, $id);

    if ($stmt->execute()) {
        echo "Usuario actualizado correctamente.";
    } else {
        echo "Error al actualizar usuario: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Acceso no permitido.";
}
?>