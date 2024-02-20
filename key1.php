<?php

$keyResource = openssl_pkey_new([
	"digest_alg" => "sha256",
	"private_key_bits" => 4096,
	"private_key_type" => OPENSSL_KEYTYPE_RSA,
]);
openssl_pkey_export($keyResource, $private_key);
openssl_pkey_export($keyResource, $private_keyenc, 'test');
$public_key = openssl_pkey_get_details($keyResource)["key"];
//openssl_free_key($keyResource);

//$availablelist = openssl_get_cipher_methods(true);
//print_r($availablelist);
echo $private_keyenc;
echo $private_key;
echo $public_key;
