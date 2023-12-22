<?php
$clave="Una cadena cualquier %$#&/";
$method='aes-256-cbc';
$iv=base64_decode("BoB1f1wNWy2qMZwStfWdZA==");

$encriptar=function ($valor) use ($method,$clave,$iv){
    return openssl_encrypt($valor,$method,$clave,false,$iv);
};

$desencriptar=function ($valor) use ($method,$clave,$iv){
   // $encrypted_data=base64_decode($valor);
    return openssl_decrypt($valor,$method,$clave,false,$iv);
};


$getIV=function() use ($method){
    return base64_encode(openssl_random_pseudo_bytes(openssl_cipher_iv_length($method)));
};
//echo $getIV();

//echo $encriptar("vaquerano");
//echo $desencriptar("190ei16ogBpcgEtyx1E7Yw==");

?>