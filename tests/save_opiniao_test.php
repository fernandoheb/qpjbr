<?php
$opinion = file_get_contents(
    dirname(__DIR__)
    . DIRECTORY_SEPARATOR
    . 'api'
    . DIRECTORY_SEPARATOR
    . 'save-opinion.php'
);
$disagree = file_get_contents(
    dirname(__DIR__)
    . DIRECTORY_SEPARATOR
    . 'api'
    . DIRECTORY_SEPARATOR
    . 'save-disagreement.php'
);
$opinioes = preg_replace('!/\*.*?\*/!s', '', $opinion . "\n" . $disagree);
$opinioes = preg_replace('!//.*$!m', '', $opinioes);

preg_match_all(
    "/executeBound\s*\(\s*'([^']+)'/",
    $opinioes,
    $sqls
);
$joined = implode("\n", $sqls[1]);

assertTrue(
    count($sqls[1]) === 2
    && strpos($joined, '$_POST') === false
    && !preg_match('/\$[a-zA-Z_]/', $joined)
    && substr_count($joined, '?') >= 5,
    'SQLI-01: opinion and disagreement use bound ? only'
);

assertTrue(
    preg_match('/requireInt\s*\([^,]+,\s*\'respostaId\'\s*\)/', $opinioes)
    && preg_match('/requireInt\s*\([^,]+,\s*\'id\'\s*\)/', $opinioes),
    'SQLI-03: id and respostaId pass through requireInt'
);

assertTrue(
    substr_count($joined, 'INSERT INTO `concordo`') === 1
    && substr_count($joined, 'INSERT INTO `nconcordo`') === 1,
    'SQLI-04: opinion branches still write concordo and nconcordo'
);
