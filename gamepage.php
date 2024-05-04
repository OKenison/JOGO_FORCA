<?php
session_start();




include 'generateWord.php';


$leaderboard = loadLeaderboard();


if (!isset($_SESSION['palavra'])) {
    $dificuldade = $_GET['dificuldade'] ?? 'facil';
    $dados_palavra = generateWord($dificuldade);
    $_SESSION['palavra'] = $dados_palavra['palavra'];
    $_SESSION['dica'] = $dados_palavra['dica'];
    $_SESSION['letra_adiv'] = [];
    $_SESSION['erros'] = 0;
    $_SESSION['ponto'] = 0;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adivinhar'])) {
    $adivinhar = strtolower(trim($_POST['adivinhar']));
    if (!in_array($adivinhar, $_SESSION['letra_adiv'])) {
        $_SESSION['letra_adiv'][] = $adivinhar;
        if (strpos($_SESSION['palavra'], $adivinhar) === false) {
            $_SESSION['erros']++;
            $_SESSION['ponto'] -= 100;
        } else {
            $_SESSION['ponto'] += 100;
        }
    }
}


$displayWord = '';
foreach (str_split($_SESSION['palavra']) as $letter) {
    $displayWord .= in_array($letter, $_SESSION['letra_adiv']) ? $letter : '_';
    $displayWord .= ' ';
}


$gameOver = $_SESSION['erros'] >= 6;
$win = !in_array('_', str_split($displayWord));






if ($gameOver) {
    $finalWord = $_SESSION['palavra'];
    $hangmanImageSrc = "hang7.png";
   
} else {
    $hangmanImageNumber = min($_SESSION['erros'] + 1, 7);
    $hangmanImageSrc = "hang$hangmanImageNumber.png";
}




function loadLeaderboard() {
    $filePath = 'leaderboard.txt';
    $leaderboard = [];
    if (file_exists($filePath)) {
        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            list($nome_usuario, $ponto) = explode(',', $line);
            $leaderboard[$nome_usuario] = (int)$ponto;
        }
    }
    return $leaderboard;
}


function saveLeaderboard($leaderboard) {
    $filePath = 'leaderboard.txt';
    $lines = [];
    foreach ($leaderboard as $nome_usuario => $ponto) {
        $lines[] = "$nome_usuario,$ponto";
    }
    file_put_contents($filePath, implode("\n", $lines));
}


function addScoreToLeaderboard($nome_usuario, $ponto, &$leaderboard) {
    $leaderboard[$nome_usuario] = $ponto;
    arsort($leaderboard);
    saveLeaderboard($leaderboard);
}


function displayLeaderboard($leaderboard) {
    echo "<h2>Leaderboard</h2>";
    echo "<table>";
    echo "<tr><th>Rank</th><th>nome_usuario</th><th>Score</th></tr>";
    $rank = 1;
    foreach ($leaderboard as $nome_usuario => $ponto) {
        echo "<tr><td>$rank</td><td>$nome_usuario</td><td>$ponto</td></tr>";
        $rank++;
    }
    echo "</table>";
}


if ($gameOver || $win) {
   
    $nome_usuario = $_SESSION['nome_usuario'];
    $ponto = $_SESSION['ponto'];
    $finalWord = $_SESSION['palavra'];


   
    addScoreToLeaderboard($nome_usuario, $ponto, $leaderboard);
    displayLeaderboard($leaderboard);




   
    unset($_SESSION['palavra']);
    unset($_SESSION['letra_adiv']);
    unset($_SESSION['erros']);
    unset($_SESSION['ponto']);
   
}






?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Jogo da Forca</title>
    <link rel="stylesheet" href="hangman.css">
</head>
<body>
    <div class="game-container">
        <img class="logo" src="logo.png" alt="Hangman Logo">


        <div class="game-area">
            <div class="score-container">
                <img class="score" src="ponto.png" alt="">
                <p>Pontuação: <?php echo $_SESSION['ponto'] ?? '0'; ?></p>
            </div>
            <div class="hangman-play-area">
                <img class="hanglevels" src="<?php echo $hangmanImageSrc; ?>" alt="Hangman Status">
                <?php if (isset($gameOver) && $gameOver): ?>
                    <p>Game Over! A palavra era "<?php echo htmlspecialchars($finalWord); ?>".</p>
                    <a href="home.php">Ir para o Menu</a>
                   
                <?php elseif (isset($win) && $win): ?>
                    <p>Parabens! Você adivinhou a palavra "<?php echo htmlspecialchars($finalWord); ?>" correto!</p>
                    <a href="home.php">Ir para o Menu</a>
                   
                <?php else: ?>
                    <p>Adivinhe a palavra: <?php echo $displayWord; ?></p>
                    <form action="gamepage.php" method="post">
                        Adivinhe a letra: <input type="text" name="adivinhar" maxlength="1" required>
                        <br><br/>
                        <button type="submit">Enviar</button>
                    </form>
                <?php endif; ?>
            </div>
            <div class="letters-container">
                <img class="letters" src="letra.png" alt="Letters Used">
                <p><?php echo implode(', ', $_SESSION['letra_adiv'] ?? []); ?></p>
            </div>
           
        </div>
        <div class="hint-container">
    <img src="dica.png" alt="hint" class="hint-image">
    <div class="overlay">
        <div class="text">
            <?php echo htmlspecialchars($_SESSION['dica'] ?? 'No hint available'); ?>
        </div>
    </div>
</div>
       
        <br>
        <a href="home.php">Pagina Inicial</a>
        <br>
        <a class="diffButton" href="level_selection.php">Mudar Dificuldade?</a>
        <br>
    </div>


   
</body>




</html>
