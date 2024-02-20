<?php

$algorithm =  "aes-256-cbc";

$keyResource = openssl_pkey_new([
	"digest_alg" => "sha256",
	"private_key_bits" => 4096,
	"private_key_type" => OPENSSL_KEYTYPE_RSA,
]);
openssl_pkey_export($keyResource, $private_key);
$public_key = openssl_pkey_get_details($keyResource)["key"];



$iv  = openssl_random_pseudo_bytes(
	openssl_cipher_iv_length($algorithm),
	$strong
);
$pub = openssl_pkey_get_public( $public_key);

$message = 'Bonjour ConFoo!!';
openssl_seal(
	str_pad( $message, strlen($message) + 16 - strlen($message) % 16,  "\0"),
	$sealed,
	$encryption_keys,
	[$pub],
	$algorithm,
	$iv
);


//$iv = bin2hex($iv);

$envelope  = base64_encode(serialize([
	$algorithm,
	$iv,
	$encryption_keys,
	$sealed
]));

echo "This is what we store or send: ".$envelope."\n\n";

[$algorithm,$iv,$encryption_keys,$sealed] = unserialize(base64_decode( $envelope));


$private = openssl_pkey_get_private( $private_key);
openssl_open($sealed,$opened,$encryption_keys[0],$private,$algorithm,$iv);

echo "The Message: ".$opened,"\n\n";
