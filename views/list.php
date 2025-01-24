<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kendaraan</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header>
    <h1>Daftar Kendaraan</h1>
</header>
<div class="container">
    <a href="index.php?controller=authController&action=logout" class="btn">Logout</a>
    <a class="btn" href="index.php?controller=oliController&action=add">Tambah Kendaraan</a>
    <table class="table">
        <thead>
            <tr>
                <th>Nama Kendaraan</th>
                <th>KM Ganti Oli Selanjutnya</th>
                <th>Oli Gardan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($uniqueVehicles as $vehicle): ?>
            <tr>
                <td><?= htmlspecialchars($vehicle['name']) ?></td>
                <td><?= $vehicle['next_oli_km'] ?></td>
                <td><?= $vehicle['gardan_status'] ?></td>
                <td>
                    <form method="POST" action="index.php?controller=oliController&action=updateKM" style="display: inline;">
                        <input type="hidden" name="id" value="<?= $vehicle['id'] ?>">
                        <button type="submit" class="btn">Sudah Ganti Oli</button>
                    </form>
                    <a class="btn" href="index.php?controller=oliController&action=viewLog&id=<?= $vehicle['id'] ?>">Lihat Log</a>
                    <form method="GET" action="index.php" style="display: inline;">
                        <input type="hidden" name="controller" value="oliController">
                        <input type="hidden" name="action" value="editKM">
                        <input type="hidden" name="id" value="<?= $vehicle['id'] ?>">
                        <button type="submit" class="btn">Edit KM</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
