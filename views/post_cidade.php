<?php

require("../Controllers/Class/Class_pessoa.php");
require("../Controllers/Class/usuario_novo.php");



?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../models/Css/estilo-post.css">
    <title>Post</title>
</head>
<body>
    
    <h3 class="">Frase do site que tem para ficar no topo</h3>

<section class="grid1">
        <div>
            <img src="../img/lobo1.jpg" alt="logo">
        </div>
        <div class="anuncio">
            <img src="../img/lobo2.jpg" alt="logo">
        </div>
        <div class="anuncio">
            <img src="../img/lobo3.jpg" alt="logo">
        </div>
</section>

<div class="menu_1">
        <ul>
                <li><a href="../index.php">Home</a></li>
        </ul>
</div>

<!-- Incio Posts -->


<?php 
  

    $cidade_url  = $_GET['cidade'];

    $dados = $p->paginacaoCidade((!empty($_GET['pag'])) ? $_GET['pag'] : 1, $cidade_url);
    echo $dados;

    ?>
   
    


<!-- Fim Posts -->



<footer>
        <div id="footer">
            <p>  Emerson Souza </p>
        </div>
        
    
</footer>
</body>
</html>