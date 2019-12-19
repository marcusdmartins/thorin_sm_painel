<?php
require_once 'api.php';
require_once 'manager_session.php';

//POSTS
if (!empty($_POST)) {
    //INSERIR
    if ($_POST['function'] == 'nova') {
        
        if($_POST['id_professor'] != "" and $_POST['turma'] != ""){

            $campos = array("pessoa" => $_POST['id_professor'],
                            "disc" => $_POST['disc'], 
                            "turma" => $_POST['turma']);

            $url = "disciplinaProfessor/nova";

            $retorno = Api::requisicao($url, $campos);
            $ret = json_decode($retorno);

            if($ret->message == 'success'){
                echo "success";
            }else{
                echo $ret->message;
            }
        }else{
            echo "incompleto";
        }
    }
    
    //EXCLUIR
    if($_POST['function'] == 'remover'){
        $campos = array("id" => $_POST['i']);
        $url = "disciplinaProfessor/remover";
        
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
                        "pessoa" => $_POST['id_professor'],
                        "disc" => $_POST['disc'], 
                        "turma" => $_POST['turma']);
        
        $url = "disciplinaProfessor/atualizar";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
        
    }

    //BUSCA POR TURMA
    if($_POST['function'] == 'buscaPorTurma'){
        $campos = array("id_turma" => $_POST['id_turma']);
        $url = "disciplinaProfessor/buscaPorTurma";
        
        $retorno = Api::requisicao($url, $campos);
        $dados = json_decode($retorno);
        
        if(!isset($dados->codigo)){
            foreach ($dados as $dado){
            echo'
                <a class="list-group-item media animated fadeIn" href="profTurmaDetail?i='.$dado->id.'">
                    <div class="pull-left">
                        <img class="lgi-img" src="img/curso.png" alt="">
                    </div>
                <div class="media-body">
                    <div class="lgi-heading">'.$dado->nome_disciplina.'</div>
                        <small class="lgi-text">'.$dado->nome_professor.'</small>
                        <small class="lgi-text">'.$dado->nome_turma.'</small>
                </div>
                </a>';
        }
        }else{
            echo "Nenhuma DP";
        }
    }    
}

function buscaDisciplinasPorProfessor($id_professor){
    $url = "disciplinaProfessor/buscaPorProfessor";
    $campos = Array("id_professor" => $id_professor);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function listaDisciplinaProfessor($id){
    $url = "disciplinaProfessor/listar";
    $campos = Array("id" => $id);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}