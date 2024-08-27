<?php  
    session_start();
    if (isset($_SESSION['idUsuario'])) {
        header('Location: feed.php');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f2f2f2; display: flex; justify-content: center; align-items: center; height: 100vh; }
        form { background: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        input { display: block; width: 90%; margin-bottom: 10px; padding: 10px; }
    </style>
</head>
<body>
    <form action="login.php" method="post">
        <h2>Login</h2>
        <input type="text" name="nomeUsuario" placeholder="Nome de Usuário" required>
        <input type="password" name="senhaUsuario" placeholder="Senha" required>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>