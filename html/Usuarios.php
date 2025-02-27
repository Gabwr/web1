<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Documento sin título</title>
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/menubootstrap.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
	<link rel="stylesheet" href="../css/dialogo.css">
</head>

<body>

		<div class="container">
		<div class="row text-center">
			<h1>Usuarios</h1>
		</div> 
		
		<button	class="btn shadow-sm border-light ms-0 my-4" onclick="mostrarDialogo()">AgregarUsuario</button>

		<div class="row">
			
			<div class="col-md-2">
				<p>Buscar por: </p>
			</div>
			
			<div class="col-md-2">
			<select class="form-select-sm shadow-sm border-light mx-2 my-2">
			<option value="perfil">Perfil</option>
			<option value="nombre">Nombre</option>
			<option value="tiempo">Tiempo de Conexion</option>
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
			<tr>
				<td>1</td>
				<td>Juan Perez</td>
				<td>Hijo Mayor</td>
				<td>3 minutos</td>
				<td>Activo</td>
				<td>
				<button class="btn btn-sm btn-primary me-1">
					<i class="bi bi-pencil"></i> Editar
				</button>
				<button class="btn btn-sm btn-danger">
					<i class="bi bi-x-circle"></i> Desactivar
				</button>
				</td>
			</tr>
			</tbody>
		</table>
		</div>


		
		</div>
	</div>
</div>

	<div class="modal fade" id="miDialogo" tabindex="-1" aria-labelledby="miDialogoLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title" id="miDialogoLabel">Este es un Diálogo</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
				<p>Contenido del diálogo...</p>
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-primary">Aceptar</button>
				</div>
			</div>
		</div>
	</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/usuario.js"></script>


</body>
</html>
