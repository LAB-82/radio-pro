<?php
// Ustaw nagłówki CORS, jeśli potrzebujesz
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Obsłuż OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Podaj właściwy adres strony radia
$url = 'https://www.muzyczneradio.pl/'; // zamień na faktyczny adres

// Funkcja do pobrania zawartości strony
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

// Pobierz zawartość strony
$html = getPageContent($url);

if ($html === false) {
    echo "Nie można pobrać strony.";
    exit;
}

// Wyświetlenie zawartości strony - do debugowania
// echo htmlspecialchars($html);

// Szukamy pasujących fragmentów tekstu
// Przykład regex, który dopasuje wszystko od "TERAZ GRAMY" do końca linii lub do następnego znacznika
preg_match_all('/(TERAZ GRAMY[:\s]*[^\n<]+)/i', $html, $matches);

// Sprawdzamy, co znaleźliśmy
if (!empty($matches[0])) {
    echo "Znalezione fragmenty:\n";
    foreach ($matches[0] as $index => $match) {
        echo ($index + 1) . ". " . htmlspecialchars($match) . "\n";
    }
} else {
    echo "Nie znaleziono żadnych pasujących fragmentów.";
}
?>
