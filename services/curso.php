<?php
require_once 'api.php';
require_once 'manager_session.php';

//POSTS
if (!empty($_POST)) {
    //INSERIR
    if ($_POST['function'] == 'novo') {
        $campos = array("nome" => $_POST['nome'],
                        "carga_horaria" => $_POST['carga_horaria'], 
                        "valor_mensal" => $_POST['valor'],
                        "nivel" => $_POST['nivel']);
        
        $url = "curso/novo";
        
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
        $url = "curso/remover";
        
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
                        "nome" => $_POST['nome'],
                        "carga_horaria" => $_POST['carga_horaria'], 
                        "valor_mensal" => $_POST['valor'],
                        "nivel" => $_POST['nivel']);
        $url = "curso/atualizar";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
        
    }     
}

function listarCursos(){
    $url = "curso/listarTudo";
    $campos = Array();
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function listarCurso($id_curso){
    $url = "curso/listar";
    $campos = array("id" => $id_curso);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}