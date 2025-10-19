<?php
require_once __DIR__ . '/../models/User.php';

class UserController {
    private $userModel;

    public function __construct($pdo) {
        $this->userModel = new User($pdo);
    }

    public function register($name, $email, $password) {
        return $this->userModel->register($name, $email, $password);
    }

    public function login($email, $password) {
        return $this->userModel->login($email, $password);
    }
}
?>
