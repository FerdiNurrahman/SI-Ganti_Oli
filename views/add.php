<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kendaraan</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script>
        function toggleGardanOptions() {
            const needGardan = document.getElementById("need_gardan").value;
            const gardanOptions = document.getElementById("gardan_options");
            const gardanRatio = document.getElementById("gardan_ratio");
            const gardanNow = document.getElementById("gardan_now");

            if (needGardan === "1") {
                gardanOptions.style.display = "block";
                gardanRatio.setAttribute("required", "required");
                gardanNow.setAttribute("required", "required");
            } else {
                gardanOptions.style.display = "none";
                gardanRatio.removeAttribute("required");
                gardanNow.removeAttribute("required");
                gardanRatio.value = "";
                gardanNow.value = "";
            }
        }
    </script>
</head>
<body>
<header>
    <h1>Tambah Kendaraan</h1>
</header>
<div class="container">
    <form method="POST" action="index.php?controller=oliController&action=add">
        <label for="name">Nama Kendaraan</label>
        <input type="text" id="name" name="name" required>
        
        <label for="interval_oli">Interval Oli (KM)</label>
        <input type="number" id="interval_oli" name="interval_oli" required>
        
        <label for="need_gardan">Perlu Oli Gardan?</label>
        <select id="need_gardan" name="need_gardan" onchange="toggleGardanOptions()" required>
            <option value="">Pilih</option>
            <option value="1">Ya</option>
            <option value="0">Tidak</option>
        </select>

        <div id="gardan_options" style="display: none;">
            <label for="gardan_ratio">Rasio Oli Gardan</label>
            <select id="gardan_ratio" name="gardan_ratio">
                <option value="">Pilih</option>
                <option value="2">2x Oli Mesin</option>
                <option value="3">3x Oli Mesin</option>
                <option value="4">4x Oli Mesin</option>
            </select>

            <label for="gardan_now">Apakah Oli Gardan Sudah Diganti?</label>
            <select id="gardan_now" name="gardan_now">
                <option value="">Pilih</option>
                <option value="1">Sudah</option>
                <option value="0">Belum</option>
            </select>
        </div>
        
        <label for="last_km">KM Sekarang</label>
        <input type="number" id="last_km" name="last_km" required>
        
        <button type="submit">Simpan</button>
    </form>
</div>
</body>
</html>
