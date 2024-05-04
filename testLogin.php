<?php
    session_start();
   
    if(isset($_POST['submit']) && !empty($_POST['nome_usuario']) && !empty($_POST['senha']))
    {
        
        include_once('config.php');
        $nome_usuario = $_POST['nome_usuario'];
        $senha = $_POST['senha'];


        $sql = "SELECT * FROM usuario WHERE nome_usuario = '$nome_usuario' and password = '$senha'";

        $result = $conexao->query($sql);


        if(mysqli_num_rows($result) < 1)
        {
            unset($_SESSION['nome_usuario']);
            unset($_SESSION['senha']);
            header('Location: login.php');
        }
        else
        {
            $_SESSION['nome_usuario'] = $nome_usuario;
            $_SESSION['senha'] = $senha;
            header('Location: level_selection.php');
        }
    }
    else
    {

        header('Location: login.php');
    }
?>