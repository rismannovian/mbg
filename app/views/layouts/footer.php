        </div> <!-- End of .content -->
    </div> <!-- End of .flex-grow-1 -->
</div> <!-- End of .d-flex -->

<style>
    footer {
        background-color: #f8f9fa;
        border-top: 1px solid #dee2e6;
    }
</style>

<!-- Footer -->
<footer class="text-center py-3 text-muted small">
    Created by <strong>RN</strong> &copy; <?= date('Y'); ?>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    // ===============================
    // Sidebar Mobile Toggle
    // ===============================
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.querySelector('.sidebar');
    const backdrop = document.getElementById('sidebarBackdrop');

    if (toggleBtn && sidebar && backdrop) {
        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('show');
            backdrop.classList.toggle('active');
        });

        backdrop.addEventListener('click', function () {
            sidebar.classList.remove('show');
            backdrop.classList.remove('active');
        });
    }

    // ===============================
    // Select2
    // ===============================
    if ($('.select2').length) {
        $('.select2').select2({
            placeholder: "-- Pilih Siswa --",
            allowClear: true,
            width: '100%'
        });
    }

    // ===============================
    // DataTables
    // ===============================
    if ($('#datatable').length) {
        $('#datatable').DataTable({
            responsive: true,
            autoWidth: false,
            pageLength: 10,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                zeroRecords: "Data tidak ditemukan",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                infoEmpty: "Data kosong",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "›",
                    previous: "‹"
                }
            }
        });
    }

});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll('.btn-preview');
    const img = document.getElementById('previewImage');

    buttons.forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();

            const src = this.getAttribute('data-img');
            img.src = src;

            const modal = new bootstrap.Modal(document.getElementById('modalPreview'));
            modal.show();
        });
    });
});
</script>

</body>
</html>