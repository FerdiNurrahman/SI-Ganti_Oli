<?php
require_once './models/authModel.php';

class authController {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            $authModel = new authModel();
            $user = $authModel->getUserByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header('Location: index.php?controller=oliController&action=home');
            } else {
                $error = "Username atau password salah.";
            }
        }
        require './views/login.php';
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

            $authModel = new authModel();
            if ($authModel->registerUser($username, $password)) {
                header('Location: index.php?controller=authController&action=login');
            } else {
                $error = "Gagal mendaftarkan akun. Username mungkin sudah terpakai.";
            }
        }
        require './views/register.php';
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: index.php?controller=authController&action=login');
    }
}
?>
