<?php
class Api{

    public static function requisicao($url, $campos){

        $uri_on = "thorin.xtremesolution.com.br/api/".$url;
        $uri_off = "localhost/thorin_sm/".$url;
        
        $mediaType = "application/json";
        // formato da requisição
        $charSet = "UTF-8";
        $headers = array();
        $headers[] = "Accept: " . $mediaType;
        $headers[] = "Accept-Charset: " . $charSet;
        $headers[] = "Accept-Encoding: " . $mediaType;
        $headers[] = "Content-Type: " . $mediaType . ";charset=" . $charSet;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uri_off);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($campos));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        
        return $result;

    }
}