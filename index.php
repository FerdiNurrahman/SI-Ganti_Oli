<?php
// Include file core dan controllers
require_once './core/database.php';

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'oliController';
$action = isset($_GET['action']) ? $_GET['action'] : 'list';

$controllerFile = "./controllers/$controller.php";
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    if (class_exists($controller)) {
        $controllerInstance = new $controller();
        if (method_exists($controllerInstance, $action)) {
            $controllerInstance->$action();
        } else {
            die("Error: Action '$action' tidak ditemukan di controller '$controller'.");
        }
    } else {
        die("Error: Class '$controller' tidak ditemukan.");
    }
} else {
    die("Error: File controller '$controllerFile' tidak ditemukan.");
}
?>
