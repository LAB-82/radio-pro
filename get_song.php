<?php
// get_song.php

// Adres strony radia, którą chcesz pobrać
$url = 'https://przykladowastrona.radiosite.pl';

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

// Użyj DOMDocument i DOMXPath do wyodrębnienia informacji
$doc = new DOMDocument();
libxml_use_internal_errors(true);
$doc->loadHTML($html);
libxml_clear_errors();

$xpath = new DOMXPath($doc);

// Zmień poniższy selektor na odpowiedni do Twojej strony, np.:
// $selector = "//div[@id='current-song']";
$selector = "//div[@class='nazwa-klasy']"; // lub inny selektor

$elements = $xpath->query($selector);

if ($elements->length > 0) {
    $songInfo = trim($elements->item(0)->textContent);
    echo htmlspecialchars($songInfo);
} else {
    echo "Nie znaleziono informacji o utworze.";
}
?>
