<?php
require_once './models/oliModel.php';

class oliController {
    public function __construct() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=authController&action=login');
            exit();
        }
    }

    public function home() {
        require './views/home.php';
    }
    public function list() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=authController&action=login');
            exit();
        }
    
        $userId = $_SESSION['user_id']; // Ambil user_id dari session
        $model = new oliModel();
        $vehicles = $model->getAllVehiclesByUser($userId);
    
        // Filter data agar hanya nama kendaraan unik yang ditampilkan
        $uniqueVehicles = [];
        $uniqueNames = [];
        foreach ($vehicles as $vehicle) {
            if (!in_array($vehicle['name'], $uniqueNames)) {
                $uniqueVehicles[] = $vehicle;
                $uniqueNames[] = $vehicle['name'];
            }
        }
    
        // Hitung data tambahan untuk kendaraan
        foreach ($uniqueVehicles as &$vehicle) {
            $vehicle['next_oli_km'] = $vehicle['last_km'] + $vehicle['interval_oli'];
    
            if ($vehicle['need_gardan']) {
                $nextGardanKM = $vehicle['last_gardan_km'] + ($vehicle['interval_oli'] * $vehicle['gardan_ratio']);
                $vehicle['gardan_status'] = ($nextGardanKM <= $vehicle['last_km']) ? 'Ya' : 'Tidak';
            } else {
                $vehicle['gardan_status'] = 'Tidak';
            }
        }
    
        require './views/list.php';
    }
    

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $needGardan = $_POST['need_gardan'];
            $gardanRatio = ($needGardan == 1) ? $_POST['gardan_ratio'] : null;
            $gardanNow = ($needGardan == 1) ? $_POST['gardan_now'] : null;
    
            // Logika untuk menentukan jadwal oli gardan berikutnya
            $lastGardanKM = null;
            if ($needGardan == 1 && $gardanNow == 1) {
                $lastGardanKM = $_POST['last_km'];
            }
    
            // Simpan data ke database
            $data = [
                'user_id' => 1, // Contoh user_id
                'name' => $_POST['name'],
                'interval_oli' => $_POST['interval_oli'],
                'need_gardan' => $needGardan,
                'gardan_ratio' => $gardanRatio,
                'last_km' => $_POST['last_km'],
                'last_gardan_km' => $lastGardanKM
            ];
    
            $model = new oliModel();
            $model->addVehicle($data);
            header('Location: index.php?controller=oliController&action=list');
        } else {
            require './views/add.php';
        }
    }
    

    public function updateKM() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
    
            $model = new oliModel();
            $vehicle = $model->getVehicleById($id);
    
            // Update last_km
            $newLastKM = $vehicle['last_km'] + $vehicle['interval_oli'];
            $model->updateOliKM($id, $newLastKM);
    
            // Update last_gardan_km jika perlu oli gardan
            if ($vehicle['need_gardan']) {
                $nextGardanKM = $vehicle['last_gardan_km'] + ($vehicle['interval_oli'] * $vehicle['gardan_ratio']);
                if ($nextGardanKM <= $newLastKM) {
                    $model->updateGardanKM($id, $newLastKM);
                }
            }
    
            header('Location: index.php?controller=oliController&action=list');
        }
    }
    
    
    public function editKM() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $newLastKM = $_POST['last_km'];
    
            $model = new oliModel();
            $model->updateOliKM($id, $newLastKM);
    
            header('Location: index.php?controller=oliController&action=list');
        } else {
            $id = $_GET['id'];
            $model = new oliModel();
            $vehicle = $model->getVehicleById($id);
            require './views/edit.php';
        }
    }
    
    
    
}
?>
