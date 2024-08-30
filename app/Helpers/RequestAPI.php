<?php
function encryptredVariable($credentials, $R1, $R2)
{

    $sha256 = hash('sha256', $R1 . $R2);
    $R3 = substr($sha256, 0, 16);
    $iv = substr((strrev($sha256)), 0, 16);

    if (!is_array($credentials)) {
        return encryptCredentials($credentials, $R3, $iv);
    }

    $encrypted_array = array_map(function ($credential) use ($R3, $iv) {
        return encryptCredentials($credential, $R3, $iv);
    }, $credentials);

    if (in_array(false, $encrypted_array, true)) {
        return false;
    }

    return $encrypted_array;
}

function decryptedVariable($credentials, $R1, $R2)
{
    $sha256 = hash('sha256', $R1 . $R2);
    $R3 = substr($sha256, 0, 16);
    $iv = substr((strrev($sha256)), 0, 16);

    if (!is_array($credentials)) {
        return decryptCredentials($credentials, $R3, $iv);
    }

    $decrypted_array = array_map(function ($credential) use ($R3, $iv) {
        return decryptCredentials($credential, $R3, $iv);
    }, $credentials);

    if (in_array(false, $decrypted_array, true)) {
        return false;
    }

    return $decrypted_array;
}

function decryptCredentials($credentials, $R3, $iv)
{
    try {
        if (strlen($credentials) % 2 !== 0) {
            return false;
        }

        $tag = hex2bin(substr($credentials, strlen($credentials) - 32));
        $encrypted_data = hex2bin(substr($credentials, 0, strlen($credentials) - 32));
        $decrypted_data = openssl_decrypt($encrypted_data, "aes-128-gcm", $R3, OPENSSL_RAW_DATA, $iv, $tag);

        if ($decrypted_data === false) {
            return false;
        }

        return $decrypted_data;
    } catch (Exception $e) {
        return false;
    }
}

function encryptCredentials($credentials, $R3, $iv)
{
    $encrypted_data = bin2hex(openssl_encrypt($credentials, "aes-128-gcm", $R3, OPENSSL_RAW_DATA, $iv, $tag)) . bin2hex($tag);
    if ($encrypted_data === false) {
        return false;
    }

    return $encrypted_data;
}

// Chubb API
function generateContract($contno)
{
    $minLen = 16; // minimum length
    $maxLen = 16; // maximum length
    $len = mt_rand($minLen, $maxLen); // random length
    $str = 'CNFIX';
    for ($i = 0; $i < $len - 4; $i++) {
        $randomIndex = mt_rand(0, strlen($contno) - 1);
        $randomChar = $contno[$randomIndex];
        $str .= $randomChar;
    }
    return $str;
}

// Function to generate a random string with prefix string 'SSSX'
function generateIdCus($idCard_Cus)
{
    $minLen = 10; // minimum length
    $maxLen = 10; // maximum length
    $len = mt_rand($minLen, $maxLen); // random length
    $str = 'PSXXQ';
    for ($i = 0; $i < $len - 4; $i++) {
        $randomIndex = mt_rand(0, strlen($idCard_Cus) - 1);
        $randomChar = $idCard_Cus[$randomIndex];
        $str .= $randomChar;
    }
    return $str;
}