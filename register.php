<?php
require_once 'config/database.php';
require_once 'models/User.php';
include 'views/header.php';

$userModel = new User($pdo);
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($userModel->register($name, $email, $password)) {
        $message = "Cadastro realizado com sucesso! <a href='index.php'>Login aqui</a>";
    } else {
        $message = "Erro ao cadastrar.";
    }
}
?>

<h2>Cadastro</h2>
<form method="POST">
  <div class="mb-3">
    <label>Nome</label>
    <input type="text" name="name" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Email</label>
    <input type="email" name="email" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Senha</label>
    <input type="password" name="password" class="form-control" required>
  </div>
  <button type="submit" class="btn btn-primary">Cadastrar</button>
</form>
<p class="mt-3"><?= $message; ?></p>

<?php include 'views/footer.php'; ?>
