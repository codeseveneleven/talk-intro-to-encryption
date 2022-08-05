<?php
$password = 'password';
$salt = base64_decode( '0gV9VZ//IXKyJfzvRK5zzg=='); //random_bytes(SODIUM_CRYPTO_PWHASH_SALTBYTES);

$seed = sodium_crypto_pwhash(
	32,
	$password,
	$salt,
	SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
	SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE
);
//$key = sodium_crypto_box_keypair();
echo $seed;
echo "-\n";
echo base64_encode($salt);
echo "-\n";
$key = sodium_crypto_box_seed_keypair( $seed);
$private = sodium_crypto_box_secretkey($key);
$public = sodium_crypto_box_publickey($key);
echo sha1($private);
echo "\n";
echo sha1($public);
echo "\n";
echo sha1(sodium_crypto_box_publickey_from_secretkey( $private));
echo "\n";

$nonce = random_bytes(SODIUM_CRYPTO_BOX_NONCEBYTES);
$message = sodium_crypto_box_seal('hallo', $public);

echo "\n";
echo sodium_crypto_box_seal_open($message,$key);
