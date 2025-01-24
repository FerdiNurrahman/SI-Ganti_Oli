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

    public function getVehiclesForList($userId) {
        $query = "SELECT * FROM vehicles WHERE user_id = :user_id AND status_oli = 0";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getVehiclesForLog($userId) {
        $query = "SELECT * FROM vehicles WHERE user_id = :user_id AND status_oli = 1 ORDER BY last_km DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addVehicle($data) {
        $query = "INSERT INTO vehicles (user_id, name, interval_oli, need_gardan, gardan_ratio, last_km, status_oli, status_gardan)
                  VALUES (:user_id, :name, :interval_oli, :need_gardan, :gardan_ratio, :last_km, :status_oli, :status_gardan)";
        $stmt = $this->db->prepare($query);
        $stmt->execute($data);
    }
    
    public function updateOliKM($id, $lastKM, $statusOli) {
        $query = "UPDATE vehicles SET last_km = :last_km, status_oli = :status_oli WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':last_km', $lastKM, PDO::PARAM_INT);
        $stmt->bindParam(':status_oli', $statusOli, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
    
    public function updateGardanStatus($id, $statusGardan) {
        $query = "UPDATE vehicles SET status_gardan = :status_gardan WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':status_gardan', $statusGardan, PDO::PARAM_INT);
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

    public function updateOliAndGardan($id, $newLastKM, $statusOli, $statusGardan) {
        $query = "UPDATE vehicles SET last_km = :last_km, status_oli = :status_oli, status_gardan = :status_gardan WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':last_km', $newLastKM, PDO::PARAM_INT);
        $stmt->bindParam(':status_oli', $statusOli, PDO::PARAM_INT);
        $stmt->bindParam(':status_gardan', $statusGardan, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
    public function getVehicleCountByUser($userId) {
        $query = "SELECT COUNT(*) AS count FROM vehicles WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }

    public function getVehiclesByUserAndName($userId, $name) {
        $query = "SELECT * FROM vehicles WHERE user_id = :user_id AND name = :name ORDER BY id ASC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function deleteVehicle($id) {
        $query = "DELETE FROM vehicles WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
    
}
?>
