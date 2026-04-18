<?php

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
    die("Brak połączenia");
}

// znajdź metaint
$metaInt = null;
foreach ($http_response_header as $h) {
    if (stripos($h, 'icy-metaint') !== false) {
        $metaInt = (int) explode(":", $h)[1];
    }
}

if (!$metaInt) {
    die("Brak metadata");
}

// pomiń audio
fread($stream, $metaInt);

// długość metadata
$len = ord(fread($stream, 1)) * 16;

$meta = fread($stream, $len);

// wyciągnij tytuł
if (preg_match("/StreamTitle='([^']*)'/", $meta, $m)) {
    echo json_encode([
        "now_playing" => $m[1]
    ]);
} else {
    echo json_encode(["error" => "no_data"]);
}

fclose($stream);
