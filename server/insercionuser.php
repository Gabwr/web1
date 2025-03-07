<?php 
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST['nombre']);
    $ape = trim($_POST['apellido']);
    $user = trim($_POST['usuario']);
    $pass = trim($_POST['contrasenia']);
    $perf = trim($_POST['perfil']);
    $cedula = trim($_POST['cedula']);
    
    $hashpass = password_hash($pass, PASSWORD_BCRYPT);

    $sql = "INSERT INTO usuario (cedula,nombre, apellido, usuario, contrasenia, perfil, estado) 
    VALUES ('$cedula','$nom', '$ape', '$user', '$hashpass', '$perf', 'Activo')";

    if (mysqli_query($conn, $sql)) {
        echo "Usuario ingresado exitosamente";  
        echo "success";
    } else {
        echo "Error";
    }
} else {
    echo "Acceso no permitido";
}
?>
