<?php
require_once 'api.php';
require_once 'manager_session.php';
require_once 'funcoes.php';

//POSTS
if (!empty($_POST)) {
    //INSERIR
    if ($_POST['function'] == 'novo') {
        
        $texto = str_replace("'",'',$_POST['texto']);
            
        $campos = array("titulo" => $_POST['titulo'],
                        "texto" => $texto,
                        "dp" => $_POST['dp'],
                        "data" => formata_padrao_data_bd($_POST['data']),
                        "professor" => $_POST['professor_id']);
        $url = "planoAula/novo";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo $ret->id;
        }else{
            echo 'error';
        }
    }
    
    //EXCLUIR
    if($_POST['function'] == 'remover'){
        $campos = array("id" => $_POST['i']);
        $url = "planoAula/remover";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
        
    } 
    
    //ATUALIZAR
    if($_POST['function'] == 'edit'){
        
        $texto = str_replace("'",'',$_POST['texto']);
        $campos = array("id" => $_POST['id'],
                        "titulo" => $_POST['titulo'],
                        "texto" => $texto,
                        "dp" => $_POST['dp'],
                        "data" => formata_padrao_data_bd($_POST['data']),
                        "professor" => $_POST['professor']);
        $url = "planoAula/atualizar";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
        
    }
    
    //ARQUIVO
    if($_POST['function'] == 'upload'){
        $arquivo1 = $_FILES["arquivo"];
        $arquivo = base64_encode(file_get_contents($arquivo1["tmp_name"]));
        $campos = array("id" => $_POST['id'],
                        "arquivo" => $arquivo);
        
        $url = "planoAula/uploadArquivo";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
        
    }    
}

function listarPlanosPorDP($id_disc_professor){
    $url = "planoAula/planosPorDP";
    $campos = Array("dp" => $id_disc_professor);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function listarPlano($id){
    $url = "planoAula/listar";
    $campos = array("id" => $id);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}