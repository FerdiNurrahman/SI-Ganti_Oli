<?php
require_once './core/database.php';

class oliModel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function getAllVehicles($userId) {
        $query = "SELECT * FROM vehicles WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addVehicle($data) {
        $query = "INSERT INTO vehicles (user_id, name, interval_oli, need_gardan, gardan_ratio, last_km, last_gardan_km)
                  VALUES (:user_id, :name, :interval_oli, :need_gardan, :gardan_ratio, :last_km, :last_gardan_km)";
        $stmt = $this->db->prepare($query);
    
        try {
            $stmt->execute($data);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage(); // Debug error
            print_r($data); // Debug data yang dikirim
            die();
        }
    }
    
    

    public function updateOliKM($id, $newLastKM) {
        $query = "UPDATE vehicles SET last_km = :last_km WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':last_km', $newLastKM);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
    
    public function updateGardanKM($id, $newLastGardanKM) {
        $query = "UPDATE vehicles SET last_gardan_km = :last_gardan_km WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':last_gardan_km', $newLastGardanKM);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
    
    public function getAllVehiclesByUser($userId) {
        $query = "SELECT * FROM vehicles WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>
