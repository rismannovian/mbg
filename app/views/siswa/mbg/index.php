<?php require_once 'app/views/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="card shadow-sm">

        <!-- HEADER -->
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="bi bi-cup-hot"></i> MBG Hari Ini
            </h4>

            <a href="index.php?url=siswa/riwayat_mbg" class="btn btn-light btn-sm">
                <i class="bi bi-clock-history"></i> Riwayat
            </a>
        </div>

        <div class="card-body">

            <?php if (!empty($mbg)): ?>

                <!-- INFO MBG -->
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Tanggal</label>
                        <div class="form-control bg-light">
                            <?= !empty($mbg['tanggal']) ? date('d-m-Y', strtotime($mbg['tanggal'])) : '-'; ?>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Jumlah MBG</label>
                        <div class="form-control bg-light">
                            <?= $mbg['jml_mbg'] ?? '-'; ?> Paket
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="fw-bold">Status Distribusi</label>
                        <div class="form-control bg-light">

                            <?php if ($mbg['status'] == 'aktif'): ?>
                                <span class="badge bg-success">Aktif</span>
                            <?php elseif ($mbg['status'] == 'ditutup'): ?>
                                <span class="badge bg-danger">Ditutup</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Selesai</span>
                            <?php endif; ?>

                        </div>
                    </div>

                </div>

                <hr>

                <!-- ================= LOGIKA KELAS ================= -->
                <?php if (empty($pesanan_kelas)): ?>

                    <div class="alert alert-info">
                        <strong>Informasi:</strong><br>
                        Belum terdapat pemesanan MBG dari kelas Anda untuk hari ini.
                    </div>

                    <form method="POST" action="index.php?url=prosesmbg/pesan">

                        <div class="mb-3">
                            <label class="fw-bold">Jumlah Pesan</label>

                            <input type="number"
                                name="jml_pesan"
                                class="form-control border-2 border-primary text-center fs-5"
                                min="1"
                                required>

                            <small class="text-muted">
                                Masukkan jumlah paket MBG yang akan dipesan.
                            </small>
                        </div>

                        <button type="submit"
                            class="btn btn-primary"
                            onclick="return confirm('Apakah Anda yakin ingin memesan MBG hari ini?')">

                            <i class="bi bi-cart-check"></i> Pesan Sekarang
                        </button>

                    </form>

                <?php else: ?>

                    <?php
                    $data = $pesanan_kelas;

                    $tanggal_proses = !empty($data['tanggal'])
                        ? date('d-m-Y', strtotime($data['tanggal']))
                        : '-';
                    ?>

                    <!-- INFO PROSES LAMA -->
                    <?php if (!empty($data['tanggal']) && strtotime($data['tanggal']) < strtotime(date('Y-m-d'))): ?>

                        <div class="alert alert-secondary">
                            <strong>Informasi:</strong><br>

                            Terdapat proses MBG dari tanggal
                            <b><?= $tanggal_proses; ?></b>

                            yang belum diselesaikan.
                            Mohon untuk menyelesaikan proses tersebut terlebih dahulu.
                        </div>

                    <?php endif; ?>

                    <!-- INFO PEMESAN -->
                    <div class="alert alert-warning">
                        <strong>Informasi Pemesanan:</strong><br>

                        MBG untuk kelas Anda telah dipesan oleh:
                        <b><?= htmlspecialchars($data['nama']); ?></b>
                    </div>

                    <!-- STATUS -->
                    <?php if ($data['status'] == 'pesan'): ?>

                        <div class="alert alert-warning">
                            <strong>Status:</strong> Menunggu Persetujuan<br>
                            Permintaan MBG sedang dalam proses verifikasi oleh petugas.
                        </div>

                    <?php elseif ($data['status'] == 'disetujui'): ?>

                        <div class="alert alert-info">
                            <strong>Status:</strong> Disetujui<br>
                            MBG telah disetujui. Silakan melakukan pengambilan sesuai prosedur.
                        </div>

                    <?php elseif ($data['status'] == 'kembalikan'): ?>

                        <div class="alert alert-warning">
                            <strong>Status:</strong> Menunggu Verifikasi Pengembalian<br>
                            Pengembalian telah dikirim dan sedang menunggu proses dari petugas.
                        </div>

                    <?php elseif ($data['status'] == 'diproses'): ?>

                        <div class="alert alert-primary">
                            <strong>Status:</strong> Dalam Proses Verifikasi<br>
                            Pengembalian sedang diverifikasi oleh petugas.
                        </div>

                    <?php elseif ($data['status'] == 'selesai'): ?>

                        <div class="alert alert-success">
                            <strong>Status:</strong> Selesai<br>
                            Seluruh proses MBG telah diselesaikan.
                        </div>

                    <?php elseif ($data['status'] == 'ditolak'): ?>

                        <div class="alert alert-danger">
                            <strong>Status:</strong> Ditolak<br>
                            Permintaan MBG tidak dapat diproses.
                        </div>

                    <?php endif; ?>

                    <!-- DETAIL -->
                    <table class="table table-bordered">

                        <tr>
                            <th width="200">Status</th>
                            <td><?= ucfirst($data['status']); ?></td>
                        </tr>

                        <tr>
                            <th>Jumlah Pesan</th>
                            <td><?= $data['jml_pesan']; ?></td>
                        </tr>

                        <tr>
                            <th>Realisasi</th>
                            <td><?= $data['jml_kembali']; ?></td>
                        </tr>

                    </table>

                    <!-- AKSI -->
                    <?php if (!empty($pesanan) && $data['status'] == 'disetujui'): ?>

                        <form method="POST"
                            action="index.php?url=prosesmbg/kirim_kembali/<?= $data['id'] ?>">

                            <button type="submit"
                                class="btn btn-warning"
                                onclick="return confirm('Konfirmasi pengembalian MBG kepada petugas?')">

                                <i class="bi bi-arrow-return-left"></i>
                                Kirim Pengembalian
                            </button>

                        </form>

                    <?php endif; ?>

                <?php endif; ?>

            <?php else: ?>

                <div class="alert alert-warning mb-0">
                    <strong>Informasi:</strong><br>
                    MBG untuk hari ini belum tersedia.
                </div>

            <?php endif; ?>

        </div>
    </div>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>