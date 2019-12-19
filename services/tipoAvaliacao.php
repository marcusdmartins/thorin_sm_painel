<?php
require_once 'api.php';
require_once 'manager_session.php';

//POSTS
if (!empty($_POST)) {
    //INSERIR
    if ($_POST['function'] == 'novo') {
        $campos = array("descricao" => $_POST['descricao']);
        $url = "tipoAvaliacao/novo";
        
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
        $url = "tipoAvaliacao/remover";
        
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
        $campos = array("id" => $_POST['id'], "descricao" => $_POST['descricao']);
        $url = "tipoAvaliacao/atualizar";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
        
    }
    
    //BUSCA TIPOS PREVISTOS POR MD (PREENCHE COMBO)
    if($_POST['function'] == 'listarTiposParaLancamento'){
        $campos = array("md" => $_POST['md']);
        $url = "tipoAvaliacao/listarTiposParaLancamento";
        
        $retorno = Api::requisicao($url, $campos);
        $dados = json_decode($retorno);
        
        if(!isset($dados->codigo)){
            foreach ($dados as $dado){
            echo'<option style = "padding: 16px" value="'.$dado->id.'">'.$dado->descricao.'</option>';
        }
        }else{
            echo'<option style = "padding: 6px" value="">Todas as notas previstas já foram lançadas</option>';
        }
    }     
}

function listarTiposAvaliacao(){
    $url = "tipoAvaliacao/listarTudo";
    $campos = Array();
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function listarTipoAvaliacao($id){
    $url = "tipoAvaliacao/listar";
    $campos = array("id" => $id);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function listarTiposPrevistos($md){
    $url = "tipoAvaliacao/listarTiposParaLancamento";
    $campos = array("md" => $md);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}