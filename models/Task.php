<?php
require_once __DIR__ . '/../config/database.php';

class Task {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getTasks($user_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM tasks WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    }

    public function addTask($user_id, $title, $description) {
        $stmt = $this->pdo->prepare("INSERT INTO tasks (user_id, title, description, progress) VALUES (?, ?, ?, 0)");
        return $stmt->execute([$user_id, $title, $description]);
    }

    public function updateTask($id, $title, $description, $status) {
        $stmt = $this->pdo->prepare("UPDATE tasks SET title = ?, description = ?, status = ? WHERE id = ?");
        return $stmt->execute([$title, $description, $status, $id]);
    }

    public function updateProgress($id, $progress) {
        $stmt = $this->pdo->prepare("UPDATE tasks SET progress = ? WHERE id = ?");
        return $stmt->execute([$progress, $id]);
    }

    public function deleteTask($id) {
        $stmt = $this->pdo->prepare("DELETE FROM tasks WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
