<?php

$keyResource = openssl_pkey_new([
	"digest_alg" => "sha256",
	"private_key_bits" => 4096,
	"private_key_type" => OPENSSL_KEYTYPE_RSA,
]);
openssl_pkey_export($keyResource, $privatekey);
$publickey = openssl_pkey_get_details($keyResource)["key"];
openssl_free_key($keyResource);

//$availablelist = openssl_get_cipher_methods(true);
//print_r($availablelist);
//echo $privatekey;
//echo $publickey;

$method = 'aes-256-ofb';

$len = openssl_cipher_iv_length($method);
//echo '---'.$len.'---',"\n";
$iv  = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
$pub = openssl_pkey_get_public( $publickey);
openssl_seal('another secret message',$sealed,$enckey,[$pub],$method,$iv);
openssl_free_key($pub);


//$iv = bin2hex($iv);

$envelope  = base64_encode(serialize([$method,$iv,$enckey,$sealed]));
echo $envelope."\n\n";
[$method,$iv,$enckey,$sealed] = unserialize(base64_decode( $envelope));

$private = openssl_pkey_get_private( $privatekey);
openssl_open($sealed,$opened,$enckey[0],$private,$method,$iv);
openssl_free_key($private);
echo $opened,"\n\n";
