<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Control de Citas - Prueba</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Agendar Cita</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('citas/guardar') ?>" method="post">
                        <div class="mb-3">
                            <label class="form-label">Paciente:</label>
                            <input type="text" name="paciente" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Teléfono:</label>
                            <input type="text" name="telefono" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Motivo:</label>
                            <input type="text" name="motivo" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fecha:</label>
                            <input type="date" name="fecha" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Guardar Cita</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Listado de Citas</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Paciente</th>
                                <th>Teléfono</th>
                                <th>Motivo</th>
                                <th>Fecha</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($citas)): ?>
                                <?php foreach($citas as $c): ?>
                                    <tr>
                                        <td><?= esc($c['paciente']) ?></td>
                                        <td><?= esc($c['telefono']) ?></td>
                                        <td><?= esc($c['motivo']) ?></td>
                                        <td><?= esc($c['fecha']) ?></td>
                                        <td>
                                            <a href="<?= base_url('citas/eliminar/' . $c['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar cita?')">Eliminar</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">No hay citas registradas.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>