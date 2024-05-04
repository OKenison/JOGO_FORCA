<?php
session_start();




$leaderboard = [];


function addScoreToLeaderboard($nome_usuario, $ponto, &$leaderboard) {
    $leaderboard[$nome_usuario] = $ponto;
    arsort($leaderboard);
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


   
    addScoreToLeaderboard($nome_usuario, $ponto, $leaderboard);
}




displayLeaderboard($leaderboard);
?>


