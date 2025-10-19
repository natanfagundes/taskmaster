<?php
session_start(); // sempre primeiro

require_once 'config/database.php';
require_once 'models/User.php';

$message = '';

// Se já estiver logado, redireciona para dashboard
if(isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $userModel = new User($pdo);
    $user = $userModel->login($email, $password); // busca usuário pelo email

    if ($user) {
        $_SESSION['user'] = $user; // salva na sessão
        header('Location: dashboard.php');
        exit;
    } else {
        $message = "Email ou senha incorretos!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login - TaskMaster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5" style="max-width: 400px;">
    <h2 class="mb-4 text-center">Login</h2>

    <?php if($message): ?>
        <div class="alert alert-danger"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Senha" required>
        </div>
        <button type="submit" name="login" class="btn btn-primary w-100">Entrar</button>
    </form>

    <p class="mt-3 text-center">
        Não tem uma conta? 
        <a href="register.php" class="btn btn-sm btn-secondary">Registrar</a>
    </p>
</div>
</body>
</html>
