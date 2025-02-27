<?php
session_start();
require 'server/conexion.php';
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $usuario = $_POST['usuario'];
  $clave = $_POST['clave'];

  $usuario = $conn->real_escape_string($usuario);
  $clave = $conn->real_escape_string($clave);

  $sql = "SELECT * FROM usuario WHERE usuario = ? AND contrasenia = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $usuario, $clave);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $_SESSION['usuario'] = $usuario;
    header("Location: ./html/MenuInicio.php");
    exit();
  } else {
    $error = "⚠ Usuario o contraseña incorrectos";
  }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Iniciar Sesión</title>
  <link rel="stylesheet" type="text/css" href="css/estilo.css">
  <script src="js/validacionLogin.js" defer></script>
</head>

<body>
  <div id="login">
    <div class="contenedor">
      <form method="post" action="index.php" onsubmit=""> 
        <p><strong>Ingreso Usuario</strong></p>
        
        <p class="login_input">
          <div>
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario" required onchange="">
          </div>
          <span id="alertUser" class="msjvalido"></span>
        </p>
        
        <p class="login_input">
          <div>
            <label for="clave">Contraseña:</label>
            <input type="password" name="clave" id="clave" required onchange="">
          </div>
          <span id="alertPassword" class="msjvalido"></span>
        </p>
        
        <p style="color: red;">
          <?php echo $error; ?>
        </p>
        
        <p>
          <button type="submit" id="btnSubmit">Ingresar</button>
          <input type="reset" value="Restablecer" onclick="reestablecer()">
        </p>
      </form>
    </div>  
    <div class="logo"><img src="img/logo.png"></div>
  </div>
</body>

</html>
