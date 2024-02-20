<?php
$algorithm =  "aes-256-cbc";
$keyResource = openssl_pkey_new([
	"digest_alg" =>'sha256',
	"private_key_bits" => 4096,
	"private_key_type" => OPENSSL_KEYTYPE_RSA,
]);
openssl_pkey_export($keyResource, $private_key);
$public_key = openssl_pkey_get_details($keyResource)["key"];
//openssl_free_key($keyResource);

$strong = null;
$iv_length = openssl_cipher_iv_length($algorithm);
//var_dump($iv_length);
$iv  = openssl_random_pseudo_bytes($iv_length,$strong);
//var_dump($strong);
$pub = openssl_pkey_get_public( $public_key);

$message = 'hello confoo 2024';

$result = openssl_seal(
	str_pad( $message, strlen($message) + 16 - strlen($message) % 16,  "\0"),
	$sealed,
	$encryption_keys,
	[$pub],
	$algorithm,
	$iv
);

echo "SEALED: ".$sealed,"\n";

$private = openssl_pkey_get_private( $private_key );
$result - openssl_open(
	$sealed,
	$opened,
	$encryption_keys[0],
	$private,
	$algorithm,
	$iv
);
//openssl_free_key($private);
echo "OPENED: ". $opened,"\n";

