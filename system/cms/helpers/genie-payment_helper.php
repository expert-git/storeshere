<?php

function encrypt_pol($string) {
    $key            = "A4GE_G5D73"; 
    $result         = '';
    $test           = "";
    
    for($i=0; $i<strlen($string); $i++) {
        $char       = substr($string, $i, 1);
        $keychar    = substr($key, ($i % strlen($key))-1, 1);
        $char       = chr(ord($char)+ord($keychar));
        $test[$char]= ord($char)+ord($keychar);
        $result.=$char;
    }
    return urlencode(base64_encode($result));
}

function decrypt_pol($string) {
    $string = urlencode($string);
    
  $key = "A4GE_G5D73"; //key to encrypt and decrypts.
            $result = '';
            $string = base64_decode(urldecode($string));
            for($i=0; $i<strlen($string); $i++) {
                $char = substr($string, $i, 1);
                $keychar = substr($key, ($i % strlen($key))-1, 1);
                $char = chr(ord($char) - ord($keychar));
                $result.=$char;
            }
    
    return $result;
}