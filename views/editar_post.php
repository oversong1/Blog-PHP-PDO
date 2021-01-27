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
    <link rel="stylesheet" href="../models/Css/estilo-post.css">
    <title>Post</title>
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
    if(isset($_GET['id_up'])){
        $id_update =  addslashes($_GET['id_up']);
        $res = $p-> dadosParaAtualizar($id_update);     
    }

?>
<?php
 /*    if(isset($_GET['id'])){
        $id_exluir =  addslashes($_GET['id']);
        $ex = $p->excluirPost($id_exluir);              
        unlink($ex['foto_post']);
    } */

?>
 <!-- FORMULARIO-->
 <form method="POST" enctype="multipart/form-data">
                <div>
                    <label for="titulo"> Titulo </label>
                    <input type="text" name="titulo" required id="titulo" value="<?php if(isset($res)){echo $res['titulo_post'];} ?>">
                </div>
            <div>            
                <label for="f_foto1" value="<?php if(isset($res)){echo $res['foto_post'];} ?>"></label>
                <input id="f_foto1" type="file"  name="f_foto1" accept="*/image">
                
                <textarea type="text" name="post" id="post"><?php if(isset($res)){echo $res['conteudo_post'];} ?></textarea>

                <input type="submit" name="submit" id="submit"  value="<?php if(isset($res)){echo "Atualizar";}else{echo "Enviar";} ?>">
            </div>        
                
        </form>  
    
<!-- FORMULARIO-->
<div class="menu_1">
        <ul>
                <li><a href="select-post.php">Select de Post</a></li>
        </ul>
</div>
<?php

    

    /* Esconde o erro quando entra em editar e ainda nao é setado o post a variavel ou objeto */
    //error_reporting(0);

    @$cidade_url  = addslashes($_GET['cidade']);


    $dados = $p->editarPostCidade((!empty($_GET['pag'])) ? $_GET['pag'] : 1, $cidade_url);
    echo $dados;

    if(isset($_GET['id_up']) && !empty($_GET['id_up'])){
        $id_upd = addslashes($_GET['id_up']);
        $titulo_cidade = addslashes($_POST['titulo']);
        
        /* Inicio update de fotos */
        $vetFotos=array();
        $if=0;
        $qtdeFotos=1;

        $dir='../img/uploads_post/';
      
        for($if = 0; $if<$qtdeFotos; $if++){
                if(@$_FILES['f_foto'.($if+1)]['name'] !=""){
                
                    unlink($res['foto_post']);
                    $ex=strtolower(substr($_FILES['f_foto'.($if+1)]['name'], -4));
                    $novo_nome=uniqid().$ex;
                    move_uploaded_file($_FILES['f_foto'.($if+1)]['tmp_name'],$dir.$novo_nome);

                    array_push($vetFotos,$dir.$novo_nome);

             }else{
                array_push($vetFotos, $res['foto_post']);
                 
             }

            
        }
     /* Fim upload Foto */

        $post_cidade = addslashes($_POST['post']);
        
        
        

        $p->atualizar($id_upd, $titulo_cidade, $vetFotos[0], $post_cidade );
        header("Location: editar_post.php?cidade=$cidade_url");
    }


    ?>
   

<!-- Fim Posts -->



<footer>
        <div id="footer">
            <p>  Emerson Souza </p>
        </div>
        
    
</footer>
</body>
</html>