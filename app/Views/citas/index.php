<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Control de Citas<?= $this->endSection() ?>

<?= $this->section('page_header') ?>Control de Citas<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>Citas<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row g-4">
    <!-- Formulario Agendar Cita -->
    <div class="col-md-4">
        <div class="card card-primary card-outline shadow-sm">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-plus-circle me-1 text-primary"></i> Agendar Cita
                </h5>
            </div>
            <form action="<?= site_url('citas/guardar') ?>" method="post">
                <?= csrf_field() ?>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="paciente" class="form-label"><i class="bi bi-person me-1 text-secondary"></i> Paciente:</label>
                        <input type="text" id="paciente" name="paciente" class="form-control" placeholder="Nombre completo" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label"><i class="bi bi-telephone me-1 text-secondary"></i> Teléfono:</label>
                        <input type="text" id="telefono" name="telefono" class="form-control" placeholder="Número de teléfono" required>
                    </div>
                    <div class="mb-3">
                        <label for="motivo" class="form-label"><i class="bi bi-journal-medical me-1 text-secondary"></i> Motivo:</label>
                        <input type="text" id="motivo" name="motivo" class="form-control" placeholder="Motivo de la consulta" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha" class="form-label"><i class="bi bi-calendar-date me-1 text-secondary"></i> Fecha:</label>
                        <input type="date" id="fecha" name="fecha" class="form-control" required>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-save me-1"></i> Guardar Cita
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Listado de Citas -->
    <div class="col-md-8">
        <div class="card card-dark card-outline shadow-sm">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-list-stars me-1 text-primary"></i> Listado de Citas
                </h5>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Paciente</th>
                            <th>Teléfono</th>
                            <th>Motivo</th>
                            <th>Fecha</th>
                            <th class="text-center" style="width: 100px;">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($citas)): ?>
                            <?php foreach ($citas as $c): ?>
                                <tr>
                                    <td class="fw-bold"><?= esc($c['paciente']) ?></td>
                                    <td><?= esc($c['telefono']) ?></td>
                                    <td><?= esc($c['motivo']) ?></td>
                                    <td>
                                        <span class="badge text-bg-info p-2">
                                            <i class="bi bi-calendar-event me-1"></i><?= esc($c['fecha']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= site_url('citas/eliminar/' . $c['id']) ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('¿Está seguro de eliminar esta cita?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted p-4">
                                    <i class="bi bi-info-circle fs-2 d-block mb-2 text-secondary"></i>
                                    No hay citas registradas en el sistema.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>