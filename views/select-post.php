<?php

session_start();
if(!isset($_SESSION['id_user'])){
    header("Location: ../models/Login.php");
    exit;
}else {
    require("../Controllers/Class/Class_pessoa.php");
    require("../Controllers/Class/usuario_novo.php");
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../models/Css/estilo-select.css">
    <title> ADM - POST </title>
</head>
<body>
    <?php
    $user = $_SESSION['id_user'];
    $dados = $p->Usuario($user);
    foreach($dados as $k => $v){?>
        <h3 class="">Bem vindo <?php echo $v['user']; ?></h3>
    <?php
    }
    ?>

<div class="menu_1">
        <ul>
                <li><a href="../index.php">Home</a></li>
        </ul>
</div>
<?php

if(isset($_POST['submit'])){
    $titulo_cidade = addslashes($_POST['titulo']);
    $cidade_titulo = addslashes($_POST['select']);
    $post_cidade = addslashes($_POST['post']);
    

    /* Inicio upload de fotos */
           $vetFotos=array();
           //$vetMinis=array();
           $if=0;
           $qtdeFotos=1;

           $dir='../img/uploads_post/';
         
           for($if = 0; $if<$qtdeFotos; $if++){
                if($_FILES['f_foto'.($if+1)]['name'] !=""){

                    $ex=strtolower(substr($_FILES['f_foto'.($if+1)]['name'], -4));
                    $novo_nome=uniqid().$ex;
                    move_uploaded_file($_FILES['f_foto'.($if+1)]['tmp_name'],$dir.$novo_nome);

                    /* list($largura,$altura,$tipo)=getimagesize($dir.$novo_nome);
                    $imagem=imagecreatefromjpeg($dir.$novo_nome);
                    $thumb=imagecreatetruecolor(117,88);
                    imagecopyresampled($thumb,$imagem, 0, 0, 0, 0, 117, 88, $largura, $altura);
                    imagejpeg($thumb, $dir."mini_".$novo_nome, 100); */

                    $vetFotos[$if]= $dir.$novo_nome;
                    //$vetMinis[$if]= $dir."mini_".$novo_nome;

                }else{
                    $vetFotos[$if] = "";
                    //$vetMinis[$if] = "";
                }
            }
        
        /* Fim upload Foto */

    $p->cadastrarPost( $titulo_cidade, $cidade_titulo, $vetFotos[0], $post_cidade);       
}

?>
        <!-- FORMULARIO-->
        <form method="POST" enctype="multipart/form-data">
                <div>
                    <label for="titulo"> Titulo </label>
                    <input type="text" name="titulo" id="titulo" required placeholder="Titulo..............">
                </div>
            <div>    
            <?php
                $dados = $p->buscarDados();
                //buscando dados 
                if(count($dados) > 0 ){
                    echo "<select name='select'>";
                    foreach($dados as $k => $v){
                        if($k != "id"){
                            echo "<option>".$v['cidade']."</option>";
                    }
                }
                }else{
                    echo "</select>";
                }
            ?> 
                    
                    
                    <input type="file" name="f_foto1" required>
                     
                
                <textarea type="text" name="post" id="post" required placeholder="Texto......"></textarea>

                <button type="submit" name="submit">Enviar</button>
            </div>        
                
        </form>        

<hr>
<h3 class="">Editar Posts</h3>
    <div class="menu_2">
        <?php
                $dados = $p->buscarDados();
                //buscando dados 
                if(count($dados) > 0 ){
                    echo "<nav>";
                    foreach($dados as $k => $v){
                        if($k != "id"){
                            echo "<ul><li><a href='../views/editar_post.php?cidade=$v[cidade]'>".$v['cidade']."</a></li></ul>";
                    }
                }
                }else{
                    echo "</nav>";
                }
            ?> 
    </div>

<div  class="menu_1">
<a  href="sair.php">Sair</a>
</div>

<footer>
        <div id="footer">
            <p>CopyRight Emerson Souza And Revista o TIRA</p>
        </div>
        
    
</footer>
</body>
</html>