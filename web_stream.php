<?php
ini_set('max_execution_time', 0);
$useragent = "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.96 Safari/537.36";
//function Scramble($msg_text){ // ENCRYPT
//        $msg_text = openssl_encrypt($msg_text, 'aes-256-cbc', 'YOUR_ENCRYPT_KEY' , 0, '1234567890123456');           
//        return $msg_text;
//}
//function Descramble($data){ // DECRYPT
//    $return = openssl_decrypt($data, 'aes-256-cbc', 'YOUR_ENCRYPT_KEY', 0, '1234567890123456');
//    return $return;
//}
//$decrypted = DecryptData($_GET['q']);
//$v = urldecode($decrypted).'?other_link_parameters..';
$v = urldecode($_GET['q']).'?other_link_parameters..';
$ch = curl_init();
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 222222);
curl_setopt($ch, CURLOPT_URL, $v);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
curl_setopt($ch, CURLOPT_NOBODY, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$info = curl_exec($ch);
$size2 = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
header("Content-Type: video/mp4");
$filesize = $size2;
$offset = 0;
$length = $filesize;
if (isset($_SERVER['HTTP_RANGE'])) {
    $partialContent = "true";
    preg_match('/bytes=(\d+)-(\d+)?/', $_SERVER['HTTP_RANGE'], $matches);
    $offset = intval($matches[1]);
    $length = $size2 - $offset - 1;
} else {
    $partialContent = "false";
}
if ($partialContent == "true") {
    header('HTTP/1.1 206 Partial Content');
    header('Accept-Ranges: bytes');
    header('Content-Range: bytes '.$offset.
        '-'.($offset + $length).
        '/'.$filesize);
} else {
    header('Accept-Ranges: bytes');
}
header("Content-length: ".$size2);


$ch = curl_init();
if (isset($_SERVER['HTTP_RANGE'])) {
    // if the HTTP_RANGE header is set we're dealing with partial content
    $partialContent = true;
    // find the requested range
    // this might be too simplistic, apparently the client can request
    // multiple ranges, which can become pretty complex, so ignore it for now
    preg_match('/bytes=(\d+)-(\d+)?/', $_SERVER['HTTP_RANGE'], $matches);
    $offset = intval($matches[1]);
    $length = $filesize - $offset - 1;
    $headers = array(
        'Range: bytes='.$offset.
        '-'.($offset + $length).
        ''
    );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
}
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 222222);
curl_setopt($ch, CURLOPT_URL, $v);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
curl_setopt($ch, CURLOPT_NOBODY, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
curl_exec($ch);
