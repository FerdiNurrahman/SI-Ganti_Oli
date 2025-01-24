<?php
require_once './models/oliModel.php';

class oliController {
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=authController&action=login');
            exit();
        }
    }

    public function home() {
        require './views/home.php';
    }

    
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $needGardan = $_POST['need_gardan'];
            $gardanRatio = ($needGardan == 1) ? $_POST['gardan_ratio'] : null;
            $gardanNow = ($needGardan == 1) ? $_POST['gardan_now'] : null;
            
            $statusGardan = 0;
            if ($needGardan == 1 && $gardanNow == 1) {
                $statusGardan = 1;
            }
            
            $data = [
                'user_id' => $_SESSION['user_id'],
                'name' => $_POST['name'],
                'interval_oli' => $_POST['interval_oli'],
                'need_gardan' => $needGardan,
                'gardan_ratio' => $gardanRatio,
                'last_km' => $_POST['last_km'],
                'status_oli' => 0,
                'status_gardan' => $statusGardan
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
    
            $newLastKM = $vehicle['last_km'] + $vehicle['interval_oli'];
            $model->updateOliKM($id, $vehicle['last_km'], 1); // Update status_oli menjadi 1 untuk data lama
    
            $userVehicles = $model->getVehiclesByUserAndName($vehicle['user_id'], $vehicle['name']);
            $totalVehicles = count($userVehicles);
    
            $gardanRatio = $vehicle['gardan_ratio'];
            $newStatusGardan = 0;
    
            if ($vehicle['need_gardan']) {
                $newIndex = $totalVehicles % $gardanRatio;
                $newStatusGardan = ($newIndex === 0) ? 1 : 0;
            }
    
            $newData = [
                'user_id' => $vehicle['user_id'],
                'name' => $vehicle['name'],
                'interval_oli' => $vehicle['interval_oli'],
                'need_gardan' => $vehicle['need_gardan'],
                'gardan_ratio' => $vehicle['gardan_ratio'],
                'last_km' => $newLastKM,
                'status_oli' => 0,
                'status_gardan' => $newStatusGardan
            ];
    
            $model->addVehicle($newData);
    
            header('Location: index.php?controller=oliController&action=list');
        }
    }
    
    
    public function list() {
        $userId = $_SESSION['user_id'];
        $model = new oliModel();
        $vehiclesForList = $model->getVehiclesForList($userId);
    
        foreach ($vehiclesForList as &$vehicle) {
            $vehicle['next_oli_km'] = $vehicle['last_km'] + $vehicle['interval_oli'];
            $vehicle['gardan_status_display'] = $vehicle['status_gardan'] ? 'Saatnya Ganti' : 'Belum Saatnya';
        }
    
        require './views/list.php';
    }
    
    public function viewLog() {
        $id = $_GET['id'];
        $model = new oliModel();
        $logs = $model->getVehiclesForLogByVehicleId($id);
        require './views/log.php';
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

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $model = new oliModel();
            $model->deleteVehicle($id);
            header('Location: index.php?controller=oliController&action=list');
        }
    }
}
?>
