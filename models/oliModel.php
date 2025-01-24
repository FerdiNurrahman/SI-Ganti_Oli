<?php
require_once './core/database.php';

class oliModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function getAllVehiclesByUser($userId) {
        $query = "SELECT * FROM vehicles WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addVehicle($data) {
        $query = "INSERT INTO vehicles (user_id, name, interval_oli, need_gardan, gardan_ratio, last_km, last_gardan_km)
                  VALUES (:user_id, :name, :interval_oli, :need_gardan, :gardan_ratio, :last_km, :last_gardan_km)";
        $stmt = $this->db->prepare($query);
        $stmt->execute($data);
    }

    public function updateOliKM($id, $newLastKM) {
        $query = "UPDATE vehicles SET last_km = :last_km WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':last_km', $newLastKM, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function updateGardanKM($id, $newLastGardanKM) {
        $query = "UPDATE vehicles SET last_gardan_km = :last_gardan_km WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':last_gardan_km', $newLastGardanKM, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getVehicleById($id) {
        $query = "SELECT * FROM vehicles WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function saveLog($vehicleId, $userId, $lastKM, $lastGardanKM) {
        $query = "INSERT INTO vehicle_log (vehicle_id, user_id, last_km, last_gardan_km)
                  VALUES (:vehicle_id, :user_id, :last_km, :last_gardan_km)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':vehicle_id', $vehicleId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':last_km', $lastKM, PDO::PARAM_INT);
        $stmt->bindParam(':last_gardan_km', $lastGardanKM, PDO::PARAM_INT);
        $stmt->execute();
    }
   
    public function getLogsByVehicleId($vehicleId) {
        $query = "SELECT * FROM vehicle_log WHERE vehicle_id = :vehicle_id ORDER BY date DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':vehicle_id', $vehicleId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

}
?>
