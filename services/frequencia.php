<?php
require_once 'api.php';
require_once 'manager_session.php';
require_once 'funcoes.php';

//POSTS
if (!empty($_POST)) {
    //INSERIR
    if ($_POST['function'] == 'nova') {
        
        if(empty($_POST["alunos"])){
            $alunos = "nenhum";
        }else{
            $alunos = $_POST["alunos"];
        }
        
        $campos = array("data" => formata_padrao_data_bd($_POST['data']),
                        "dp" => $_POST['dp'],
                        "id_turma" => $_POST['id_turma'],
                        "frequencia" => $alunos);
        
        $url = "frequencia/nova";
        
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
        $url = "frequencia/remover";
        
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
        
        if(empty($_POST["alunos"])){
            $alunos = "nenhum";
        }else{
            $alunos = $_POST["alunos"];
        }
        
        $campos = array("id" => $_POST['id'],
                        "data" => formata_padrao_data_bd($_POST['data']),
                        "id_turma" => $_POST['id_turma'],
                        "dp" => $_POST['dp'],
                        "frequencia" => $alunos);
        $url = "frequencia/atualizar";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
        
    }     
}

function frequenciaPorDP($dp){
    $url = "frequencia/frequenciaPorDP";
    $campos = Array("dp" => $dp);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function listarFrequencia($id_frequencia){
    $url = "frequencia/listar";
    $campos = array("id" => $id_frequencia);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function frequenciaAlunoDP($id_frequencia, $id_aluno){
    $url = "frequencia/frequenciaAlunoDP";
    $campos = Array("id_frequencia" => $id_frequencia, "id_aluno" => $id_aluno);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    return $dados->message;
}

function frequenciaAlunoDisciplina($disciplina, $id_aluno, $presenca){
    $url = "frequencia/frequenciaAlunoDisciplina";
    $campos = Array("disciplina" => $disciplina, "id_aluno" => $id_aluno, "presenca" => $presenca);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    return $dados;
}

function frequenciaAlunoDisciplinaDetalhes($disciplina, $id_aluno, $presenca){
    $url = "frequencia/frequenciaAlunoDisciplinaDetalhes";
    $campos = Array("disciplina" => $disciplina, "id_aluno" => $id_aluno, "presenca" => $presenca);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}