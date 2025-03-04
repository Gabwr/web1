<?php 
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST['nombre']);
    $ape = trim($_POST['apellido']);
    $user = trim($_POST['usuario']);
    $pass = trim($_POST['contrasenia']);
    $perf = trim($_POST['perfil']);
    if (empty($nom) || empty($ape) || empty($user) || empty($pass) || empty($perf)) {
        echo "Todos los campos son obligatorios";
        exit;
    }
    
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuario (nombre, apellido, usuario, contrasenia, perfil,estado) VALUES (?, ?, ?, ?, ?,)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nom, $ape, $user, $hashed_password, $perf, 'Activo');

    if ($stmt->execute()) {
        echo "Usuario ingresado exitosamente";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Acceso no permitido";
}
?>
