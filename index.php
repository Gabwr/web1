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
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Iniciar Sesión</title>
  <link rel="stylesheet" type="text/css" href="css/estilo.css">
  <script src="js/validacionLogin.js" defer></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<div class="container-fluid">
<div class="login-form">
    <div class="formulario espaciado">
	<img src="img/contab-logo.png">
      <form method="post" action="index.php" > 
        <h3><strong>Iniciar sesión</strong></h3>
        <p>
          <div class="form-group campo">
            <label for="usuario">Usuario:</label><br>
            <input type="text" name="usuario" id="usuario" class="form-control" required >
          </div>
          <div class="form-group campo">
            <label for="clave">Contraseña:</label><br>
            <input type="password" name="clave" id="clave" class="form-control" required >
          </div>
          <span id="alertPassword" class="msjvalido"></span>
        </p>
        
        <p style="color: red;">
          <?php echo $error; ?>
        </p>
        
        <p>
          <button type="submit" id="btnSubmit" class="btn botonLogin" >Ingresar</button>
        </p>
		<p>¿No tienes cuenta?<a href="">Regístrate</a></p>
      </form>
    </div>  
  </div>
	<div class="fondo">
		<img src="img/background-img.jpg">
	</div>
	</div>
</body>

</html>
