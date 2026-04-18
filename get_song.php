<?php
header("Content-Type: application/json; charset=UTF-8");

$url = 'https://www.muzyczneradio.pl/';

function fetch($url) {
    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT        => 10,
        CURLOPT_USERAGENT      => "Mozilla/5.0",
        CURLOPT_ENCODING       => "",
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false
    ]);

    $html = curl_exec($ch);
    $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if($html === false || $http !== 200){
        return null;
    }

    return $html;
}

$html = fetch($url);

if(!$html){
    echo json_encode(["error" => "fetch_failed"]);
    exit;
}

libxml_use_internal_errors(true);
$dom = new DOMDocument();
@$dom->loadHTML($html);

$xpath = new DOMXPath($dom);

$track = null;

// Próba 1 – konkretny XPath
$query = "//*[contains(@class,'now') or contains(@class,'playing') or contains(@class,'teraz') or contains(@class,'now-playing')]";
$nodes = $xpath->query($query);

foreach($nodes as $node){
    $text = trim($node->textContent);
    if(strlen($text) > 5 && strpos($text, '-') !== false){
        $track = $text;
        break;
    }
}

// Próba 2 – fallback regex
if(!$track){
    if(preg_match('/[A-Z0-9ĘÓĄŚŻŹĆŃąśłęźćń .&]+\\s?-\\s?[A-Z0-9ĘÓĄŚŻŹĆŃąśłęźćń .&]+/iu', $html, $m)){
        $track = $m[0];
    }
}

if(!$track){
    echo json_encode(["error" => "no_track_found"]);
    exit;
}

// Rozdzielenie
$parts = explode('-', $track, 2);
$artist = trim($parts[0]);
$title  = isset($parts[1]) ? trim($parts[1]) : "";

// Output
echo json_encode([
    "artist" => $artist,
    "title"  => $title,
    "full"   => $artist . " - " . $title
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
