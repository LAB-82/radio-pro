<?php
// Ustaw nagłówki CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Obsłuż OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Adres strony
$url = 'https://www.muzyczneradio.pl/';

// Funkcja do pobrania zawartości
function getPageContent($url) {
    $options = [
        "http" => [
            "header" => "User-Agent: Mozilla/5.0\r\n"
        ]
    ];
    $context = stream_context_create($options);
    $content = @file_get_contents($url, false, $context);
    return $content;
}

$html = getPageContent($url);

if ($html === false) {
    echo "Nie można pobrać strony.";
    exit;
}

// Wyświetlamy zawartość
echo "<h2>Zawartość strony (debug)</h2>";
echo "<pre>" . htmlspecialchars($html) . "</pre>";
?>
