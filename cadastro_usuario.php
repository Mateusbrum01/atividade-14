<?php
require_once 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    if ($name && $email) {
        $stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        if ($stmt->execute([$name, $email])) {
            $msg = "Usuário cadastrado com sucesso!";
        } else {
            $msg = "Erro ao cadastrar usuário.";
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
    <title>Cadastro de Usuário</title>
</head>
<body>
    <nav class="nav">
        <a href="index.php">Início</a>
        <a href="cadastro_usuario.php">Cadastrar Usuário</a>
        <a href="cadastro_tarefa.php">Cadastrar Tarefa</a>
        <a href="gerenciar_tarefas.php">Gerenciar Tarefas</a>
    </nav>
    <div class="container">
        <h1>Cadastro de Usuário</h1>
        <?php if (!empty($msg)) echo '<p>' . htmlspecialchars($msg) . '</p>'; ?>
        <form method="post" style="display: flex; flex-direction: column; align-items: center;">
            <input type="text" name="name" placeholder="Nome" required style="width: 80%; margin-bottom: 10px;">
            <input type="email" name="email" placeholder="E-mail" required style="width: 80%; margin-bottom: 16px;">
            <button type="submit" style="width: 50%;">Cadastrar</button>
        </form>
    </div>
</body>
</html>
