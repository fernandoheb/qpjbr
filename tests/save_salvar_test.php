<?php
$saveFile = dirname(__DIR__)
    . DIRECTORY_SEPARATOR
    . 'api'
    . DIRECTORY_SEPARATOR
    . 'save-response.php';
$src = file_get_contents($saveFile);
$salvar = preg_replace('!/\*.*?\*/!s', '', $src);
$salvar = preg_replace('!//.*$!m', '', $salvar);

preg_match_all(
    "/executeBound\s*\(\s*'([^']+)'/",
    $salvar,
    $sqls
);
$joined = implode("\n", $sqls[1]);

assertTrue(
    $joined !== ''
    && strpos($joined, '$_POST') === false
    && !preg_match('/\$[a-zA-Z_]/', $joined),
    'SQLI-01: salvar bound SQL has no POST or interpolated vars'
);

assertTrue(
    preg_match('/requireInt\s*\([^,]+,\s*\'questaoid\'\s*\)/', $salvar)
    && preg_match(
        '/requireInt\s*\([^,]+,\s*\'valorResposta\'\s*\)/',
        $salvar
    ),
    'SQLI-03: questao id and value pass through requireInt'
);

assertTrue(
    strpos($joined, 'INSERT INTO `resposta`') !== false
    && strpos($joined, 'INSERT INTO `resp_quest`') !== false
    && strpos($joined, 'INSERT INTO `soma`') !== false,
    'SQLI-04: salvar still writes resposta, resp_quest, soma'
);
