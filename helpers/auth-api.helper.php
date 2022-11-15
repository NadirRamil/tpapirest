<?php

class AuthApiHelper {
    function getToken(){
        //obtenemos el header
        $auth = $this->getAuthHeader(); // Bearer header.payload.signature 
        $auth = explode(" ", $auth); //separamos el tag del token
        if($auth[0]!="Bearer" || count($auth) != 2){
            return array();
        }
        $token = explode(".", $auth[1]); //nos quedamos con el token y lo dividimos por los puntos en 3 partes
        $header = $token[0];
        $payload = $token[1];
        $signature = $token[2];

        $new_signature = hash_hmac('SHA256', "$header.$payload", "Clave1234", true);
        $new_signature = base64url_encode($new_signature);
        if($signature!=$new_signature) 
            return array();
            
        //decodifiquemos ese payload, que primero viene codifica en base64 y adentro el json  
        $payload = json_decode(base64_decode($payload));
        if(!isset($payload->exp) || $payload->exp<time())
            return array();
     
        return $payload;   //y se lo devolvemos al usuario
    }

    function isLoggedIn(){
        $payload = $this->getToken();
        if(isset($payload->id))
            return true;
        else
            return false;
    }
    //Para soportar distintos servidores(apache)
    function getAuthHeader(){
        $header = "";
        if(isset($_SERVER['HTTP_AUTHORIZATION']))
            $header = $_SERVER['HTTP_AUTHORIZATION'];
        if(isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION']))
            $header = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
        return $header;
    }
}