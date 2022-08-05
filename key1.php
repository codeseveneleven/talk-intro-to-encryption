<?php

$keyResource = openssl_pkey_new([
	"digest_alg" => "sha256",
	"private_key_bits" => 4096,
	"private_key_type" => OPENSSL_KEYTYPE_RSA,
]);
openssl_pkey_export($keyResource, $privatekey);
openssl_pkey_export($keyResource, $privatekeyenc, 'test');
$publickey = openssl_pkey_get_details($keyResource)["key"];
openssl_free_key($keyResource);

//$availablelist = openssl_get_cipher_methods(true);
//print_r($availablelist);
echo $privatekeyenc;
echo $privatekey;
echo $publickey;
