<?php
require_once __DIR__ . '/../models/Task.php';

class TaskController {
    private $taskModel;

    public function __construct($pdo) {
        $this->taskModel = new Task($pdo);
    }

    public function add($user_id, $title, $description) {
        return $this->taskModel->addTask($user_id, $title, $description);
    }

    public function update($id, $title, $description, $status) {
        return $this->taskModel->updateTask($id, $title, $description, $status);
    }

    public function delete($id) {
        return $this->taskModel->deleteTask($id);
    }

    public function getAll($user_id) {
        return $this->taskModel->getTasks($user_id);
    }
}
?>
