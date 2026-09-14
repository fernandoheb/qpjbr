<?php
$saveFile = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'saveData.php';
$src = file_get_contents($saveFile);
preg_match(
    '/if\s*\(\s*isset\(\$_GET\["salvar"\]\)\s*\)\s*\{(.*?)'
    . 'if\s*\(\s*isset\(\$_GET\["concordo"\]\)/s',
    $src,
    $match
);
$salvar = isset($match[1]) ? $match[1] : '';
$salvar = preg_replace('!/\*.*?\*/!s', '', $salvar);
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
