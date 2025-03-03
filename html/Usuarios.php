<?php
session_start();
require '../server/conexion.php';

$consulta = 'SELECT * FROM usuario';
$perfiles = 'SELECT DISTINCT perfil,estado FROM perfiles';
$listperfiles = mysqli_query($conn, $perfiles);
$resultado = mysqli_query($conn, $consulta);
$tabla = '';

while ($registro = mysqli_fetch_assoc($resultado)) {
    $tabla .= '<tr>';
    $tabla .= '<td>' . htmlspecialchars($registro['idUsuario']) . '</td>';
    $tabla .= '<td>' . htmlspecialchars($registro['nombre'] . ' ' . $registro['apellido']) . '</td>';
    $tabla .= '<td>' . htmlspecialchars($registro['perfil']) . '</td>';
    $tabla .= '<td>' . htmlspecialchars($registro['conexion']) . '</td>';
    $tabla .= '<td>' . htmlspecialchars($registro['estado']) . '</td>';
	$tabla .= '<td>
	<button class="btn btn-sm btn-primary me-1 editar-usuario" 
		data-id="' . htmlspecialchars($registro['idUsuario']) . '"
		data-nombre="' . htmlspecialchars($registro['nombre']) . '"
		data-apellido="' . htmlspecialchars($registro['apellido']) . '"
		data-usuario="' . htmlspecialchars($registro['usuario']) . '"
		data-perfil="' . htmlspecialchars($registro['perfil']) . '">
		<i class="bi bi-pencil"></i> Editar
	</button>
	<button class="btn btn-sm ' . ($registro['estado'] == 'Activo' ?  'btn-danger':'btn-success') . ' toggle-estado"
		data-id="' . htmlspecialchars($registro['idUsuario']) . '" 
		data-estado="' . htmlspecialchars($registro['estado']) . '">
		<i class="bi ' . ($registro['estado'] == 'Activo' ?  'bi-x-circle':'bi-check-circle' ) . '"></i> 
		' . ($registro['estado'] == 'Activo' ? 'Desactivar':'Activar') . '
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
							<input type="password" id="contrasenia" name="contrasenia" class="form-control border-dark" required>
						</label>
					</div>
					<div class="modal-footer">
					<div class="col">
					<label for="perfil" class="form-label">Perfil:</label>
					<select class="form-control border-dark text-dark" id="perfil" name="perfil" required>
					'<option value="seleccione"> Seleccione...</option>';
						<?php
						while ($registro = mysqli_fetch_assoc($listperfiles)) {
							echo '<option value="' . htmlspecialchars($registro['perfil']) . '">' . htmlspecialchars($registro['perfil']) . '</option>';
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



	<div class="modal fade" id="editarmodal" tabindex="-1" aria-labelledby="editarUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="container">
                <div class="row">
                    <h1 class="text-center">Editar Usuario</h1>
                </div>
                <div class="row border border-dark p-3 my-4 mx-4 position-relative">
                    <h3 class="position-absolute top-0 start-0 ms-3 px-2"
                        style="margin-top: -12px; background-color: white; display: inline;">
                        Datos del Usuario
                    </h3>
                    <input type="hidden" id="edit-idUsuario">
                    <div class="col-md-6">
                        <label for="edit-nombre" class="form-label">Nombre:
                            <input type="text" id="edit-nombre" name="nombre" class="form-control border-dark" required>
                        </label>
                    </div>
                    <div class="col-md-6">
                        <label for="edit-apellido" class="form-label">Apellido:
                            <input type="text" id="edit-apellido" name="apellido" class="form-control border-dark" required>
                        </label>
                    </div>
                </div>
                <div class="row border border-dark p-3 my-4 mx-4 position-relative">
                    <h3 class="position-absolute top-0 start-0 ms-3 px-2"
                        style="margin-top: -12px; background-color: white; display: inline;">
                        Datos de la cuenta
                    </h3>
                    <div class="col-md-6">
                        <label for="edit-usuario" class="form-label">Usuario:
                            <input type="text" id="edit-usuario" name="usuario" class="form-control border-dark" required>
                        </label>
                    </div>
                    <div class="col-md-6">
                        <label for="edit-perfil" class="form-label">Perfil:</label>
                        <select class="form-control border-dark text-dark" id="edit-perfil" name="perfil" required>
                            <option value="seleccione">Seleccione...</option>
							<?php
						$listperfiles = mysqli_query($conn, $perfiles); 
						while ($registro = mysqli_fetch_assoc($listperfiles)) {
							echo '<option value="' . htmlspecialchars($registro['perfil']) . '">' . htmlspecialchars($registro['perfil']) . '</option>';
						}
						?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center align-items-center">
                    <button type="button" class="btn btn-white border border-dark" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="guardarCambios">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>
</div>

				</div>



</body>
</html>
