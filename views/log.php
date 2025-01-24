<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Kendaraan</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header>
    <h1>Log Kendaraan</h1>
</header>
<div class="container">
    <a class="btn" href="index.php?controller=oliController&action=list">Kembali ke Daftar Kendaraan</a>
    <table class="table">
        <thead>
            <tr>
                <th>Nama Kendaraan</th>
                <th>KM Terakhir</th>
                <th>Status Gardan</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($vehiclesForLog)): ?>
                <?php foreach ($vehiclesForLog as $log): ?>
                <tr>
                    <td><?= htmlspecialchars($log['name']) ?></td>
                    <td><?= $log['last_km'] ?></td>
                    <td><?= $log['status_gardan'] ? 'Sudah' : 'Belum' ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" style="text-align: center;">Tidak ada log tersedia</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
