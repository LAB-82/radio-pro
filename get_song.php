<?php
header("Content-Type: application/json; charset=UTF-8");

// ===== URL =====
$url = 'https://www.muzyczneradio.pl/';

// ===== CURL =====
function fetch($url){
    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_USERAGENT => "Mozilla/5.0",
        CURLOPT_ENCODING => ""
    ]);

    $html = curl_exec($ch);
    curl_close($ch);

    return $html;
}

$html = fetch($url);

if(!$html){
    echo json_encode(["error" => "fetch_failed"]);
    exit;
}

// ===== PARSER =====
libxml_use_internal_errors(true);
$dom = new DOMDocument();
$dom->loadHTML($html);

$xpath = new DOMXPath($dom);

// ===== PRÓBA 1 (najczęstsza struktura) =====
$query = "//div[contains(@class,'teraz') or contains(@class,'now-playing')]";
$nodes = $xpath->query($query);

$track = null;

foreach($nodes as $node){
    $text = trim($node->textContent);

    if(strlen($text) > 5 && strpos($text, '-') !== false){
        $track = $text;
        break;
    }
}

// ===== PRÓBA 2 (fallback – szukanie tekstu globalnie) =====
if(!$track){
    if(preg_match('/([A-Z0-9 .&]+)\s-\s([A-Z0-9 .&]+)/i', $html, $m)){
        $track = $m[0];
    }
}

// ===== BRAK DANYCH =====
if(!$track){
    echo json_encode(["error" => "no_track_found"]);
    exit;
}

// ===== ROZDZIELENIE =====
$parts = explode('-', $track, 2);

$artist = trim($parts[0]);
$title  = isset($parts[1]) ? trim($parts[1]) : "";

// ===== OUTPUT =====
echo json_encode([
    "artist" => $artist,
    "title" => $title,
    "full" => $artist . " - " . $title
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
