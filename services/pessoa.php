<?php
require_once 'api.php';
require_once 'manager_session.php';
require_once 'funcoes.php';

//POSTS
if (!empty($_POST)) {
    //INSERIR
    if ($_POST['function'] == 'nova') {
        $campos = array("nome" => $_POST['nome'],
                        "login" => $_POST['login'],
                        "dataNascimento" => formata_padrao_data_bd($_POST['dataNascimento']),
                        "sexo" => $_POST['sexo'],
                        "email" => $_POST['email'],
                        "senha" => $_POST['senha'],
                        "fone" => $_POST['fone'],
                        "celular" => $_POST['celular'],
                        "cpf" => $_POST['cpf'],
                        "codigoInterno" => $_POST['codigoInterno'],
                        "cep" => $_POST['cep'],
                        "rua" => $_POST['rua'],
                        "numero" => $_POST['numero'],
                        "complemento" => $_POST['complemento'],
                        "bairro" => $_POST['bairro'],
                        "tipoUsuario" => $_POST['tipoUsuario'],
                        "id_responsavel" => $_POST['id_responsavel']);
        
        $url = "pessoa/nova";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo $ret->id;
        }else{
            echo "error";
        }
        
    }
    
    //EXCLUIR
    if($_POST['function'] == 'remover'){
        $campos = array("id" => $_POST['i']);
        $url = "pessoa/remover";
        
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
                        "login" => $_POST['login'],
                        "dataNascimento" => formata_padrao_data_bd($_POST['dataNascimento']),
                        "sexo" => $_POST['sexo'],
                        "email" => $_POST['email'],
                        "fone" => $_POST['fone'],
                        "celular" => $_POST['celular'],
                        "cpf" => $_POST['cpf'],
                        "codigoInterno" => $_POST['codigoInterno'],
                        "cep" => $_POST['cep'],
                        "rua" => $_POST['rua'],
                        "numero" => $_POST['numero'],
                        "complemento" => $_POST['complemento'],
                        "bairro" => $_POST['bairro'],
                        "tipoUsuario" => $_POST['tipoUsuario'],
                        "id_responsavel" => $_POST['id_responsavel']);
        
        $url = "pessoa/atualizar";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
    }

    //BUSCA POR LOGIN
    if($_POST['function'] == 'buscaPorLogin'){
        $campos = array("login" => $_POST['login']);
        $url = "pessoa/buscaPorLogin";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'disponivel'){
            echo "disponivel";
        }else{
            echo $ret->message;
        }
    }
    
    //BUSCA INSTANTANEA
    if($_POST['function'] == 'buscaInstPessoa'){
        $campos = array("busca" => $_POST['busca'], "tipoUsuario" => $_POST['tipoUsuario']);
        $url = "pessoa/buscaInstPessoa";
        
        $retorno = Api::requisicao($url, $campos);
        $dados = json_decode($retorno);
        
        if(!isset($dados->codigo)){
            
            if($_POST['tipoUsuario'] == '5'){
                $link_page = 'alunoDetail';
            }else if($_POST['tipoUsuario'] == '6'){
                $link_page = 'responsavelDetail';
            }else if($_POST['tipoUsuario'] == '4'){
                $link_page = 'professorDetail';
            }
            
            foreach ($dados as $dado){
            echo'
                <a class="list-group-item media" href="'.$link_page.'?i='.$dado->id.'">
                    <div class="pull-left">
                        <img class="lgi-img" src="fotos/avatar.png" alt="">
                    </div>
                <div class="media-body">
                    <div class="lgi-heading">'.$dado->nome.'</div>
                        <small><strong>CPF: </strong>'.$dado->cpf.'</small><br>
                        <small><strong>Email: </strong>'.$dado->email.'</small><br>
                        <small><strong>Login: </strong>'.$dado->login.'</small>
                    </div>
                </a>';
        }
        }else{
            echo "Nenhum";
        }
    }

    //BUSCA POR ID
    if($_POST['function'] == 'listarPessoa'){
        $campos = array("id" => $_POST['id']);
        $url = "pessoa/listar";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if(!isset($ret->codigo)){
            echo $retorno;
        }else{
            echo "nenhum";
        }        
    }    
}

function listarPessoas(){
    $url = "pessoa/listarTudo";
    $campos = Array();
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function listarPessoa($id){
    $url = "pessoa/listar";
    $campos = array("id" => $id);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function listarPessoasPorTipo($tipo){
    $url = "pessoa/listarPorTipo";
    $campos = Array("tipoUsuario" => $tipo);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function buscaPorResponsavel($id){
    $url = "pessoa/buscaPorResponsavel";
    $campos = Array("id_responsavel" => $id);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}