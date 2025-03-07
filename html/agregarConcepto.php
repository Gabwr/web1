<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Conceptos</title>
</head>

<body>
    <div class="container">
        <h1 style="font-size: 24px; margin-bottom: 4rem;">Gestión de Conceptos</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Código QR</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    require_once '../server/conexion.php';
                    $sql = "SELECT c.idconcepto, c.nombre, c.tipo, q.qr_url 
                            FROM concepto c
                            JOIN qr q ON c.qr_id = q.qr_id";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['idconcepto'] . "</td>";
                        echo "<td>" . $row['nombre'] . "</td>";
                        echo "<td>" . $row['tipo'] . "</td>";
                        echo "<td>" . $row['qr_id'] . "</td>";
                        echo "<td>
                                <button class='btn btn-primary btn-sm'>Editar</button>
                                <button class='btn btn-danger btn-sm'>Eliminar</button>
                             </td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>

        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addConceptModal">
            Agregar Concepto
        </button>

        <div class="modal fade" id="addConceptModal" tabindex="-1" role="dialog" aria-labelledby="addConceptModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addConceptModalLabel">Agregar Concepto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="conceptForm" method="post" action="save_concept.php">
                            <div class="form-group">
                                <label for="nombre">Nombre del Concepto:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="form-group">
                                <label for="tipo">Tipo de Concepto:</label>
                                <select class="form-control" id="tipo" name="tipo" required>
                                    <option value="">Seleccione un tipo</option>
                                    <option value="Ingreso">Ingreso</option>
                                    <option value="Gasto">Gasto</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="qr_id">Código QR:</label>
                                <select class="form-control" id="qr_id" name="qr_id" required>
                                    <option value="">Seleccione un código QR</option>
                                    <?php
                                        $sql = "SELECT qr_id, qr_url FROM qr";
                                        $result = $conn->query($sql);
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['qr_id'] . "'>" . $row['qr_url'] . "</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" form="conceptForm">Guardar Concepto</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
