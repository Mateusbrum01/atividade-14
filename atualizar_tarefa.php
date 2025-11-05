<?php

require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: gerenciar_tarefas.php');
    exit;
}

$task_id = isset($_POST['task_id']) ? intval($_POST['task_id']) : 0;
$new_status = isset($_POST['new_status']) ? trim($_POST['new_status']) : '';

$allowed = ['a fazer', 'fazendo', 'pronto'];

if ($task_id <= 0 || !in_array($new_status, $allowed, true)) {
    header('Location: gerenciar_tarefas.php');
    exit;
}

try {
    $stmt = $conn->prepare("UPDATE tasks SET status = :status WHERE id = :id");
    $stmt->execute([':status' => $new_status, ':id' => $task_id]);
} catch (PDOException $e) {
    
}

header('Location: gerenciar_tarefas.php');
exit;
