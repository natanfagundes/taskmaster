<?php
session_start();
if(!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

require_once 'config/database.php';
require_once 'models/Task.php';
include 'views/header.php';

// Instancia do Model
$taskModel = new Task($pdo);
$user_id = $_SESSION['user']['id'];

// Adicionar tarefa
if(isset($_POST['add_task'])) {
    $taskModel->addTask($user_id, $_POST['title'], $_POST['description']);
    header("Location: dashboard.php");
    exit;
}

// Atualizar progresso
if(isset($_POST['update_progress'])) {
    $taskModel->updateProgress($_POST['task_id'], $_POST['progress']);
    header("Location: dashboard.php");
    exit;
}

// Toggle status
if(isset($_GET['toggle'])) {
    $task = $taskModel->getTasks($user_id);
    foreach($task as $t) {
        if($t['id'] == $_GET['toggle']) {
            $status = $t['status'] === 'pending' ? 'done' : 'pending';
            $taskModel->updateTask($t['id'], $t['title'], $t['description'], $status);
        }
    }
    header("Location: dashboard.php");
    exit;
}

// Deletar tarefa
if(isset($_GET['delete'])) {
    $taskModel->deleteTask($_GET['delete']);
    header("Location: dashboard.php");
    exit;
}

// Buscar tarefas
$tasks = $taskModel->getTasks($user_id);

// Média de progresso
$total = count($tasks);
$totalProgress = 0;
foreach($tasks as $t) {
    $totalProgress += $t['progress'];
}
$averageProgress = $total > 0 ? round($totalProgress / $total, 1) : 0;
?>

<h2>Dashboard</h2>

<!-- Formulário para adicionar tarefa -->
<form method="POST" class="mb-4">
  <div class="mb-3">
    <input type="text" name="title" class="form-control" placeholder="Título da tarefa" required>
  </div>
  <div class="mb-3">
    <textarea name="description" class="form-control" placeholder="Descrição"></textarea>
  </div>
  <button type="submit" name="add_task" class="btn btn-success">Adicionar Tarefa</button>
</form>

<!-- Tabela de tarefas -->
<h3>Tarefas</h3>
<table class="table table-striped">
  <thead>
    <tr>
      <th>Título</th>
      <th>Descrição</th>
      <th>Status</th>
      <th>Progresso</th>
      <th>Ações</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($tasks as $task): ?>
    <tr>
      <td><?= htmlspecialchars($task['title']); ?></td>
      <td><?= htmlspecialchars($task['description']); ?></td>
      <td>
        <?= $task['status'] === 'done' 
            ? '<span class="badge bg-success">Concluída</span>' 
            : '<span class="badge bg-warning text-dark">Pendente</span>'; ?>
      </td>
      <td>
        <div class="progress">
          <div class="progress-bar <?= $task['progress'] == 100 ? 'bg-success' : 'bg-info' ?>" 
               role="progressbar" 
               style="width: <?= $task['progress'] ?>%;" 
               aria-valuenow="<?= $task['progress'] ?>" 
               aria-valuemin="0" 
               aria-valuemax="100">
            <?= $task['progress'] ?>%
          </div>
        </div>
        <form method="POST" class="mt-1 d-flex gap-1">
          <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
          <input type="number" name="progress" min="0" max="100" value="<?= $task['progress'] ?>" class="form-control form-control-sm">
          <button type="submit" name="update_progress" class="btn btn-sm btn-primary">Atualizar</button>
        </form>
      </td>
      <td>
        <a href="?toggle=<?= $task['id']; ?>" class="btn btn-sm btn-warning">Toggle</a>
        <a href="?delete=<?= $task['id']; ?>" class="btn btn-sm btn-danger">Excluir</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<!-- Gráfico de progresso médio -->
<h3>Progresso Médio</h3>
<div style="max-width: 600px; margin: auto;">
    <canvas id="taskChart"></canvas>
</div>

<script>
const ctx = document.getElementById('taskChart').getContext('2d');
const taskChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Concluído', 'Restante'],
        datasets: [{
            data: [<?= $averageProgress ?>, <?= 100 - $averageProgress ?>],
            backgroundColor: ['#198754','#e9ecef'],
            borderColor: ['#145c32', '#ced4da'],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return context.label + ': ' + context.parsed + '%';
                    }
                }
            }
        }
    }
});
</script>

<?php include 'views/footer.php'; ?>
