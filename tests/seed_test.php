<?php
$seed = dirname(__DIR__)
    . DIRECTORY_SEPARATOR
    . 'sql'
    . DIRECTORY_SEPARATOR
    . 'qpjbr.sql';
$src = file_get_contents($seed);

assertTrue(
    preg_match(
        '/`aceitou_termo`\s+TINYINT\s+NOT NULL\s+DEFAULT\s+0/i',
        $src
    )
    && strpos($src, 'fernando.heb@gmail.com') === false
    && strpos($src, '123lab') === false,
    'SECR-04 CONS-03: seed has consent column and no test PII or 123lab'
);

assertTrue(
    strpos($src, 'INSERT INTO `questao`') !== false
    && strpos($src, 'INSERT INTO `escala`') !== false
    && strpos($src, 'INSERT INTO `fator`') !== false
    && strpos($src, 'INSERT INTO `subfator`') !== false,
    'CONS-04: catalog inserts remain'
);
