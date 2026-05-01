<?php require_once 'app/views/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="card shadow-sm border-0">

        <!-- HEADER -->
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="bi bi-list-check"></i> Proses MBG Siswa
            </h4>
            <small>Daftar antrian berdasarkan urutan siswa melakukan pemesanan</small>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle mb-0"
                    style="min-width:1100px;">

                    <thead class="table-primary text-center">
                        <tr>
                            <th width="60">No</th>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th width="80">Pesan</th>
                            <th width="90">Realisasi</th>
                            <th width="170">Status</th>
                            <th>Petugas Ambil</th>
                            <th>Petugas Kembali</th>
                            <th width="320">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($proses)): ?>
                            <?php $no = 1; ?>
                            <?php foreach ($proses as $row): ?>
                                <tr>

                                    <!-- NOMOR / URUTAN ANTRIAN -->
                                    <td class="text-center fw-bold">
                                        <?= $no++; ?>
                                    </td>

                                    <!-- DATA -->
                                    <td class="text-center">
                                        <?= date('d-m-Y', strtotime($row['tanggal'])); ?>
                                    </td>

                                    <td><?= htmlspecialchars($row['nama']); ?></td>

                                    <td class="text-center">
                                        <?= htmlspecialchars($row['nama_kelas']); ?>
                                    </td>

                                    <td class="text-center fw-bold">
                                        <?= $row['jml_pesan']; ?>
                                    </td>

                                    <td class="text-center fw-bold">
                                        <?= $row['jml_kembali'] ?? 0; ?>
                                    </td>

                                    <!-- STATUS -->
                                   <td class="text-center">
                                        <?php if ($row['status'] == 'pesan'): ?>
                                            <span class="badge bg-warning text-dark">Menunggu Persetujuan</span>

                                        <?php elseif ($row['status'] == 'disetujui'): ?>
                                            <span class="badge bg-info text-dark">Disetujui</span>

                                        <?php elseif ($row['status'] == 'ditolak'): ?>
                                            <span class="badge bg-danger">Ditolak</span>

                                        <?php elseif ($row['status'] == 'kembalikan'): ?>
                                            <span class="badge bg-secondary">Menunggu Pengembalian</span>

                                        <?php elseif ($row['status'] == 'diproses'): ?>
                                            <span class="badge bg-primary">Dalam Proses</span>

                                        <?php elseif ($row['status'] == 'selesai'): ?>
                                            <span class="badge bg-success">Selesai</span>

                                        <?php else: ?>
                                            <span class="badge bg-dark">Tidak Diketahui</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- PETUGAS -->
                                    <td><?= $row['petugas_pengambilan'] ?? '-' ?></td>
                                    <td><?= $row['petugas_pengembalian'] ?? '-' ?></td>

                                    <!-- AKSI -->
                                    <td class="text-center">
                                        <div class="d-flex flex-wrap gap-1 justify-content-center">

                                            <?php if ($row['status'] == 'pesan'): ?>

                                                <a href="index.php?url=prosesmbg/approve/<?= $row['id']; ?>"
                                                    class="btn btn-success btn-sm">
                                                    <i class="bi bi-check-circle"></i> Approve
                                                </a>

                                                <a href="index.php?url=prosesmbg/tolak/<?= $row['id']; ?>"
                                                    class="btn btn-danger btn-sm">
                                                    <i class="bi bi-x-circle"></i> Tolak
                                                </a>

                                            <?php endif; ?>

                                            <?php if ($row['status'] == 'disetujui'): ?>

                                                <span class="badge bg-secondary p-2">
                                                    Menunggu Pengembalian
                                                </span>

                                            <?php endif; ?>

                                            <?php if ($row['status'] == 'kembalikan'): ?>

                                                <a href="index.php?url=prosesmbg/proses/<?= $row['id']; ?>"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="bi bi-arrow-repeat"></i> Proses
                                                </a>

                                            <?php endif; ?>

                                            <?php if ($row['status'] == 'diproses'): ?>

                                                <a href="index.php?url=prosesmbg/selesai/<?= $row['id']; ?>"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="bi bi-check2-square"></i> Selesai
                                                </a>

                                            <?php endif; ?>

                                            <a href="index.php?url=prosesmbg/hapus/<?= $row['id']; ?>"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin hapus data ini?')">
                                                <i class="bi bi-trash"></i>
                                            </a>

                                        </div>
                                    </td>

                                </tr>
                            <?php endforeach; ?>

                        <?php else: ?>
                            <tr>
                                <td colspan="10" class="text-center text-muted">
                                    Tidak ada data antrian.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>

        </div>
    </div>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>