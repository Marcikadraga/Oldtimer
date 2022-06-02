<?php

/**
 * Globális funkciók, az index.php-ban kerül becsatolásra a rendszerbe.
 * Az itt lévő függvények mindenhol elérhetők és szabadon használhatók.
 *
 * A view-ban lehetőleg azért ne használd, de nem azért mert nem működik,
 * hanem azért mert a view már csak előkészített adatokat kaphat (logika nincs benne)
 */

/**
 * Helperfájlok betöltése
 * @param string|string[] $helper A betöltendő helper vagy helperek
 * @return void
 */
function helper($helper): void {

    if (is_string($helper)) {
        $helper = [$helper];
    }
    if (!is_array($helper)) {
        die('A helper nem string és nem array.');
    }

    foreach ($helper as $item) {
        $path = '../app/core/helpers/' . $item . '_helper.php';
        if (!is_file($path)) {
            die('A következő helperfájl nem létezik: ' . $path);
        }

        include $path;
    }
}

/**
 * Session indítása, ha még nem indult el
 * Ha SESSION_SAVE_PATH definiálva van, akkor beállításra kerül a session fájlok helye is
 */
function sessionStart(): void {

    if (session_status() === PHP_SESSION_NONE) {
        if (defined('SESSION_SAVE_PATH') && !empty(SESSION_SAVE_PATH)) {
            session_save_path(SESSION_SAVE_PATH);
        }
        session_start();
    }
}

/**
 * A paraméterben kapott uri stringet kiegészíti a domain névvel
 * A függvény az uri stringnek megfelelő teljes elérési utat adja vissza
 * @param string $uri
 * @return string Az uri abszolút elérési útja, záró "/" jellel ellátva
 */
function baseUrl($uri = ''): string {

    $uri = str_starts_with($uri, '/') ? substr($uri, 1) : $uri;
    $baseUrl = DOMAINNAME . $uri;
    return !str_ends_with($baseUrl, '/') ? $baseUrl . '/' : $baseUrl;
}

/**
 * Rendszerbeállítás lekérdezése
 * @return bool True esetén a rendszer fejlesztői módban van | False esetén éles a rendszer
 */
function isDevMode(): bool {
    return defined('CI_ENVIRONMENT') && CI_ENVIRONMENT == 'development';
}
