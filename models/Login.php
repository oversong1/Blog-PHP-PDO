<?php

require("../Controllers/Class/Class_pessoa.php");
require("../Controllers/Class/usuario_novo.php");

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Css/login.css">
    <title>Login</title>
</head>
<body>
    <h3>A revista o Tira</h3>
    
    <div class="menu_1">
        <ul>
                <li><a href="../index.php">Home</a></li>
        </ul>
    </div>
    <?php
        if(isset($_POST['email'])){
            $email = addslashes($_POST['email']);
            $senha = addslashes($_POST['senha']);
            if(!empty($email) && !empty($senha)){
                if($p->logar($email, $senha)){
                    header("Location:../views/select-post.php");
                }else{
                    echo"Email e/ou senha Incorreta";
                }
            }else{
                echo"Preencha todos os campos ";
            }
        }
    ?>
    <form method="POST">
        <label for="email">Email</label>
        <input type="email" name="email" id="email">

        <label for="senha">Senha</label>
        <input type="password" name="senha" id="senha">


        <button type="submit">Logar</button>
    </form>

    <footer>
        <div id="footer">
            <p>CopyRight Emerson Souza And Revista o TIRA</p>
        </div>
</footer>
</body>
</html>