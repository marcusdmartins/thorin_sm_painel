<?php

require_once 'api.php';
require_once 'manager_session.php';


if (!empty($_POST)) {

    if ($_POST['function'] == 'getSession') {

        echo "$_SESSION[UsuarioID], $_SESSION[UsuarioNome], $_SESSION[UsuarioNivel]";
    }

    if ($_POST['function'] == 'valida') {
        $usuario = array("login" => $_POST['login'], "senha" => $_POST['senha']);
        $url = "acesso/logar";
        $retorno = Api::requisicao($url, $usuario);
        $ret = json_decode($retorno);
        
        if($ret->login != 'false'){
            ManagerSession::setSession($ret);
            echo "true";
        }else{
            echo "false";
        }
    }

    if ($_POST['function'] == 'consulta_sessao') {
        @session_start();
        if (!empty($_SESSION)) {
            echo 'true';
        } else {
            echo 'false';
        }
    }
    
}