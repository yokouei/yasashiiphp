<?php
// The string to encrypt
$data = 'Account number: 213-1158238-23; PIN: 2837';
// The secret key to encrypt it with
$key  = "Perhaps Looking-glass milk isn't good to drink";

// Select an algorithm and encryption mode
$algorithm = MCRYPT_BLOWFISH;
$mode = MCRYPT_MODE_CBC;
// Create an initialization vector
$iv = mcrypt_create_iv(mcrypt_get_iv_size($algorithm,$mode),
                       MCRYPT_DEV_URANDOM);

// Encrypt the data
$encrypted_data = mcrypt_encrypt($algorithm, $key, $data, $mode, $iv);

// Decrypt the data
$decrypted_data = mcrypt_decrypt($algorithm, $key, $encrypted_data, $mode, $iv);

print "The decoded data is $decrypted_data";
?>