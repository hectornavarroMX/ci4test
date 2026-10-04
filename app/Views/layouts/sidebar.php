<?php
$uri = service('uri');
$currentSegment = $uri->getSegment(1) ?? '';
?>
<!-- App Sidebar -->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!-- Brand Link -->
    <div class="sidebar-brand">
        <a href="<?= site_url('citas') ?>" class="brand-link">
            <i class="bi bi-hospital fs-3 me-2 text-info"></i>
            <span class="brand-text font-weight-light">CI4 System v4</span>
        </a>
    </div>

    <!-- Sidebar Wrapper -->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                
                <li class="nav-header">MÓDULOS DEL SISTEMA</li>

                <!-- Módulo Citas -->
                <li class="nav-item">
                    <a href="<?= site_url('citas') ?>" class="nav-link <?= ($currentSegment == 'citas' || $currentSegment == '') ? 'active' : '' ?>">
                        <i class="nav-icon bi bi-calendar-event"></i>
                        <p>Control de Citas</p>
                    </a>
                </li>

                <!-- Futuros Módulos -->
                <li class="nav-header">FUTUROS MÓDULOS</li>

                <li class="nav-item">
                    <a href="#" class="nav-link disabled text-secondary">
                        <i class="nav-icon bi bi-people"></i>
                        <p>Pacientes <span class="badge text-bg-info float-end">Próximamente</span></p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link disabled text-secondary">
                        <i class="nav-icon bi bi-person-badge"></i>
                        <p>Médicos <span class="badge text-bg-info float-end">Próximamente</span></p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link disabled text-secondary">
                        <i class="nav-icon bi bi-gear"></i>
                        <p>Configuración <span class="badge text-bg-info float-end">Próximamente</span></p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
    <!-- /.sidebar-wrapper -->
</aside>
<!-- /.app-sidebar -->
