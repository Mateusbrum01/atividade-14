<?php
require_once 'db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: gerenciar_tarefas.php');
    exit;
}

$task_id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = trim($_POST['description'] ?? '');
    $sector = trim($_POST['sector'] ?? '');
    $priority = trim($_POST['priority'] ?? 'baixa');
    $user_id = intval($_POST['user_id'] ?? 0);
    if ($description && $sector && $user_id > 0) {
        $stmt = $conn->prepare("UPDATE tasks SET description=?, sector=?, priority=?, user_id=? WHERE id=?");
        $stmt->execute([$description, $sector, $priority, $user_id, $task_id]);
        header('Location: gerenciar_tarefas.php');
        exit;
    }
}

$stmt = $conn->prepare("SELECT * FROM tasks WHERE id=?");
$stmt->execute([$task_id]);
$task = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$task) {
    header('Location: gerenciar_tarefas.php');
    exit;
}
$users = $conn->query("SELECT id, name FROM users ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Tarefa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Editar Tarefa</h1>
        <form method="POST">
            <label>Descrição:<br><input type="text" name="description" value="<?php echo htmlspecialchars($task['description']); ?>" required></label><br>
            <label>Setor:<br><input type="text" name="sector" value="<?php echo htmlspecialchars($task['sector']); ?>" required></label><br>
            <label>Prioridade:<br>
                <select name="priority">
                    <option value="baixa" <?php if($task['priority']==='baixa') echo 'selected'; ?>>Baixa</option>
                    <option value="media" <?php if($task['priority']==='media') echo 'selected'; ?>>Média</option>
                    <option value="alta" <?php if($task['priority']==='alta') echo 'selected'; ?>>Alta</option>
                </select>
            </label><br>
            <label>Usuário:<br>
                <select name="user_id" required>
                    <?php foreach($users as $user): ?>
                        <option value="<?php echo $user['id']; ?>" <?php if($user['id']==$task['user_id']) echo 'selected'; ?>><?php echo htmlspecialchars($user['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </label><br><br>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="gerenciar_tarefas.php" class="btn">Cancelar</a>
        </form>
    </div>
</body>
</html>
