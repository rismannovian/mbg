<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard - Aplikasi MBG</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            background: #f4f6f9;
            overflow-x: hidden;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
            align-items: stretch;
        }

        /* SIDEBAR */
        .sidebar {
            width: 250px;
            min-width: 250px;
            background: linear-gradient(180deg, #4f65d6, #3c52c7);
            color: white;
            display: flex;
            flex-direction: column;
            padding: 1rem;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 15px;
            border-radius: 8px;
            color: white;
            text-decoration: none;
            margin-bottom: 6px;
            transition: 0.2s;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.15);
            color: white;
        }

        .menu-item.active {
            background: white;
            color: #3c52c7;
            font-weight: 600;
        }

        /* MAIN */
        .main-content {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            background: white;
            border-bottom: 1px solid #dee2e6;
        }

        .content {
            padding: 20px;
            overflow-x: auto;
            flex: 1;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* MOBILE */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: -250px;
                height: 100vh;
                z-index: 1030;
                transition: 0.3s;
            }

            .sidebar.show {
                left: 0;
            }

            .sidebar-backdrop {
                display: none;
            }

            .sidebar-backdrop.active {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1020;
            }
        }
    </style>
</head>

<body>

<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index.php?url=auth');
    exit;
}

$user = $_SESSION['user'];
?>

<div class="sidebar-backdrop" id="sidebarBackdrop"></div>

<div class="wrapper">

 <!-- SIDEBAR -->
<div class="sidebar" id="sidebar">

    <div class="text-center mb-4">
        <i class="bi bi-egg-fried fs-1"></i>
        <h5 class="mt-2 mb-0">Aplikasi MBG</h5>
        <small><?= $user['role']; ?></small>
    </div>

    <?php if ($user['role'] === 'admin') : ?>

        <a href="index.php?url=admin/dashboard" class="menu-item active">
            <i class="bi bi-house-door"></i> Dashboard
        </a>

        <a href="index.php?url=admin/admin" class="menu-item">
            <i class="bi bi-person-badge"></i> Admin
        </a>

        <a href="index.php?url=admin/siswa" class="menu-item">
            <i class="bi bi-people"></i> Siswa
        </a>

        <a href="index.php?url=admin/kelas" class="menu-item">
            <i class="bi bi-building"></i> Kelas
        </a>

        <a href="index.php?url=admin/petugas" class="menu-item">
            <i class="bi bi-person-lines-fill"></i> Petugas
        </a>

        <a href="index.php?url=mbg/index" class="menu-item">
            <i class="bi bi-box-seam"></i> Data MBG
        </a>

        <a href="index.php?url=prosesmbg/index" class="menu-item">
            <i class="bi bi-list-check"></i> Proses MBG
        </a>


    <?php elseif ($user['role'] === 'petugas') : ?>

        <a href="index.php?url=petugas/dashboard" class="menu-item">
            <i class="bi bi-house-door"></i> Dashboard
        </a>

        <a href="index.php?url=mbg/index" class="menu-item">
            <i class="bi bi-box-seam"></i> Data MBG
        </a>

        <a href="index.php?url=prosesmbg/index" class="menu-item">
            <i class="bi bi-list-check"></i> Proses MBG
        </a>


    <?php elseif ($user['role'] === 'siswa') : ?>

        <a href="index.php?url=siswa/dashboard" class="menu-item">
            <i class="bi bi-house-door"></i> Dashboard
        </a>

        <a href="index.php?url=siswa/mbg" class="menu-item">
            <i class="bi bi-cup-hot"></i> MBG Hari Ini
        </a>

        <a href="index.php?url=siswa/riwayat_mbg" class="menu-item">
            <i class="bi bi-clock-history"></i> Riwayat MBG
        </a>

    <?php endif; ?>

    <div class="mt-auto text-center pt-4">
        <small>
            Login sebagai <br>
            <strong><?= $user['nama']; ?></strong>
        </small>
    </div>

</div>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <!-- TOPBAR -->
        <nav class="navbar topbar px-4">
            <div class="container-fluid">

                <div class="d-flex align-items-center">
                    <button class="btn btn-outline-primary d-md-none me-2" id="toggleSidebar">
                        <i class="bi bi-list"></i>
                    </button>

                    <span class="navbar-text fw-bold text-uppercase text-primary">
                        SMAN 1 CIGOMBONG
                    </span>
                </div>

                <a href="index.php?url=auth/logout" class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>

            </div>
        </nav>

        <!-- CONTENT -->
        <div class="content">