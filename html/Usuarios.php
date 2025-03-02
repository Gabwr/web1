<?php
session_start();
require '../server/conexion.php';

$consulta = 'SELECT * FROM usuario';
$perfiles = 'SELECT * FROM perfil';
$resultado = mysqli_query($conn, $consulta);
$tabla = '';

while ($registro = mysqli_fetch_assoc($resultado)) {
    $tabla .= '<tr>';
    $tabla .= '<td>' . htmlspecialchars($registro['idUsuario']) . '</td>';
    $tabla .= '<td>' . htmlspecialchars($registro['nombre'] . ' ' . $registro['apellido']) . '</td>';
    $tabla .= '<td>' . htmlspecialchars($registro['idPerfil']) . '</td>';
	$tabla .= '<td>' . htmlspecialchars($registro['Conexion']) . '</td>';
    $tabla .= '<td>' . htmlspecialchars($registro['estado']) . '</td>';
    $tabla .= '<td>
                <button class="btn btn-sm btn-primary me-1">
                    <i class="bi bi-pencil"></i> Editar
                </button>
                <button class="btn btn-sm btn-danger">
                    <i class="bi bi-x-circle"></i> Desactivar
                </button>
              </td>';
    $tabla .= '</tr>';
}

?>
<!doctype html>
<html>
<head>
<title>Documento sin título</title>
<script src="../js/Usuario.js"></script>
</head>

<body>
<div id="contenido">

		<div class="container">
		<div class="d-flex justify-content-between">
        <h4>Usuarios</h4>
		<button class="btn shadow-sm border-light" id="usuariodialog">Agregar Usuario</button>
    </div> 

    <div class="row py-2">
        <div class="col-md-2">
            <p>Buscar por: </p>
        </div>

        <div class="col-md-2">
            <select class="form-select-sm shadow-sm border-light mx-2 my-2">
                <option value="perfil">Perfil</option>
                <option value="nombre">Nombre</option>
                <option value="tiempo">Tiempo de Conexión</option>
            </select>
        </div>

        <div class="col-md-2">
            <div class="input-group input-group-sm mx-5 my-2">
                <span class="input-group-text bg-white border-light">
                    <i class="bi bi-search"></i> 
                </span>
                <input type="text" class="form-control border-light rounded-end" placeholder="Buscar...">
            </div>
        </div>
    </div>
		<div class="container">
		<div class="table-responsive">
		<table class="table table-striped">
			<thead class="table-secondary">
			<tr>
				<th>Id</th>
				<th>
				Nombre y Apellido
				<button class="btn btn-sm btn-light ms-2" onclick="filtrarPorNombre()">
					<i class="bi bi-arrow-down-circle"></i> 
				</button>
				</th>
				<th>
				Perfil 
				<button class="btn btn-sm btn-light ms-2" onclick="filtrarPorEdad()">
					<i class="bi bi-arrow-down-circle"></i> 
				</button>
				</th>
				<th>Última Conexión
				<button class="btn btn-sm btn-light ms-2" onclick="filtrarPorPais()">
					<i class="bi bi-arrow-down-circle"></i>  
				</button>
				</th>
				<th>Estado
				<button class="btn btn-sm btn-light ms-2" onclick="filtrarPorPais()">
					<i class="bi bi-arrow-down-circle"></i> 
				</button>
				</th>
				<th></th>
			</tr>
			</thead>
			<tbody id="tabla-body">
			<?php echo $tabla; ?>
			</tbody>
		</table>
		</div>


		
		</div>
	</div>
</div>

	<div class="modal fade" id="miDialogo" tabindex="-1" aria-labelledby="miDialogoLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="container">
                <div class="row">
                    <h1 class="text-center">Registrar Usuario</h1>
                </div>
                <div class="row border border-dark p-3 my-4 mx-4 position-relative">
						<h3 class="position-absolute top-0 start-0 ms-3 px-2" 
						style="margin-top: -12px; background-color: white; display: inline;">
						Datos del Usuario
						</h3>
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre:
                            <input type="text" id="nombre" name="nombre" class="form-control border-dark" required>
                        </label>
                    </div>
                    <div class="col-md-6">
                        <label for="apellido" class="form-label">Apellido:
                            <input type="text" id="apellido" name="apellido" class="form-control border-dark" required>
                        </label>
                    </div>
                </div>
				<div class="row border border-dark p-3 my-4 mx-4 position-relative">
					<h3 class="position-absolute top-0 start-0 ms-3 px-2" 
					style="margin-top: -12px; background-color: white; display: inline;">
					Datos de la cuenta
					</h3>
				<div class="col-md-6">
					<label for="usuario" class="form-label">Usuario:
						<input type="text" id="usuario" name="usuario" class="form-control border-dark" required>
					</label>
					<label for="contrasenia" class="form-label">Contraseña:
						<input type="text" id="contrasenia" name="contrasenia" class="form-control border-dark" required>
					</label>
				</div>
				<div class="modal-footer">
				<div class="col-md-6">
				<label for="perfil" class="form-label">Perfil:</label>
				<select class="form-control border-dark" id="perfil" name="perfil" required>
					<?php
					while ($registro = mysqli_fetch_assoc($resultado)) {
						echo '<option value="' . $registro['idPerfil'] . '">' . htmlspecialchars($registro['nombre']) . '</option>';
					}
					?>
				</select>
				</div>

			</div>	
            </div>
            <div class="modal-footer d-flex justify-content-center align-items-center">
				<button type="button" class="btn btn-white border border-dark" data-bs-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-white border border-dark" id="ingreso" >Ingresar</button>
			</div>
		</div>
	</div>
        </div>
    </div>
	</div>

				</div>



</body>
</html>
