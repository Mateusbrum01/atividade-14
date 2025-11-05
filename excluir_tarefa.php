<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task_id']) && is_numeric($_POST['task_id'])) {
    $task_id = intval($_POST['task_id']);
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id=?");
    $stmt->execute([$task_id]);
}
header('Location: gerenciar_tarefas.php');
exit;
