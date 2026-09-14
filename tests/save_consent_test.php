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

assertSame(
    400,
    qpjCaptureInclude(
        '$_GET["salvar"] = "1";',
        'saveData.php'
    ),
    'CONS-02: save without consent yields HTTP 400'
);

assertTrue(
    strpos($salvar, 'requireConsent') !== false
    && strpos($salvar, 'requireConsent') < strpos($salvar, 'executeBound'),
    'CONS-02: consent is required before any INSERT'
);

assertTrue(
    preg_match(
        "/executeBound\s*\(\s*'INSERT INTO `resposta`[^']*`aceitou_termo`[^']*\?/",
        $salvar
    ),
    'CONS-03: resposta insert binds aceitou_termo'
);
