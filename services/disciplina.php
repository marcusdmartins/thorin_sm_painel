<?php
require_once 'api.php';
require_once 'manager_session.php';

//POSTS
if (!empty($_POST)) {
    //INSERIR
    if ($_POST['function'] == 'nova') {
        $campos = array("nome" => $_POST['nome'],
                        "carga_horaria" => $_POST['carga_horaria'], 
                        "curso" => $_POST['curso']);
        
        $url = "disciplina/nova";
        
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
        $url = "disciplina/remover";
        
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
                        "curso" => $_POST['curso']);
        
        $url = "disciplina/atualizar";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
        
    }
    
    //BUSCA POR CURSO
    if($_POST['function'] == 'buscaPorCurso'){
        $campos = array("id_curso" => $_POST['id_curso']);
        $url = "disciplina/disciplinaPorCurso";
        
        $retorno = Api::requisicao($url, $campos);
        $dados = json_decode($retorno);
        
        if(!isset($dados->codigo)){
            foreach ($dados as $dado){
            echo'
                <a class="list-group-item media" href="disciplinaDetail?i='.$dado->id.'">
                    <div class="pull-left">
                        <img class="lgi-img" src="img/curso.png" alt="">
                    </div>
                <div class="media-body">
                    <div class="lgi-heading">'.$dado->nome.'</div>
                        <small class="lgi-text">'.$dado->nome_curso.'</small>
                            
                    </div>
                </a>            
            ';
        }
        }else{
            echo "Nenhuma disciplina";
        }
    }

    //BUSCA POR CURSO (PREENCHE COMBO)
    if($_POST['function'] == 'buscaPorCursoSelect'){
        $campos = array("id_curso" => $_POST['id_curso']);
        $url = "disciplina/disciplinaPorCurso";
        
        $retorno = Api::requisicao($url, $campos);
        $dados = json_decode($retorno);
        
        if(!isset($dados->codigo)){
            foreach ($dados as $dado){
            echo'<option style = "padding: 6px" value="'.$dado->id.'">'.$dado->nome.'</option>';
        }
        }else{
            echo'<option style = "padding: 6px" value="">Nenhuma disciplina</option>';
        }
    }     
    
    //BUSCA INSTANTANEA
    if($_POST['function'] == 'buscaInstDisciplina'){
        $campos = array("busca" => $_POST['busca'], "id_curso" => $_POST['id_curso']);
        $url = "disciplina/buscaInstDisciplina";
        
        $retorno = Api::requisicao($url, $campos);
        $dados = json_decode($retorno);
        
        if(!isset($dados->codigo)){
            foreach ($dados as $dado){
            echo'
                <a class="list-group-item media" href="disciplinaDetail?i='.$dado->id.'">
                    <div class="pull-left">
                        <img class="lgi-img" src="img/curso.png" alt="">
                    </div>
                <div class="media-body">
                    <div class="lgi-heading">'.$dado->nome.'</div>
                        <small class="lgi-text">'.$dado->nome_curso.'</small>
                            
                    </div>
                </a>';
        }
        }else{
            echo "Nenhuma disciplina";
        }
    }     
}

function listarDisciplinas(){
    $url = "disciplina/listarTudo";
    $campos = Array();
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function listarDisciplina($id_disciplina){
    $url = "disciplina/listar";
    $campos = array("id" => $id_disciplina);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}