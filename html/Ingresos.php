<?php
session_start();
require '../server/conexion.php';

$consulta = "SELECT i.idIngreso, i.idconcepto, i.idUsuario, i.fecha, i.valor, i.medio_de_pago, 
i.fuente_beneficiario, i.descripcion, i.estado, c.nombre as concepto
FROM ingreso i join concepto c on i.idconcepto=c.idconcepto";
$busca_conceptos="SELECT nombre FROM concepto where tipo='Ingreso'";

$resultado = mysqli_query($conn, $consulta);
$conceptos = mysqli_query($conn,$busca_conceptos);
$opc_conceptos="";
while ($concepto = mysqli_fetch_assoc($conceptos)) {
	$opc_conceptos.='<option value="' . htmlspecialchars($concepto['nombre']) . '">'. htmlspecialchars($concepto['nombre']) .'</option>';
}
$tabla = '';

while ($registro = mysqli_fetch_assoc($resultado)) {
    $tabla .= '<tr>';
    $tabla .= '<td>' . htmlspecialchars($registro['fecha']) . '</td>';
	$tabla .= '<td>' . htmlspecialchars($registro['concepto']) . '</td>';
    $tabla .= '<td>' . htmlspecialchars($registro['fuente_beneficiario']) .'</td>';
    $tabla .= '<td>' . htmlspecialchars($registro['medio_de_pago']) . '</td>';
    $tabla .= '<td>' . htmlspecialchars($registro['valor']) . '</td>';
    $tabla .= '<td>' . htmlspecialchars($registro['descripcion']) . '</td>';
	$tabla .= '<td>
	<button class="btn btn-sm btn-primary me-1 editar-ingreso"
		data-id="'. htmlspecialchars($registro['idIngreso']) . '"
		data-fecha="' . htmlspecialchars($registro['fecha']) . '"
		data-concepto="' . htmlspecialchars($registro['concepto']) . '"
		data-fuente_beneficiario="' . htmlspecialchars($registro['fuente_beneficiario']) . '"
		data-medio_de_pago="' . htmlspecialchars($registro['medio_de_pago']) . '"
		data-valor="' . htmlspecialchars($registro['valor']) . '"
		data-descripcion="' . htmlspecialchars($registro['descripcion']) . '">
		<i class="bi bi-pencil"></i> Editar
	</button>
	<button class="btn btn-sm ' . ($registro['estado'] == 'Activo' ?  'btn-danger':'btn-success') . ' cambiar-estado"
		data-id="' . htmlspecialchars($registro['idIngreso']) . '" 
		data-estado="' . htmlspecialchars($registro['estado']) . '">
		<i class="bi ' . ($registro['estado'] == 'Activo' ?  'bi-x-circle':'bi-check-circle' ) . '"></i> 
		' . ($registro['estado'] == 'Activo' ? 'Eliminar':'Activar') . '
	</button>
  </td>';

    $tabla .= '</tr>';
}

?>
<!doctype html>
<html>
<head>
<title>Ingresos</title>
<script src="../js/ingresos.js"></script>
</head>

<body>
<div id="contenido">

		<div class="container">
		<div class="d-flex justify-content-between">
        <h4>Ingresos</h4>
		<button class="btn shadow-sm border-light" id="ingresos_dialog">Registrar Ingreso</button>
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
		<div class="col-md-4">
			<div class="input-group input-group-sm mx-5 my-2">
				<span class="input-group-text btn btn-sm btn-warning"><i class="bi bi-file-earmark-medical"></i></span>
                <input type="checkbox" class="btn-check" id="mostrarOcultar" autocomplete="off">
				<label class="btn btn-sm btn-warning" id="msj_mO" for="mostrarOcultar">Mostrar Gastos Anulados</label>
            </div>
		</div>
    </div>
		<div class="container">
		<div class="table-responsive">
		<table class="table table-striped">
			<thead class="table-secondary">
			<tr>
				<th>Fecha
				<button class="btn btn-sm btn-light ms-2" id="filtroFecha">
					<i class="bi bi-arrow-down-circle"></i> 
				</button>
				</th>
				<th>
				Motivo
				  <button class="btn btn-sm btn-light ms-2" id="filtroConcepto">
					<i class="bi bi-arrow-down-circle"></i> 
				</button>
				</th>
				<th>
				Origen
				  <button class="btn btn-sm btn-light ms-2" id="filtroFuente">
					<i class="bi bi-arrow-down-circle"></i> 
				</button>
				</th>
				<th>Medio de pago
				<button class="btn btn-sm btn-light ms-2" id="filtroMedio">
					<i class="bi bi-arrow-down-circle"></i>  
				</button>
				</th>
				<th>Valor
				<button class="btn btn-sm btn-light ms-2" id="filtroValor">
					<i class="bi bi-arrow-down-circle"></i> 
				</button>
				</th>
				<th>Descripción
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

	<div class="modal fade" id="ventana_Reg_Ingreso" tabindex="-1" aria-labelledby="miDialogoLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="container">
					<div class="row">
						<h1 class="text-center">Registrar Ingreso</h1>
					</div>
					<div class="row border border-dark p-3 my-4 mx-4 position-relative form-group">
							<h3 class="position-absolute top-0 start-0 ms-3 px-2" 
							style="margin-top: -12px; background-color: white; display: inline;">
							Detalles del ingreso
							</h3>
						<div class="col-md-6">
							<label for="concepto" class="form-label">Motivo:
								<select class="form-control border-dark text-dark" id="concepto" name="concepto" required>
								'<option value=""> Seleccionar...</option>';
						<?php echo($opc_conceptos);
						?>
					</select></label>
							<label for="fuente" class="form-label">Origen:
								<input type="text" id="fuente" name="fuente" class="form-control border-dark" required>
							</label>
						</div>
						<div class="col-md-6">
							<label for="descripcion" class="form-label">Detalle:
								<textarea id="descripcion" name="descripcion" class="form-control border-dark" rows="3" required></textarea>
							</label>
						</div>
					</div>
					<div class="row border border-dark p-3 my-4 mx-4 position-relative">
						<h3 class="position-absolute top-0 start-0 ms-3 px-2" 
						style="margin-top: -12px; background-color: white; display: inline;">
						Datos Financieros
						</h3>
					<div class="col-md-6">
						<label for="metodo" class="form-label">Método de pago:
							<select class="form-control border-dark text-dark" id="metodo" name="metodo" required>
							  <option value="">Seleccionar...</option>
							  <option value="Efectivo">Efectivo</option>
							  <option value="Transferencia Bancaria">Transferencia bancaria</option>
							  <option value="Tarjeta de credito">Tarjeta de crédito</option>
							  <option value="Cheque">Cheque</option>
							</select>
						</label>
					</div>
					<div class="col-md-6">
					<label for="valor" class="form-label">Valor:<input type="number" id="valor" name="valor" step="0.01" value="0" class="form-control border-dark" required></label>
					</div>
					<div class="modal-footer">

				</div>	
				</div>
					<div class="modal-footer d-flex justify-content-center align-items-center">
						<button type="button" class="btn btn-white border border-dark" data-bs-dismiss="modal">Cancelar</button>
						<button type="button" class="btn btn-white border border-dark" id="ingreso" >Registrar</button>
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
						<h1 class="text-center">Modificar Ingreso</h1>
					</div>
					<div class="row border border-dark p-3 my-4 mx-4 position-relative form-group">
							<h3 class="position-absolute top-0 start-0 ms-3 px-2" 
							style="margin-top: -12px; background-color: white; display: inline;">
							Detalles del ingreso
							</h3>
						<div class="col-md-6">
							<label for="concepto" class="form-label">Concepto:
								<select class="form-control border-dark text-dark" id="edit-concepto" name="concepto" required>
								'<option value="seleccione"> Seleccionar...           </option>';
						<?php echo($opc_conceptos);
						?>
					</select></label>
							<label for="fuente" class="form-label">Fuente:
								<input type="text" id="edit-fuente" name="fuente" class="form-control border-dark" required>
							</label>
						</div>
						<div class="col-md-6">
							<label for="descripcion" class="form-label">Descripcion:
								<textarea id="edit-descripcion" name="descripcion" class="form-control border-dark" rows="3" required></textarea>
							</label>
						</div>
					</div>
					<div class="row border border-dark p-3 my-4 mx-4 position-relative">
						<h3 class="position-absolute top-0 start-0 ms-3 px-2" 
						style="margin-top: -12px; background-color: white; display: inline;">
						Datos Financieros
						</h3>
					<div class="col-md-6">
						<label for="metodo" class="form-label">Método de pago:
							<select class="form-control border-dark text-dark" id="edit-metodo" name="metodo" required>
							  <option value="">Seleccionar...</option>
							  <option value="Efectivo">Efectivo</option>
							  <option value="Transferencia Bancaria">Transferencia bancaria</option>
							  <option value="Tarjeta de credito">Tarjeta de crédito</option>
							  <option value="Cheque">Cheque</option>
							</select>
						</label>
					</div>
					<div class="col-md-6">
					<label for="valor" class="form-label">Valor:<input type="number" id="edit-valor" name="valor" step="0.01" class="form-control border-dark" required></label>
					</div>
					<div class="modal-footer">

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



</body>
</html>