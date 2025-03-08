<?php
session_start();
require '../server/conexion.php';

$consulta = "SELECT CONCAT(u.nombre,' ',u.apellido) AS 'usuario', a.fecha_hora, a.detalle 
FROM auditoria a JOIN usuario u ON a.idUsuario=u.idUsuario order by a.fecha_hora desc";

$resultado = mysqli_query($conn, $consulta);
$tabla = '';

while ($registro = mysqli_fetch_assoc($resultado)) {
    $tabla .= '<tr>';
    $tabla .= '<td>' . htmlspecialchars($registro['detalle']) . '</td>';
	$tabla .= '<td>' . htmlspecialchars($registro['usuario']) . '</td>';
    $tabla .= '<td>' . htmlspecialchars($registro['fecha_hora']) .'</td>';
    $tabla .= '</tr>';
}

?>
<!doctype html>
<html>
<head>
<title>Auditoría</title>
<script src="../js/auditoria.js"></script>
</head>

<body>
<div id="contenido">

		<div class="container">
		<div class="d-flex justify-content-between">
        <h4>Registro de Auditoría</h4>
    </div> 

    <div class="row py-2">
        <div class="col-md-2">
            <div class="input-group input-group-sm mx-5 my-2">
                <span class="input-group-text bg-white border-light">
                    <i class="bi bi-search"></i> 
                </span>
                <input type="text" class="form-control border-light rounded-end" placeholder="Buscar..." id="filtroin">
            </div>
        </div>
    </div>
		<div class="container">
		<div class="table-responsive">
		<table class="table table-striped" id="tabla">
			<thead class="table-secondary">
			<tr>
				<th>Acción
				</th>
				<th>
				Realizada por:
				<button class="btn btn-sm btn-light ms-2" id="filtroUsuario">
					<i class="bi bi-arrow-down-circle"></i> 
				</button>
				</th>
				<th>
				Fecha y Hora
				  <button class="btn btn-sm btn-light ms-2" id="filtroFH">
					<i class="bi bi-arrow-down-circle"></i> 
				</button>
				</th>
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


</body>
</html>