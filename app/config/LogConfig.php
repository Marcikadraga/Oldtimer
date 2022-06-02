<?php

/*
 * A rendszerlog konfigurációja
 *
 * folderRelativePath: a logfájlokat tartalmazó mappa relatív elérési útja (záró slash kötelező!)
 * folderAbsolutePath: a logfájlokat tartalmazó mappa elérési útja a szerveren (záró slash kötelező!)
 * dateFormat: a logbejegyzésekben alkalmazott dátumformátum (PHP DateTime konstruktora által elfogadott formátum)
 * logTypes: a különböző eseményekhez tartozó logtípusok (mappanevek lesznek a log folderben, ezért spec karaktereket nem használhatunk)
 */
return [
    'folderRelativePath' => '../writable/logs/',
    'folderAbsolutePath' => 'www/marci/writable/logs/',
    'dateFormat'         => 'Y-m-d H:i:s',
    'logTypes'           => ['email', 'pdo'],
];
