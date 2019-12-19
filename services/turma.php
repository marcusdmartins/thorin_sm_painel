<?php
require_once 'api.php';
require_once 'manager_session.php';

//POSTS
if (!empty($_POST)) {
    //INSERIR
    if ($_POST['function'] == 'nova') {
        $campos = array("descricao" => $_POST['nome'],
                        "turno" => $_POST['turno'], 
                        "id_curso" => $_POST['curso'],
                        "id_sala" => $_POST['sala']);
        
        $url = "turma/nova";
        
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
        $url = "turma/remover";
        
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
        $campos = array(
                        "id" => $_POST['id'],
                        "descricao" => $_POST['nome'],
                        "turno" => $_POST['turno'], 
                        "id_curso" => $_POST['curso'],
                        "id_sala" => $_POST['sala']);
        
        $url = "turma/atualizar";
        
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
        $url = "turma/turmaPorCurso";
        
        $retorno = Api::requisicao($url, $campos);
        $dados = json_decode($retorno);
        
        if(!isset($dados->codigo)){
            foreach ($dados as $dado){
            echo'
                <a class="list-group-item media" href="turmaDetail?i='.$dado->id.'">
                    <div class="pull-left">
                        <img class="lgi-img" src="img/curso.png" alt="">
                    </div>
                <div class="media-body">
                    <div class="lgi-heading">'.$dado->descricao.'</div>
                        <small class="lgi-text">'.$dado->nome_curso.'</small>
                            
                    </div>
                </a>';
        }
        }else{
            echo "Nenhuma turma";
        }
    }   
    
    //BUSCA POR CURSO (PREENCHE COMBO)
    if($_POST['function'] == 'buscaPorCursoSelect'){
        $campos = array("id_curso" => $_POST['id_curso']);
        $url = "turma/turmaPorCurso";
        
        $retorno = Api::requisicao($url, $campos);
        $dados = json_decode($retorno);
        
        if(!isset($dados->codigo)){
            foreach ($dados as $dado){
            echo'<option style = "padding: 6px" value="'.$dado->id.'">'.$dado->descricao.'</option>';
        }
        }else{
            echo'<option style = "padding: 6px" value="">Nenhuma turma</option>';
        }
    }     
    
    //BUSCA INSTANTANEA
    if($_POST['function'] == 'buscaInstTurma'){
        $campos = array("busca" => $_POST['busca'], "id_curso" => $_POST['id_curso']);
        $url = "turma/buscaInstTurma";
        
        $retorno = Api::requisicao($url, $campos);
        $dados = json_decode($retorno);
        
        if(!isset($dados->codigo)){
            foreach ($dados as $dado){
            echo'
                <a class="list-group-item media" href="turmaDetail?i='.$dado->id.'">
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
            echo "Nenhuma turma";
        }
    }     
}

function listarTurmas(){
    $url = "turma/listarTudo";
    $campos = Array();
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function listarTurma($id_turma){
    $url = "turma/listar";
    $campos = array("id" => $id_turma);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}