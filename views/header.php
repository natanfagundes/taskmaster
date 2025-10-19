<?php
#session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>TaskMaster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php">TaskMaster</a>
    <?php if(isset($_SESSION['user'])): ?>
      <span class="navbar-text text-light">Olá, <?= $_SESSION['user']['name']; ?></span>
      <a href="logout.php" class="btn btn-danger ms-3">Sair</a>
    <?php endif; ?>
  </div>
</nav>
<div class="container">
