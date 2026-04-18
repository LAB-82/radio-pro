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

// Adres strony radia
$url = 'https://www.muzyczneradio.pl/'; // zamień na właściwy adres

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

// Szukamy tekstu po "TERAZ GRAMY" lub podobnym wzorze
// Założenie: informacja o utworze pojawia się w tekście, np. w formacie:
// "TERAZ GRAMY: [nazwa utworu]" albo "Teraz gram [nazwa utworu]"
preg_match('/TERAZ GRAMY[:\s]*([\w\s\-\&\']+)</i', $html, $matches);

// Jeśli nie znajdzie, próbujemy inny wzór
if (empty($matches)) {
    preg_match('/Teraz gram\s*([\w\s\-\&\']+)</i', $html, $matches);
}

// Wyświetlamy wynik
if (isset($matches[1])) {
    $currentSong = trim($matches[1]);
    echo htmlspecialchars($currentSong);
} else {
    echo "Nie znaleziono informacji o utworze.";
}
?>
