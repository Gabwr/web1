<!DOCTYPE html>
<html lang="es">

<head>
    <title>Lista de QR</title>
</head>

<body>
    <div id="contenido">
        <div class="container">
            <div class="d-flex justify-content-between">
                <h4>Códigos Qr</h4>
                <button class="btn shadow-sm border-light" data-bs-toggle="modal"
                    data-bs-target="#modalAgregarQR">Agregar Nuevo
                    QR</button>
            </div>
        </div>
        <div class="container">
            <div class="table-responsive"
                style="margin-top: 2rem;  max-height: 47vh; overflow-y: auto; scrollbar-width:thin">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID <button class="btn btn-sm btn-light ms-2" id="filtroFecha">
                                    <i class="bi bi-arrow-down-circle"></i>
                                </button></th>
                            <th>QR <button class="btn btn-sm btn-light ms-2" id="filtroFecha">
                                    <i class="bi bi-arrow-down-circle"></i>
                                </button></th>
                            <th>Descripcion<button class="btn btn-sm btn-light ms-2" id="filtroFecha">
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
                        $sql = "SELECT * FROM qr";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                <td>{$row['qr_id']}</td>         
                                <td><img src='{$row['qr_url']}' alt='Código QR' style='width: 40px; height: auto;'></td>
                                <td>{$row['qr_descripcion']}</td> 
                                <td>
                                 <button class='btn btn-warning btnEditar' 
                        data-id='{$row['qr_id']}' 
                        data-url='{$row['qr_url']}' 
                        data-descripcion='{$row['qr_descripcion']}'>Editar</button>
                                </td>
                              </tr>";
                            }
                        } else {
                            echo "<tr><td>No hay enlaces QR registrados.</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>


    <div class="modal fade" id="modalAgregarQR" tabindex="-1" aria-labelledby="modalAgregarQRLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarQRLabel">Agregar Nuevo QR</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formAgregarQR">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="qr_url" class="form-label">URL de la Imagen QR</label>
                            <input type="text" class="form-control" id="qr_url" name="qr_url" required>
                        </div>
                        <div class="mb-3">
                        <label for="qr_descripcion" class="form-label">Descripción</label>
                        <input type="text" class="form-control" id="qr_descripcion" name="qr_descripcion" required>
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

    <div class="modal fade" id="modalEditarQR" tabindex="-1" aria-labelledby="modalEditarQRLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarQRLabel">Editar QR</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditarQR">
                    <div class="modal-body">
                        <input type="hidden" id="edit_qr_id" name="qr_id">
                        <div class="mb-3">
                            <label for="edit_qr_url" class="form-label">URL de la Imagen QR</label>
                            <input type="text" class="form-control" id="edit_qr_url" name="qr_url" required>
                        </div>
                        <div class="mb-3">
                        <label for="edit_descripcion" class="form-label">Descripción</label>
                        <input type="text" class="form-control" id="edit_descripcion" name="qr_descripcion" required>
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

    <script src="../js/qr.js">

    </script>
</body>

</html>