<?php
session_start();
require_once 'config/database.php';
require_once 'controllers/UserController.php';
include 'views/header.php';

$controller = new UserController($pdo);

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user = $controller->login($email, $password);
    if ($user) {
        $_SESSION['user'] = $user;
        header('Location: dashboard.php');
        exit;
    } else {
        $message = "Email ou senha incorretos!";
    }
}

include 'views/login.php';
include 'views/footer.php';
