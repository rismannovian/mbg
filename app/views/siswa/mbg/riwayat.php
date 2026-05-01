<?php require_once 'app/views/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="card shadow-sm">

        <!-- HEADER -->
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="bi bi-clock-history"></i> Riwayat MBG
            </h4>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle">

                    <thead class="table-primary text-center">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jumlah Pesan</th>
                            <th>Realisasi</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($riwayat)): ?>
                            <?php $no = 1; ?>
                            <?php foreach ($riwayat as $row): ?>
                                <tr>

                                    <td class="text-center"><?= $no++; ?></td>

                                    <td class="text-center">
                                        <?= !empty($row['tanggal']) ? date('d-m-Y', strtotime($row['tanggal'])) : '-'; ?>
                                    </td>

                                    <td class="text-center">
                                        <?= $row['jml_pesan'] ?? 0; ?>
                                    </td>

                                    <td class="text-center">
                                        <?= $row['jml_kembali'] ?? 0; ?>
                                    </td>

                                    <td class="text-center">
                                        <?php if ($row['status'] == 'pesan'): ?>
                                            <span class="badge bg-warning text-dark">Pesan</span>

                                        <?php elseif ($row['status'] == 'disetujui'): ?>
                                            <span class="badge bg-info text-dark">Disetujui</span>

                                        <?php elseif ($row['status'] == 'ditolak'): ?>
                                            <span class="badge bg-danger">Ditolak</span>

                                        <?php else: ?>
                                            <span class="badge bg-success">Selesai</span>
                                        <?php endif; ?>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Belum ada data</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>

        </div>
    </div>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>