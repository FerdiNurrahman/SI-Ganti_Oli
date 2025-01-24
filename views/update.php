<form method="POST" action="index.php?controller=oliController&action=editKM">
    <input type="hidden" name="id" value="<?= $vehicle['id'] ?>">
    <label for="last_km">KM Sekarang</label>
    <input type="number" id="last_km" name="last_km" value="<?= $vehicle['last_km'] ?>" required>
    <button type="submit" class="btn">Update</button>
</form>
