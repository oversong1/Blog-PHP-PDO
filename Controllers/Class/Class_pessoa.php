<?php

class Pessoa{
    private $pdo;
    
    public function __construct( $dbname, $host, $user, $senha){
        try{
            $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host, $user, $senha);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            echo "Erro ao se Conectar:".$e->getMessage();
        }
    }

    public function logar($email, $senha){
        $sql = $this->pdo->prepare("SELECT id_user FROM pessoa WHERE email = :e AND senha = :s");
        $sql->bindValue(":e" , $email);
        $sql->bindValue(":s" , $senha);
        $sql->execute();
        if($sql->rowCount() > 0){
            //entrar no sistema
            $dado = $sql->fetch(PDO::FETCH_ASSOC);
            session_start();
            $_SESSION['id_user'] = $dado['id_user'];
            return true;
        }else{
            return false;
        }
    }

    public function Usuario($id){
        $res = array();
        $cmd = $this->pdo->prepare("SELECT user FROM pessoa WHERE id_user = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        $res = $cmd->fetchAll();
        return $res;
    }

    public function buscarDados(){
        $res = array();
        $cmd = $this->pdo->prepare("SELECT * FROM cidades");
        $cmd->execute();
        $res = $cmd->fetchAll();
        return $res;
    }

    public function postGeral(){
        $res = array();
        $cmd = $this->pdo->prepare("SELECT * FROM post");
        $cmd->execute();
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    public function paginacaoCidade($paginacao, $cidade_url){
        try{
            $html = '';
            $limite = 2;
            $inicio = ($limite * $paginacao) - $limite;
            $ultima_pag = ceil(count($this->postGeral()) / $limite);

            $cmd = $this->pdo->prepare("SELECT * FROM post WHERE cidade_post = :cidade_url LIMIT :inicio, :limite");
            $cmd->bindParam(":inicio", $inicio, PDO::PARAM_INT);
            $cmd->bindParam(":limite", $limite, PDO::PARAM_INT);
            $cmd->bindValue(":cidade_url", $cidade_url);
            $cmd->execute();

            $html .= '<section class=titulo>';
                foreach($cmd->fetchAll() as $res){
                    if($res != 'id_posts'){
                        $html .= '<h3>'.$res['titulo_post'].'</h3>';
                        $html .= ' <section class=area>';
                        $html .= '<div> <img src='.$res['foto_post'].'  alt=foto-post> </div>';
                        $html .= '<div> <p id=scroll>'.$res['conteudo_post'].'</p> </div>';
                        $html .= ' </section>';
                    }
                }
               
            $html .= '</section>';
            if($paginacao > 1){
                $html .= '<a class=a_pagina href="/testes%20aleatorios%20de%20tudo/testes%20aleatorios%20de%20tudo/Meus%20testes/Blog%20Walmir/views/post_cidade.php?cidade='.$cidade_url.'&pag='.($paginacao - 1).'">Anterior</a>';
            }   
            if($paginacao < $ultima_pag){
                $html .= '<a class=a_pagina href="/testes%20aleatorios%20de%20tudo/testes%20aleatorios%20de%20tudo/Meus%20testes/Blog%20Walmir/views/post_cidade.php?cidade='.$cidade_url.'&pag='.($paginacao + 1).'">Proxima</a>';
            } 
            //$html .= 'Limite: '.$limite.' | Inicio: '.$inicio.' | Ultima pagina: '.$ultima_pag;
            return $html;
        }catch(PDOException $e){
            echo "Erro ao listar Posts".$e->getMessage();
        }    
    }

    public function editarPostCidade($paginacao, $cidade_url){
        try{
            $html = '';
            $limite = 2;
            $inicio = ($limite * $paginacao) - $limite;
            $ultima_pag = ceil(count($this->postGeral()) / $limite);
            
            @$id = $_GET['id'];
            @$id_upd = $_GET['id_up'];
            
            $cmd = $this->pdo->prepare("SELECT * FROM post WHERE cidade_post = :cidade_url LIMIT :inicio, :limite");
            $cmd->bindParam(":inicio", $inicio, PDO::PARAM_INT);
            $cmd->bindParam(":limite", $limite, PDO::PARAM_INT);
            $cmd->bindValue(":cidade_url", $cidade_url);
            
            $this->excluirPost($id);
            $this->dadosParaAtualizar($id_upd);
            
            $cmd->execute();

            $html .= '<section class=titulo>';
                foreach($cmd->fetchAll() as $res){
                    if($res != 'id_posts'){
                        $html .= '<h3>'.$res['titulo_post'].'</h3>';
                        $html .= ' <section class=area>';
                        $html .= '<div> <img src='.$res['foto_post'].'  alt=foto-post> </div>';
                        $html .= '<div> <p id=scroll>'.$res['conteudo_post'].'</p></div>';
                        $html .= '<a href="/testes%20aleatorios%20de%20tudo/testes%20aleatorios%20de%20tudo/Meus%20testes/Blog%20Walmir/views/editar_post.php?cidade='.$cidade_url.'&pag='.($paginacao).'&id_up='.$res['id_posts'].'">Editar</a>';
                        $html .= '<a href="/testes%20aleatorios%20de%20tudo/testes%20aleatorios%20de%20tudo/Meus%20testes/Blog%20Walmir/views/editar_post.php?cidade='.$cidade_url.'&pag='.($paginacao).'&id='.$res['id_posts'].'">Excluir</a>';
                        $html .= ' </section>';  
                    }
                        
                }

                if($this->excluirPost($id)){
                    unlink($res['foto_post']);
                }
               
            $html .= '</section>';

            if($paginacao > 1){
                $html .= '<a class=a_pagina href="/testes%20aleatorios%20de%20tudo/testes%20aleatorios%20de%20tudo/Meus%20testes/Blog%20Walmir/views/editar_post.php?cidade='.$cidade_url.'&pag='.($paginacao - 1).'">Anterior</a>';
            }   
            if($paginacao < $ultima_pag){
                $html .= '<a class=a_pagina href="/testes%20aleatorios%20de%20tudo/testes%20aleatorios%20de%20tudo/Meus%20testes/Blog%20Walmir/views/editar_post.php?cidade='.$cidade_url.'&pag='.($paginacao + 1).'">Proxima</a>';
            } 
            
            return $html;
        }catch(PDOException $e){
            echo "Erro ao listar Posts".$e->getMessage();
        }    
    }

    public function buscarPost($id_cidade){
        
        $cmd = $this->pdo->prepare("SELECT * FROM post WHERE cidade_post = :id_cidade");
        $cmd->bindValue(":id_cidade", "$id_cidade");
        $cmd->execute();
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    public function cadastrarPost($titulo, $cidade, $foto_post, $post){
        $cmd = $this->pdo->prepare("INSERT INTO post(titulo_post, cidade_post, foto_post, conteudo_post) Values(:t, :c, :fp, :cp) ");
        $cmd->bindValue(":t" , $titulo);
        $cmd->bindValue(":c" , $cidade);
        $cmd->bindValue(":fp" , $foto_post);
        $cmd->bindValue(":cp" , $post);
        $cmd->execute();
        return true;
    }

    public function paginacaoFun($paginacao){
        try{
            $html = '';
            $limite = 2;
            $inicio = ($limite * $paginacao) - $limite;
            $ultima_pag = ceil(count($this->postGeral()) / $limite);

            $cmd = $this->pdo->prepare("SELECT * FROM post LIMIT :inicio, :limite");
            $cmd->bindParam(":inicio", $inicio, PDO::PARAM_INT);
            $cmd->bindParam(":limite", $limite, PDO::PARAM_INT);
            $cmd->execute();

            $html .= '<section class=titulo>';
                foreach($cmd->fetchAll() as $res){
                    if($res != 'id_posts'){
                        $html .= '<h3>'.$res['titulo_post'].'</h3>';
                        $html .= ' <section class=area>';
                        $html .= '<div> <img src='.$res['foto_post'].'  alt=foto-post> </div>';
                        $html .= '<div> <p id=scroll>'.$res['conteudo_post'].'</p> </div>';
                        $html .= ' </section>';
                    }
                }
               
            $html .= '</section>';
            if($paginacao > 1){
                $html .= '<a class=a_pagina href="/testes%20aleatorios%20de%20tudo/testes%20aleatorios%20de%20tudo/Meus%20testes/Blog%20Walmir/views/post.php?pag='.($paginacao - 1).'">Anterior</a>';
            }   
            if($paginacao < $ultima_pag){
                $html .= '<a class=a_pagina href="/testes%20aleatorios%20de%20tudo/testes%20aleatorios%20de%20tudo/Meus%20testes/Blog%20Walmir/views/post.php?pag='.($paginacao + 1).'">Proxima</a>';
            } 
            //$html .= 'Limite: '.$limite.' | Inicio: '.$inicio.' | Ultima pagina: '.$ultima_pag;
            return $html;
        }catch(PDOException $e){
            echo "Erro ao listar Posts".$e->getMessage();
        }    
    }
    
    public function excluirPost($id){
        $cmd = $this->pdo->prepare("DELETE FROM post WHERE id_posts = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute(); 
         
    }

    public function dadosParaAtualizar($id){
        $res = array();
        $cmd = $this->pdo->prepare("SELECT * FROM post WHERE id_posts =  :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        return $res;
    }

    public function atualizar($id, $titulo, $foto, $conteudo){
        
        $cmd = $this->pdo->prepare("UPDATE post SET titulo_post = :t, foto_post = :f, conteudo_post = :c WHERE id_posts = :id");
        $cmd->bindValue(":t", $titulo);
        $cmd->bindValue(":f", $foto);
        $cmd->bindValue(":c", $conteudo);
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        return true;
        
    } 
}
?>