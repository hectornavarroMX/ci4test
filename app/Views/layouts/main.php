<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->renderSection('title') ?> - Sistema CI4 v4.10</title>

    <!-- Bootstrap Icons (CDN directo para máxima compatibilidad de fuentes en hosting) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap 5 CSS (Local / Fallback) -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <!-- OverlayScrollbars CSS (Local / Fallback) -->
    <link rel="stylesheet" href="<?= base_url('assets/css/overlayscrollbars.min.css') ?>">
    <!-- AdminLTE 4.10.0 CSS (Local / Fallback) -->
    <link rel="stylesheet" href="<?= base_url('assets/css/adminlte.min.css') ?>">

    <?= $this->renderSection('styles') ?>
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
<div class="app-wrapper">

    <!-- Header / Navbar -->
    <?= $this->include('layouts/header') ?>

    <!-- Main Sidebar Container -->
    <?= $this->include('layouts/sidebar') ?>

    <!-- App Main Content -->
    <main class="app-main">
        <!-- Content Header (Page header) -->
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0"><?= $this->renderSection('page_header') ?></h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="<?= site_url('citas') ?>">Inicio</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?= $this->renderSection('breadcrumb') ?></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.app-content-header -->

        <!-- Main content -->
        <div class="app-content">
            <div class="container-fluid">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
        <!-- /.app-content -->
    </main>
    <!-- /.app-main -->

    <!-- Footer -->
    <?= $this->include('layouts/footer') ?>

</div>
<!-- ./app-wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- Bootstrap 5 Bundle (includes Popper) -->
<script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
<!-- OverlayScrollbars JS -->
<script src="<?= base_url('assets/js/overlayscrollbars.browser.es6.min.js') ?>"></script>
<!-- AdminLTE 4.10.0 JS -->
<script src="<?= base_url('assets/js/adminlte.min.js') ?>"></script>

<?= $this->renderSection('scripts') ?>
</body>
</html>
