<?php

$keyResource = openssl_pkey_new([
	"digest_alg" => "sha256",
	"private_key_bits" => 4096,
	"private_key_type" => OPENSSL_KEYTYPE_RSA,
]);
openssl_pkey_export($keyResource, $privatekey);
$publickey = openssl_pkey_get_details($keyResource)["key"];
openssl_free_key($keyResource);



$iv  = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes256'));
$pub = openssl_pkey_get_public( $publickey);
//var_dump(openssl_pkey_get_details($pub)['key']);
openssl_seal('hallo 123',$sealed,$enckey,[$pub],'aes256',$iv);
openssl_free_key($pub);

echo $sealed,"\n";

$private = openssl_pkey_get_private( $privatekey);
openssl_open($sealed,$opened,$enckey[0],$private,'aes256',$iv);
openssl_free_key($private);
echo $opened,"\n";

