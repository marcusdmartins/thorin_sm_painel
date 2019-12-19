<?php
require_once 'api.php';
require_once 'manager_session.php';

//POSTS
if (!empty($_POST)) {
    //INSERIR
    if ($_POST['function'] == 'novo') {
        
//        if ($_FILES['arquivo']['name'] != "" or $_FILES['arquivo']['name'] != null) {
//            preg_match("/\.(doc|docx|pdf|PDF|png|gif|jpg|jpeg|ppt|pptx|csv|mp4|MOV|xls|xlsx|txt){1}$/i", $arquivo1["name"], $ext);
//            $nome_arquivo = md5(uniqid(time())) . "." . $ext[1];
//            //move_uploaded_file($arquivo1["tmp_name"], $caminho_imagem);
//            $arquivo = base64_encode($arquivo1["tmp_name"]);
//        }
        
        $arquivo = base64_encode("marcus");
        $texto = str_replace("'",'',$_POST['texto']);
            
        $campos = array("titulo" => $_POST['titulo'],
                        "texto" => $texto,
                        "dp" => $_POST['dp'],
                        "professor_id" => $_POST['professor_id'],
                        "arquivo" => $arquivo);
        $url = "planejamento/novo";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo $ret->id;
        }else{
            echo 'error';
        }
    }
    
    //EXCLUIR
    if($_POST['function'] == 'remover'){
        $campos = array("id" => $_POST['i']);
        $url = "planejamento/remover";
        
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
        $arquivo = base64_encode("marcus");
        $texto = str_replace("'",'',$_POST['texto']);
        $campos = array("id" => $_POST['id'],
                        "titulo" => $_POST['titulo'],
                        "texto" => $texto,
                        "dp" => $_POST['dp'],
                        "professor_id" => $_POST['professor_id'],
                        "arquivo" => $arquivo);
        $url = "planejamento/atualizar";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
        
    }
    
    //ARQUIVO
    if($_POST['function'] == 'upload'){
        $arquivo1 = $_FILES["arquivo"];
        $arquivo = base64_encode(file_get_contents($arquivo1["tmp_name"]));
        $campos = array("id" => $_POST['id'],
                        "arquivo" => $arquivo);
        
        $url = "planejamento/uploadArquivo";
        
        $retorno = Api::requisicao($url, $campos);
        $ret = json_decode($retorno);
        
        if($ret->message == 'success'){
            echo "success";
        }else{
            echo $ret->message;
        }
        
    }    
}

function listarPlanejamentosPorDP($id_disc_professor){
    $url = "planejamento/planejamentoPorDP";
    $campos = Array("dp" => $id_disc_professor);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function listarPlanejamento($id){
    $url = "planejamento/listar";
    $campos = array("id" => $id);
    $retorno = Api::requisicao($url, $campos);
    $dados = json_decode($retorno);
    
    if(!isset($dados->codigo)){
        return $dados;
    }else{
        return "nenhum";
    }
}

function decodeArquivo($arquivo){
    $file = base64_decode($arquivo);
    
    $arquivo = file($file);
    
    return $arquivo["name"]; 
}