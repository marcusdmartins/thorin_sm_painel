<?php
require_once 'api.php';
require_once 'manager_session.php';
require_once 'funcoes.php';

//POSTS
if (!empty($_POST)) {
    //INSERIR
    if ($_POST['function'] == 'nova') {
        $campos = array("id_aluno" => $_POST['id_aluno'],
                        "id_curso" => $_POST['id_curso'], 
                        "id_turma" => $_POST['id_turma'],
                        "primeiraParcela" => formata_padrao_data_bd($_POST['primeiraParcela']),
                        "qtdParcelas" => $_POST['qtdParcelas'],
                        "desconto" => $_POST['desconto'],
                        "inicio" => formata_padrao_data_bd($_POST['inicio']));
        
        $url = "matricula/matricular";
        
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
        $url = "matricula/remover";
        
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
    
    //BUSCA INSTANTANEA MATRICULAS POR TURMA
    if($_POST['function'] == 'matriculasRegularesPorTurmaInst'){
        $campos = array("busca" => $_POST['busca'], "id_turma" => $_POST['id_turma']);
        $url = "matricula/matriculasRegularesPorTurmaInst";
        
        $retorno = Api::requisicao($url, $campos);
        $dados = json_decode($retorno);
        
        if(!isset($dados->codigo)){
            
            foreach ($dados as $dado){
            echo'
                <div class="col-md-2 col-sm-4 col-xs-6">
                   <div class="c-item">
                       <a href="" class="ci-avatar">
                           <img src="fotos/avatar.png" alt="">
                       </a>

                       <div class="c-info">
                           <a href="perfilVisit"><strong>'.$dado->pessoa_nome.'</strong></a>
                       </div>

                       <div class="c-footer">
                           <button onclick="lancaNota('.$dado->id.')" class="waves-effect"><i class="zmdi zmdi-person-add"></i> Notas</button>
                       </div>
                   </div>
               </div>';
        }
        }else{
            echo "Nenhum";
        }
    }    
    
}

function listarMatricula($id){
    $url = "matricula/listar";
    $campos = Array("id" => $id);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function matriculasPorAluno($id_aluno){
    $url = "matricula/matriculasPorAluno";
    $campos = array("id_aluno" => $id_aluno);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function matriculasRegularesPorTurma($id_turma){
    $url = "matricula/matriculasRegularesPorTurma";
    $campos = array("id_turma" => $id_turma);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function disciplinasPorMatricula($id_matricula){
    $url = "matriculaDisciplina/buscaPorMatricula";
    $campos = array("id_matricula" => $id_matricula);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function buscaPorMatriculaDisciplina($id_matricula, $id_disciplina){
    $url = "matriculaDisciplina/buscaPorMatriculaDisciplina";
    $campos = array("id_matricula" => $id_matricula, "id_disciplina" => $id_disciplina);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function listarMatriculaDisciplina($id){
    $url = "matriculaDisciplina/listar";
    $campos = array("id" => $id);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}