<?php
session_start();
include 'conex.php'; // arquivo de conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomeUsuario = $_POST['nomeUsuario'];
    $senhaUsuario = md5($_POST['senhaUsuario']); // Criptografa a senha usando md5

    $stmt = $conn->prepare('SELECT idUsuario, avatar FROM usuarios WHERE nomeUsuario = ? AND senha = ?');
    $stmt->bind_param('ss', $nomeUsuario, $senhaUsuario);//substitui os ?
    $stmt->execute();//Executa o SELECT
    $stmt->store_result();//Guarda o resultado encontrado em um vetor

    if ($stmt->num_rows > 0) {//Verifica se o vetor tem mais de 0 linhas
        $stmt->bind_result($idUsuario, $avatar);//Armazena os daddos idUsuario e avatar do banco nas variaves criadas localmente
        $stmt->fetch();//Separa a informação do vetor

        // Atualiza o campo ultimoAcesso
        $stmt_update = $conn->prepare('UPDATE usuarios SET ultimoAcesso = NOW() WHERE idUsuario = ?');
        $stmt_update->bind_param('i', $idUsuario);
        $stmt_update->execute();

        // Inicia a sessão
        $_SESSION['idUsuario'] = $idUsuario;
        $_SESSION['avatar'] = $avatar;
        $_SESSION['nomeUsuario'] = $nomeUsuario;

        header('Location: feed.php'); // Redireciona para a página de dashboard
        exit;
    } else {
        echo 'Nome de usuário ou senha incorretos.';
    }
}
?>
