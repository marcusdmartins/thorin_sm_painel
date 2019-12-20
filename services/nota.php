<?php
require_once 'api.php';
require_once 'manager_session.php';
require_once 'funcoes.php';

//POSTS
if (!empty($_POST)) {
    //INSERIR
    if ($_POST['function'] == 'nova') {
        
        $t = array();
        array_push($t, moeda_to_float($_POST['t1']), 
                       moeda_to_float($_POST['t2']), 
                       moeda_to_float($_POST['t3']), 
                       moeda_to_float($_POST['t4']));
       
        //LANÇA NOTA DO MÊS LETIVO
        $campos = array("pessoa" => $_POST['pessoa'], 
                        "tipoAvaliacao" => $_POST['tipoAvaliacao'],
                        "md" => $_POST['md'],
                        "notasSemanais" => $t);
        
        $url = "notaSemanal/nova";
        
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
        $url = "nota/remover";
        
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
        $campos = array("id" => $_POST['id'],
                        "pessoa" => $_POST['pessoa'], 
                        "tipoAvaliacao" => $_POST['tipoAvaliacao'],
                        "md" => $_POST['md'],
                        "dataAvaliacao" => formata_padrao_data_bd($_POST['dataAvaliacao']),
                        "valor" => moeda_to_float($_POST['valor']));
        $url = "nota/atualizar";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
    }     
}

function listarNotas(){
    $url = "nota/listarTudo";
    $campos = Array();
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function listarNota($id){
    $url = "nota/listar";
    $campos = Array("id" => $id);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function notaPorMd($md){
    $url = "nota/notaPorMd";
    $campos = array("md" => $md);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}