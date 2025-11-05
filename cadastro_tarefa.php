<?php
require_once 'db.php';

$stmt = $conn->query("SELECT id, name FROM users ORDER BY name");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = intval($_POST['user_id'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    $sector = trim($_POST['sector'] ?? '');
    $priority = $_POST['priority'] ?? 'baixa';
    if ($user_id && $description && $sector) {
        $stmt = $conn->prepare("INSERT INTO tasks (user_id, description, sector, priority, status) VALUES (?, ?, ?, ?, 'a fazer')");
        if ($stmt->execute([$user_id, $description, $sector, $priority])) {
            $msg = "Tarefa cadastrada com sucesso!";
        } else {
            $msg = "Erro ao cadastrar tarefa.";
        }
    } else {
        $msg = "Preencha todos os campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Cadastro de Tarefa</title>
</head>
<body>
    <nav class="nav">
        <a href="index.php">Início</a>
        <a href="cadastro_usuario.php">Cadastrar Usuário</a>
        <a href="cadastro_tarefa.php">Cadastrar Tarefa</a>
        <a href="gerenciar_tarefas.php">Gerenciar Tarefas</a>
    </nav>
    <div class="container">
        <h1>Cadastro de Tarefa</h1>
        <?php if (!empty($msg)) echo '<p>' . htmlspecialchars($msg) . '</p>'; ?>
        <form method="post" style="display: flex; flex-direction: column; align-items: center;">
            <select name="user_id" required style="width: 80%; margin-bottom: 10px;">
                <option value="">Selecione o usuário</option>
                <?php foreach ($usuarios as $u): ?>
                    <option value="<?php echo $u['id']; ?>"><?php echo htmlspecialchars($u['name']); ?></option>
                <?php endforeach; ?>
            </select>
            <input type="text" name="description" placeholder="Descrição" required style="width: 80%; margin-bottom: 10px;">
            <input type="text" name="sector" placeholder="Setor" required style="width: 80%; margin-bottom: 10px;">
            <select name="priority" required style="width: 80%; margin-bottom: 16px;">
                <option value="baixa">Baixa</option>
                <option value="média">Média</option>
                <option value="alta">Alta</option>
            </select>
            <button type="submit" style="width: 50%;">Cadastrar</button>
        </form>
    </div>
</body>
</html>
