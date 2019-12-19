<?php

require_once 'api.php';
require_once '../manager_session.php';

//POSTS
if (!empty($_POST)) {
    //INSERIR
    if ($_POST['function'] == 'novo') {
        $campos = array("nome" => $_POST['nome']);
        $url = "localhost/thorin/nivel/novo";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
    }
    //EXCLUIR
    if($_POST['function'] == 'excl'){
        $campos = array("id" => $_POST['i']);
        $url = "localhost/thorin/nivel/remover";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
    }    
}