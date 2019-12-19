<?php
require_once 'api.php';
require_once 'manager_session.php';
require_once 'funcoes.php';

//POSTS
if (!empty($_POST)) {
    //INSERIR
    if ($_POST['function'] == 'nova') {
        
        if(empty($_POST["tipos"])){
            $tipos = "nenhum";
        }else{
            $tipos = $_POST["tipos"];
        }        
        
        $campos = array("nome" => $_POST['nome'], "corte" => moeda_to_float($_POST['corte']), "tipo" => $_POST['tipo'], "tipos" => $tipos);
        $url = "media/nova";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
    }
    //EXCLUIR
    if($_POST['function'] == 'remover'){
        $campos = array("id" => $_POST['i']);
        $url = "media/remover";
        
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
        
        if(empty($_POST["tipos"])){
            $tipos = "nenhum";
        }else{
            $tipos = $_POST["tipos"];
        } 
        
        $campos = array("id" => $_POST['id'], "nome" => $_POST['nome'], "corte" => moeda_to_float($_POST['corte']), "tipo" => $_POST['tipo'], "tipos" => $tipos);
        $url = "media/atualizar";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
        
    }     
}

function listarMedias(){
    $url = "media/listarTudo";
    $campos = Array();
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function listarMedia($id_media){
    $url = "media/listar";
    $campos = array("id" => $id_media);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function tipoAvaliacaoPorMedia($media, $tipoAvaliacao){
    $url = "media/tipoAvaliacaoPorMedia";
    $campos = array("media"=> $media, "tipoAvaliacao" => $tipoAvaliacao);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    return $dados->message;
}

function buscaMediasPorMD($md){
    $url = "media/buscaMediasPorMD";
    $campos = array("md"=> $md);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}