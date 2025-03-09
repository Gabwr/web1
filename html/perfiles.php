<?php
session_start();
require '../server/conexion.php';
$perfiles = 'SELECT DISTINCT perfil, estado FROM perfiles';
$listperfiles = mysqli_query($conn, $perfiles);
if (isset($_GET['perfil'])) {
    $perfil = mysqli_real_escape_string($conn, $_GET['perfil']);
    $query = "SELECT * FROM perfiles WHERE perfil = '$perfil'";
    $resultado = mysqli_query($conn, $query);
    $datosPerfil = mysqli_fetch_assoc($resultado);
}

$tabla = '';

while ($registro = mysqli_fetch_assoc($listperfiles)) {
    $tabla .= '<tr>';
    $tabla .= '<td>' . htmlspecialchars($registro['perfil']) . '</td>';
    $tabla .= '<td>' . htmlspecialchars($registro['estado']) . '</td>';
    $tabla .= '<td>
        <button  class="btn btn-sm btn-primary me-1 editar-perfil" 
            data-perfil="' . htmlspecialchars($registro['perfil']) . '">
            <i class="bi bi-pencil"></i> Editar
        </button>
        <button  class="btn btn-sm ' . ($registro['estado'] == 'Activo' ? 'btn-danger' : 'btn-success') . ' toggle-estado"
            data-perfil="' . htmlspecialchars($registro['perfil']) . '" 
            data-estado="' . htmlspecialchars($registro['estado']) . '"
            style="width: 100px;">
            <i class="bi ' . ($registro['estado'] == 'Activo' ? 'bi-check-circle' : 'bi-x-circle') . '"></i> 
            ' . ($registro['estado'] == 'Activo' ? 'Desactivar' : 'Activar') . '
        </button>
    </td>';
    $tabla .= '</tr>';
}

?>
<!doctype html>
<html>
<head>
<title>Documento sin título</title>
<script src="../js/perfil.js"></script>
<link rel="stylesheet" href="../css/perfil.css" >
</head>

<body>
<div id="contenido">

		<div class="container">
		<div class="d-flex justify-content-between">
        <h4>Perfiles</h4>
		<button class="btn shadow-sm border-light" id="usuariodialog">Agregar Perfil</button>
    </div> 


        <div class="col-md-2" id="filtro">
            <div class="input-group input-group-sm mx-5 my-2">
                <span class="input-group-text bg-white border-light">
                    <i class="bi bi-search"></i> 
                </span>
                <input type="text" id="filtroin" class="form-control border-light rounded-end" placeholder="Buscar...">
            </div>
        </div>
    </div>
		<div class="container" id="tablaperfil">
		<div class="table-responsive">
		<table class="table table-striped">
			<thead class="table-secondary">
			<tr>
				<th>
				Perfil
				<button class="btn btn-sm btn-light ms-2" id="filtroperf">
					<i class="bi bi-arrow-down-circle"></i> 
				</button>
				</th>
				<th>
				Estado
				<button class="btn btn-sm btn-light ms-2" id="filtroest">
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
						<h1 class="text-center">Registrar Nuevo Perfil</h1>
					</div>
					<div class="row border border-dark p-3 my-4 mx-4 position-relative">
							<h3 class="position-absolute top-0 start-0 ms-3 px-2" 
							style="margin-top: -12px; background-color: white; display: inline;">
							Datos del perfil
							</h3>
						<div class="col-md-8">
							<label for="nombre" class="form-label">Nombre del perfil:
								<input type="text" id="nombrepf" name="nombrepf" class="form-control border-dark" required>
							</label>
						</div>
					</div>
					<div class="row border border-dark p-3 my-4 mx-4 position-relative">
						<h3 class="position-absolute top-0 start-0 ms-3 px-2" 
						style="margin-top: -12px; background-color: white; display: inline;">
						Permisos para el perfil
						</h3>
                        <div class="col-md-12 ">
                        <div class="col-md-12 mx-4" id="permisoscontainerinsert">
                        <input class="form-check-input" type="checkbox" name="permisos[]" 
                        value="<?php echo htmlspecialchars($permiso); ?>" id="permiso_
                        <?php echo htmlspecialchars($permiso); ?>">

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
                    <h1 class="text-center">Editar Perfil</h1>
                </div>
                <div class="row border border-dark p-3 my-4 mx-4 position-relative">
                    <h3 class="position-absolute top-0 start-0 ms-3 px-2" style="margin-top: -12px; background-color: white; display: inline;">
                        Datos del perfil
                    </h3>
                    <div class="col-md-8">
                        <label for="nombrepfedit" class="form-label">Nombre del perfil:
                            <input type="text" id="nombrepfedit" name="nombrepfedit" class="form-control border-dark" required>
                        </label>
                    </div>
                </div>
                <div class="row border border-dark p-3 my-4 mx-4 position-relative">
                    <h3 class="position-absolute top-0 start-0 ms-3 px-2" style="margin-top: -12px; background-color: white; display: inline;">
                        Permisos para el perfil
                    </h3>
                    <div class="col-md-12 ">
                        <div class="col-md-12 mx-4" id="permisosContainer">
                        <input class="form-check-input" type="checkbox" name="permisos[]" 
                        value="<?php echo htmlspecialchars($permiso); ?>" id="permiso_
                        <?php echo htmlspecialchars($permiso); ?>">

                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center align-items-center">
                    <button type="button" class="btn btn-white border border-dark" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-white border border-dark" id="guardarCambios">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="infomodal" tabindex="-1" aria-labelledby="infomodal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg my-5">
        <div class="modal-content my-5">
			<div class="container my-5">
				<div class="row">
					<h1 class="text-center" id="mensaje"></h1>
				</div>
			</div>
        </div>
    </div>
</div>

</div>



</body>
</html>
