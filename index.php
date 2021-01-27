<?php

require("Controllers/Class/Class_pessoa.php");
require("Controllers/Class/usuario_novo.php");

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="models/Css/estilo.css">
    <title>Revista</title>
</head>
<body>
    
    <h3 class="">Frase do site que tem para ficar no topo</h3>

<section class="grid1">
        <div>
            <img src="img/lobo1.jpg" alt="logo">
        </div>
        <div class="anuncio">
            <img src="img/lobo2.jpg" alt="logo">
        </div>
        <div class="anuncio">
            <img src="img/lobo3.jpg" alt="logo">
        </div>
</section>

<div class="menu_1">
    <nav>
        <ul class="menu-1">
                <li><a href="index.php">Home</a></li>
                <li><a href="views/post.php">Post</a></li>
                <li><a href="#">Localização</a></li>
                <li><a href="#">sobre-nós</a></li>
                <li><a href="#">Produtos</a></li>
                <li><a href="models/Login.php">Login</a></li>
            
        </ul>
    </nav>
</div>

<section class="flex-2">
    <div class="menu-2">
       
        <?php
                $dados = $p->buscarDados();
                //buscando dados 
                if(count($dados) > 0 ){
                    echo "<nav>";
                    foreach($dados as $k => $v){
                        if($k != "id"){
                            echo "<ul><li><a href='views/post_cidade.php?cidade=$v[cidade]'>".$v['cidade']."</a></li></ul>";
                    }
                }
                }else{
                    echo "</nav>";
                }
            ?> 
    </div>

    <div>
        <img src="img/lobo1.jpg" alt="logo">
    </div>
   
    
</section>

<footer>
        <div id="footer">
            <p>CopyRight Emerson Souza And Revista o TIRA</p>
        </div>
        
    
</footer>
</body>
</html>