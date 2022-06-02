<?php

/*
 * Adatbázis-kapcsolati adatok
 *
 * FONTOS!
 * Éles rendszerben soha nem a root fiókkal csatlakozunk az adatbázishoz!
 * Éles rendszerben az adatbázis-usernek mindig van jelszava (erős jelszava)!
 *
 * Az adatbázis-user jogait a projektnek megfelelően kell meghatározni:
 * SELECT mindig kell, INSERT és UPDATE általában kell, DELETE néha kell
 * Szerkezetre és adminisztrációra nem kaphat jogot az user (ALTER TABLE, CREATE USER stb.)
 *
 * Éles rendszerekben a szerveren célszerű beállítani az adatbáziskapcsolat ip-szűrését
 * Az adatbázishoz jó beállítások esetén kizárólag ez a program tud csatlakozni
 * Ez a három beállítás a szerveren történik meg, független ettől a programtól
 */
return [
    'DB_HOST'     => 'localhost',
    'DB_NAME'     => 'marci',
    'DB_CHARSET'  => 'utf8',
    'DB_USER'     => 'root',
    'DB_PASSWORD' => ''
];
