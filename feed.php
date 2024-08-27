<?php
include 'check.php';
include 'conex.php';

//session_start();
$idUsuario = $_SESSION['idUsuario']; // Considerando que o ID do usuário logado esteja armazenado na sessão
$nomeUsuario=$_SESSION['nomeUsuario'];
$avatar='./avatar/'.$_SESSION['avatar'];
date_default_timezone_set('America/Sao_Paulo');

$sql = "call pegarFeed(?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Feed - <?php echo $nomeUsuario;?></title>
    <link rel="stylesheet" href="css/estilo.css"> <!-- Estilos CSS -->
</head>
<body>
    
<div class="post-form-container">
    <form action="processarpostagem.php" method="post" class="post-form">
        <div class="user">
            <div class="tagPerfil">
                <label for="texto" class="post-label">
                    <img src="<?php echo $avatar;?>" alt="Avatar" class="avatar">
                    <span>@<?php echo $nomeUsuario;?></span>
                </label>
            </div>
            <a href="logout.php">Deslogar</a>
        </div>
        <textarea id="texto" name="texto" maxlength="200" required class="post-textarea" placeholder="Escreva sua postagem (máximo 200 caracteres)"></textarea>
        <input type="hidden" name="fidAutor" value="<?php echo $idUsuario; ?>">
        <input type="submit" value="Postar" class="post-submit">
    </form>
</div>

    <div class="feed-container">

        <h1>Feed</h1>
        <?php
        if ($result->num_rows > 0) {
            while ($linhas = $result->fetch_assoc()) {
                //armazenando e convertendo para o formato brasileiro
                $dateTime = new DateTime($linhas['dataHora']);
                $formatada = IntlDateFormatter::formatObject($dateTime, "dd 'de' MMMM 'de' YYYY 'às' h:mm", 'pt-BR');//adicionar o extension=php_intl.dll no arquivo php.ini
                ?>
                <article>
                    <small class="hpost"><?php echo $formatada; ?></small>
                    <a href="perfil.php?id=<?php echo $linhas['fidAutor'];?>">
                        <div class="autor">
                            <img src="./avatar/<?php echo $linhas['avatar']; ?>" alt="Avatar" class="avatar">
                            <strong><?php echo $linhas['nomeUsuario']; ?></strong>
                        </div>
                    </a>
                    <a href="post.php?id=<?php echo $linhas['idPostagem'] ?>">
                        <div class="postagem">
                            <p><?php echo $linhas['texto']; ?></p>
                        </div>
                    </a>
                        <div class="curtidas">
                            <img src="./img/coracao.png">
                            <a href="#">
                            <span><?php echo $linhas['curtidas']; ?></span>
                            </a>
                        </div>
                </article>
                <?php
            }
        } else {
            echo "<p>Nenhuma postagem encontrada.</p>";
        }
        ?>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>