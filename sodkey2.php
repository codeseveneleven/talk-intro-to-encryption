<?php
$password = 'My very secure initial password';
// $salt = random_bytes(SODIUM_CRYPTO_PWHASH_SALTBYTES);
$salt = base64_decode('ilQ13o6HZLldF3BESlFsAw=='); // generated with random_bytes(SODIUM_CRYPTO_PWHASH_SALTBYTES);

$seed = sodium_crypto_pwhash(
	32,
	$password,
	$salt,
	SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
	SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE
);

//$key = sodium_crypto_box_keypair();
echo 'Seed: '. $seed;
echo "-\n";
echo 'Salt: '.base64_encode($salt);
echo "-\n";
$key = sodium_crypto_box_seed_keypair( $seed );
$private = sodium_crypto_box_secretkey( $key );
$public = sodium_crypto_box_publickey( $key );
echo 'Checksum Private: '.sha1($private);
echo "\n";
echo 'Checksum Public: '.sha1($public);
echo "\n";
echo 'Checksum Public Cryptobox: '.sha1(sodium_crypto_box_publickey_from_secretkey( $private ));
echo "\n";

$nonce = random_bytes(SODIUM_CRYPTO_BOX_NONCEBYTES);
$message = 'Hello / Bonjour ConFoo 2024!';
$sealed = sodium_crypto_box_seal(
	sodium_pad($message, 32)
	, $public
);

echo "\n";
echo sodium_unpad(
	sodium_crypto_box_seal_open($sealed,$key),
	32
);
