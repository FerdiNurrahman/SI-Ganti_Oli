<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kendaraan</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: 'Data yang dihapus tidak bisa dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`deleteForm-${id}`).submit();
            }
        });
    }

    function confirmLogout() {
        Swal.fire({
            title: 'Yakin ingin logout?',
            text: 'Anda harus login kembali untuk mengakses data!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Logout!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'index.php?controller=authController&action=logout';
            }
        });
    }
</script>

</head>
<body>
<header>
    <h1>Daftar Kendaraan</h1>
</header>
<div class="container">
    <div class="action-buttons">
        <button class="btn" onclick="confirmLogout()">Logout</button>
        <a class="btn" href="index.php?controller=oliController&action=add">Tambah Kendaraan</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Nama Kendaraan</th>
                <th>KM Sekarang</th>
                <th>KM Ganti Oli Selanjutnya</th>
                <th>Oli Gardan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($vehiclesForList)): ?>
                <?php foreach ($vehiclesForList as $vehicle): ?>
                    <tr>
                        <td><?= htmlspecialchars($vehicle['name']) ?></td>
                        <td><?= $vehicle['last_km'] ?></td>
                        <td><?= $vehicle['next_oli_km'] ?></td>
                        <td><?= $vehicle['gardan_status_display'] ?></td>
                        <td>
                            <form method="POST" action="index.php?controller=oliController&action=updateKM" style="display: inline;">
                                <input type="hidden" name="id" value="<?= $vehicle['id'] ?>">
                                <button type="submit" class="btn">Sudah Ganti Oli</button>
                            </form>
                            <form method="GET" action="index.php" style="display: inline;">
                                <input type="hidden" name="controller" value="oliController">
                                <input type="hidden" name="action" value="editKM">
                                <input type="hidden" name="id" value="<?= $vehicle['id'] ?>">
                                <button type="submit" class="btn">Edit KM</button>
                            </form>
                                <form id="deleteForm-<?= $vehicle['id'] ?>" method="POST" action="index.php?controller=oliController&action=delete" style="display: inline;">
                                    <input type="hidden" name="id" value="<?= $vehicle['id'] ?>">
                                    <button type="button" class="btn btn-danger" onclick="confirmDelete(<?= $vehicle['id'] ?>)">Hapus</button>
                                </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada kendaraan yang terdaftar</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
