<?php

function formata_padrao_data($data){

$data_edit = explode("-","$data");
$ano = $data_edit[0];
$mes = $data_edit[1];
$dia = $data_edit[2];

$data_final = "$dia/$mes/$ano";

return $data_final;

}

function formata_padrao_data_bd($data){

$data_edit = explode("/","$data");
$ano = $data_edit[2];
$mes = $data_edit[1];
$dia = $data_edit[0];

$data_final = "$ano-$mes-$dia";

return $data_final;

}

function formata_data($data){
	
	$dataDet = explode("-",$data);
		if ($dataDet[1] == 1){		
		$mes = "janeiro";	
		}else if ($dataDet[1] == 2){
			$mes = "fevereiro";			
			}else if ($dataDet[1] == 3){
			$mes = "março";			
				}else if ($dataDet[1] == 4){
				$mes = "abril";			
					}else if ($dataDet[1] == 5){
					$mes = "maio";			
						}else if ($dataDet[1] == 6){
						$mes = "junho";			
							}else if ($dataDet[1] == 7){
							$mes = "julho";			
										}else if ($dataDet[1] == 8){
										$mes = "agosto";			
											}else if ($dataDet[1] == 9){
											$mes = "setembro";			
												}else if ($dataDet[1] == 10){
												$mes = "outubro";			
													}else if ($dataDet[1] == 11){
													$mes = "novembro";			
														}else if ($dataDet[1] == 12){
														$mes = "dezembro";			
															}
	
	
	$data_nasc = $dataDet[2]." de ".$mes." de ".$dataDet[0];
	
	return "$data_nasc";
	
}

function formata_data_mes($data){
	
	$mes_leg = date('m', strtotime($data));
        
        if($mes_leg == '01'){
            $ret = "Janeiro";
        }else if($mes_leg == '02'){
            $ret = "Fevereiro";
        }else if($mes_leg == '03'){
            $ret = "Março";
        }else if($mes_leg == '04'){
            $ret = "Abril";
        }else if($mes_leg == '05'){
            $ret = "Maio";
        }else if($mes_leg == '06'){
            $ret = "Junho";
        }else if($mes_leg == '07'){
            $ret = "Julho";
        }else if($mes_leg == '08'){
            $ret = "Agosto";
        }else if($mes_leg == '09'){
            $ret = "Setembro";
        }else if($mes_leg == '10'){
            $ret = "Outubro";
        }else if($mes_leg == '11'){
            $ret = "Novembro";
        }else if($mes_leg == '12'){
            $ret = "Dezembro";
        }
	
	return $ret;
}
	
function retorna_somente_data($data){

$data_separada = explode(" ", $data);

$data_edit = $data_separada[0];

// $data_edit = explode("-","$data");
// $ano = $data_edit[0];
// $mes = $data_edit[1];
// $dia = $data_edit[2];

// $data_final = "$dia/$mes/$ano";

return $data_edit;

}

function retorna_somente_hora($hora){

$hora_separada = explode(":", $hora);

$hora = $hora_separada[0].":".$hora_separada[1];

return "$hora";

}

function moeda($valor){
    $moeda = number_format($valor, 2, ',', '.');
    return $moeda;
}

function moeda_to_float($valor1){
    $valor2 = str_replace('.','', $valor1);
    $valor2 = str_replace(',','.', $valor2);
    return $valor2;
}

function getTurno($ab){
    if($ab == "m"){
        return "Matutino";
    }else if($ab == "v"){
        return "Vespertino";
    }else if($ab == "n"){
        return "Noturno";
    }else if($ab == "i"){
        return "Integral";
    }
}

function getTurnos(){
    
    $turnos = Array();
    
    array_push($turnos, array("ab" => "m", "nome" => "Matutino"));
    array_push($turnos, array("ab" => "v", "nome" => "Vespertino"));
    array_push($turnos, array("ab" => "n", "nome" => "Noturno"));
    array_push($turnos, array("ab" => "i", "nome" => "Integral"));
    
    return $turnos;
    
    }
    
function getSexo($ab){
    if($ab == "m"){
        return "Masculino";
    }else if($ab == "f"){
        return "Feminino";
    }
}

function getSexos(){
    
    $sexos = Array();
    
    array_push($sexos, array("ab" => "m", "nome" => "Masculino"));
    array_push($sexos, array("ab" => "f", "nome" => "Feminino"));
    
    return $sexos;
    }
	
	