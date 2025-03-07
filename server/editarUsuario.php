<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $usuario = $_POST['usuario'];
    $perfil = $_POST['perfil'];
    $cedula = $_POST['cedula'];

    $sql = "UPDATE usuario SET cedula = ?,nombre=?, apellido=?, usuario=?, perfil=? WHERE idUsuario=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi",$cedula , $nombre, $apellido, $usuario, $perfil, $id);

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
