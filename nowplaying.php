<?php
header("Content-Type: application/json; charset=UTF-8");

$url = "https://stream.rcs.revma.com/gzwc1xcq042vv";

$opts = [
    "http" => [
        "method" => "GET",
        "header" => "Icy-MetaData: 1\r\n"
    ]
];

$context = stream_context_create($opts);
$stream = fopen($url, 'r', false, $context);

if (!$stream) {
    echo json_encode(["error" => "connection_failed"]);
    exit;
}

$metaInt = null;
foreach ($http_response_header as $h) {
    if (stripos($h, 'icy-metaint') !== false) {
        $metaInt = (int) explode(":", $h)[1];
    }
}

if (!$metaInt) {
    echo json_encode(["error" => "no_metadata"]);
    exit;
}

fread($stream, $metaInt);
$len = ord(fread($stream, 1)) * 16;
$meta = fread($stream, $len);

if (preg_match("/StreamTitle='([^']*)'/", $meta, $m)) {
    echo json_encode([
        "title" => $m[1]
    ]);
} else {
    echo json_encode(["title" => "Brak danych"]);
}

fclose($stream);
