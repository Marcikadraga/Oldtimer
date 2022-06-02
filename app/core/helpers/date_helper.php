<?php

/**
 * A helperek nem globális függvények, nem kerülnek betöltésre az index.php-ban
 * Csak akkor töltjük be a helpert, ha feltétlenül szükséges.
 * A helperfájlok betöltése a helper() globális funkcióval történik
 *
 * A helperekben lévő függvényeket át lehetne pakolni a functions.php-ba, és akkor nem lenne ennyi "gond" a betöltésükkel
 * De nem tesszük, mert csak ritkán használt függvények kerülnek ide. Csak akkor töltődnek be, ha feltétlenül szükségesek.
 */

if (!function_exists('isValidDateFormat')) {
    /**
     * Dátumformátum validálása
     * @param string $date A vizsgált string, pl egy űrlapról érkezett string
     * @param string $format Az elvárt dátumformátum (default: Y-m-d)
     * @return bool True, ha a vizsgált string formátuma azonos az elvárt formátummal | False ha nem
     */
    function isValidDateFormat(string $date, string $format = 'Y-m-d'): bool {

        $dateTime = DateTime::createFromFormat($format, $date);
        return !empty($dateTime) && $dateTime->format($format) == $date;
    }
}

if (!function_exists('compareDateString')) {
    /**
     * Két dátum jellegű string összehasonlítása
     * A két paraméter olyan string, amit a php DateTime konstruktora elfogad
     * @link https://www.php.net/manual/en/datetime.formats.php
     * @param string $larger Az időben nagyobb dátum értéke
     * @param string $smaller A kisebb dátum értéke
     * @return bool True, ha az időben nagyobb dátum később van mint a kisebb dátum
     */
    function compareDateString($larger, $smaller): bool {

        try {
            $largerDateTime = new DateTime($larger);
            $smallerDateTime = new DateTime($smaller);
            return $largerDateTime > $smallerDateTime;
        } catch (Exception $exception) {
            die('A két dátum nem hasonlítható össze, mert hiba van.');
            return false;
        }
    }
}
