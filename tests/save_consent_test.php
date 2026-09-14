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
    )
    && preg_match(
        "/executeBound\s*\(\s*'INSERT INTO `resposta`[\s\S]*?array\s*\([\s\S]*?,\s*1\s*\)/",
        $salvar
    )
    && strpos($salvar, '`Codigo_G_Exp`') !== false,
    'CONS-03: resposta insert binds aceitou_termo to 1 and Codigo_G_Exp'
);

assertSame(
    200,
    qpjCaptureInclude('', 'saveData.php'),
    'edge: saveData.php with no write flag does not run SQL or connect'
);
