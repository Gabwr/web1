<!DOCTYPE html>
<html lang="es">
<head>
    <title>Gestión de Conceptos</title>
</head>

<body>
    <div id="contenido">
        <div class="container">
                <div class="d-flex justify-content-between">
                    <h4>Conceptos</h4>
                    <button class="btn shadow-sm border-light" data-bs-toggle="modal"
                        data-bs-target="#modalAgregarConcepto">Agregar Concepto</button>
                </div>
        </div>
        
        <div class="container">
            <div class="table-responsive" style="margin-top: 2rem;max-height: 47vh; overflow-y: auto; scrollbar-width:thin">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID <button class="btn btn-sm btn-light ms-2" id="filtroFecha">
                                    <i class="bi bi-arrow-down-circle"></i>
                                </button></th>
                            <th>Nombre <button class="btn btn-sm btn-light ms-2" id="filtroFecha">
                                    <i class="bi bi-arrow-down-circle"></i>
                                </button></th>
                            <th>Tipo <button class="btn btn-sm btn-light ms-2" id="filtroFecha">
                                    <i class="bi bi-arrow-down-circle"></i>
                                </button></th>
                            <th>Código QR <button class="btn btn-sm btn-light ms-2" id="filtroFecha">
                                    <i class="bi bi-arrow-down-circle"></i>
                                </button></th>
                            <th>Acciones <button class="btn btn-sm btn-light ms-2" id="filtroFecha">
                                    <i class="bi bi-arrow-down-circle"></i>
                                </button></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include '../server/conexion.php';
                        $sql = "SELECT c.idconcepto, c.nombre, c.tipo, q.qr_url, q.qr_id 
                        FROM concepto c
                        LEFT JOIN qr q ON c.qr_id = q.qr_id";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                <td>{$row['idconcepto']}</td>         
                                <td>{$row['nombre']}</td>
                                <td>{$row['tipo']}</td>
                                <td><img src='{$row['qr_url']}' alt='Código QR' style='width: 50px; height: auto;'></td>
                                <td>
                                    <button class='btn btn-warning btn-custom btnEditar' 
                                            data-id='{$row['idconcepto']}' 
                                            data-nombre='{$row['nombre']}' 
                                            data-tipo='{$row['tipo']}'
                                            data-qr='{$row['qr_id']}'>
                                        Editar
                                    </button>
                                </td>
                              </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No hay conceptos registrados.</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    </div>



    <div class="modal fade" id="modalAgregarConcepto" tabindex="-1" aria-labelledby="modalAgregarConceptoLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarConceptoLabel">Agregar Nuevo Concepto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formAgregarConcepto">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Concepto</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo de Concepto</label>
                            <select class="form-control" id="tipo" name="tipo" required>
                                <option value="Ingreso">Ingreso</option>
                                <option value="Gasto">Gasto</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="qr_id" class="form-label">Código QR</label>
                            <select class="form-control" id="qr_id" name="qr_id" required>
                                <option value="">Seleccione un código QR</option>
                                <?php
                                include '../server/conexion.php';
                                $sql_qr = "SELECT qr_id, qr_url FROM qr";
                                $result_qr = $conn->query($sql_qr);
                                while ($row = $result_qr->fetch_assoc()) {
                                    echo "<option value='" . $row['qr_id'] . "'>" . $row['qr_url'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditarConcepto" tabindex="-1" aria-labelledby="modalEditarConceptoLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarConceptoLabel">Editar Concepto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditarConcepto">
                    <div class="modal-body">
                        <input type="hidden" id="edit_idconcepto" name="idconcepto">
                        <div class="mb-3">
                            <label for="edit_nombre" class="form-label">Nombre del Concepto</label>
                            <input type="text" class="form-control" id="edit_nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_tipo" class="form-label">Tipo de Concepto</label>
                            <select class="form-control" id="edit_tipo" name="tipo" required>
                                <option value="Ingreso">Ingreso</option>
                                <option value="Gasto">Gasto</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_qr_id" class="form-label">Código QR</label>
                            <select class="form-control" id="edit_qr_id" name="qr_id" required>
                                <option value="">Seleccione un código QR</option>
                                <?php
                                $result_qr->data_seek(0);
                                while ($row = $result_qr->fetch_assoc()) {
                                    echo "<option value='" . $row['qr_id'] . "'>" . $row['qr_url'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../js/conceptos.js"></script>
</body>

</html>