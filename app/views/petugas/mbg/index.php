<?php require_once 'app/views/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="card shadow-sm">

        <!-- HEADER -->
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="bi bi-box-seam"></i> Data MBG
            </h4>

            <a href="index.php?url=mbg/tambah" class="btn btn-light btn-sm">
                <i class="bi bi-plus-circle"></i> Tambah
            </a>
        </div>

        <div class="card-body">

            <!-- TABLE -->
  <div class="table-responsive">

    <table class="table table-bordered table-striped table-hover table-sm align-middle"
        id="datatable"
        style="width:100%;">

        <thead class="table-primary text-center">
            <tr>
                <th style="width:40px;">No</th>
                <th style="width:90px;">Tanggal</th>
                <th>Petugas</th>
                <th style="width:85px;">Porsi</th>
                <th style="width:90px;">Status</th>
                <th style="width:110px;">Aksi</th>
            </tr>
        </thead>

                    <tbody>
                        <?php if (!empty($mbg)): ?>
                            <?php $no = 1; ?>
                            <?php foreach ($mbg as $row): ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>

                                    <td class="text-center">
                                        <?= date('d-m-Y', strtotime($row['tanggal'])) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($row['nama'] ?? '-') ?>
                                    </td>

                                    <td class="text-center fw-semibold">
                                        <?= number_format($row['jml_mbg']) ?>
                                    </td>

                          
                                    <td class="text-center">
                                        <?php if ($row['status'] == 'aktif'): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php elseif ($row['status'] == 'ditutup'): ?>
                                            <span class="badge bg-warning text-dark">Ditutup</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Selesai</span>
                                        <?php endif; ?>
                                    </td>

                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">

                                        <!-- DETAIL -->
                                        <a href="index.php?url=mbg/detail/<?= $row['id'] ?>"
                                            class="btn btn-info text-white"
                                            title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <!-- EDIT -->
                                        <a href="index.php?url=mbg/edit/<?= $row['id'] ?>"
                                            class="btn btn-warning"
                                            title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <!-- HAPUS -->
                                        <a href="index.php?url=mbg/hapus/<?= $row['id'] ?>"
                                            class="btn btn-danger"
                                            onclick="return confirm('Yakin ingin menghapus data ini?')"
                                            title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </a>

                                    </div>
                                </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>

        </div>
    </div>
</div>

<!-- MODAL PREVIEW GAMBAR -->
<div class="modal fade" id="modalPreview" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-body text-center">
                <img id="previewImage" src="" class="img-fluid rounded">
            </div>

        </div>
    </div>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>