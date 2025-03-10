<?php
session_destroy();
session_unset();
session_start();
require 'server/conexion.php';
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $usuario = $_POST['usuario'];
  $clave = $_POST['clave'];

  $usuario = $conn->real_escape_string($usuario);

  $sql = "SELECT * FROM usuario WHERE usuario = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $usuario);
  $stmt->execute();
  $result = $stmt->get_result();
	$consult=mysqli_fetch_assoc($result);
 $clave_encriptada="";
  if ($result->num_rows > 0){
	  $clave_encriptada=$consult['contrasenia'];
  }

  if (password_verify($clave,$clave_encriptada)) {
    $_SESSION['usuario'] = $consult;
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
  <script src="js/clave.js" defer></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
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
			 <i class="bi bi-person-fill"></i>
            <label for="usuario">Usuario:</label><br>
            <input type="text" name="usuario" id="usuario" class="form-control" required >
          </div>
          <div class="form-group campo">
			  <i class="bi bi-lock-fill"></i>
            <label for="clave">Contraseña:</label><br>
			  <div class="input-group"><input type="password" name="clave" id="clave" class="form-control" required>
			  <div class="input-group-append" id="btnOjo"><i class=" input-group-text bi bi-eye-fill" style="height: 100%;" id="ojo"></i></div>
			  
			  </div>
          </div>
          <span id="alertPassword" class="msjvalido"></span>
        </p>
        
        <p style="color: red;">
          <?php echo $error; ?>
        </p>
        
        <p>
          <button type="submit" id="btnSubmit" class="btn btn-success botonLogin">Ingresar</button>
        </p>
		<p><a href="html/cambiocontra.php">Recuperar contraseña</a></p>
      </form>
    </div>  
  </div>
	<div class="fondo">
		<img src="img/background-img.jpg">
	</div>
	</div>
</body>

</html>