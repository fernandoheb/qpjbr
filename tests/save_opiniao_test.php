<?php
$saveFile = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'saveData.php';
$src = file_get_contents($saveFile);
$src = preg_replace('!/\*.*?\*/!s', '', $src);
$src = preg_replace('!//.*$!m', '', $src);

preg_match(
    '/if\s*\(\s*isset\(\$_GET\["concordo"\]\)\s*\)\s*\{(.*)$/s',
    $src,
    $match
);
$opinioes = isset($match[1]) ? $match[1] : '';
preg_match_all(
    "/executeBound\s*\(\s*'([^']+)'/",
    $opinioes,
    $sqls
);
$joined = implode("\n", $sqls[1]);

assertTrue(
    count($sqls[1]) === 3
    && strpos($joined, '$_POST') === false
    && !preg_match('/\$[a-zA-Z_]/', $joined)
    && substr_count($joined, '?') >= 8,
    'SQLI-01: concordo, nconcordo, perfilIdentificado use bound ? only'
);

assertTrue(
    preg_match('/requireInt\s*\([^,]+,\s*\'respostaId\'\s*\)/', $opinioes)
    && preg_match('/requireInt\s*\([^,]+,\s*\'id\'\s*\)/', $opinioes),
    'SQLI-03: id and respostaId pass through requireInt'
);

assertTrue(
    substr_count($joined, 'INSERT INTO `concordo`') === 2
    && substr_count($joined, 'INSERT INTO `nconcordo`') === 1,
    'SQLI-04: opinion branches still write concordo and nconcordo'
);
