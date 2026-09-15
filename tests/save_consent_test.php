<?php
$saveFile = dirname(__DIR__)
    . DIRECTORY_SEPARATOR
    . 'api'
    . DIRECTORY_SEPARATOR
    . 'save-response.php';
$src = file_get_contents($saveFile);
$src = preg_replace('!/\*.*?\*/!s', '', $src);
$src = preg_replace('!//.*$!m', '', $src);

assertSame(
    400,
    qpjCaptureInclude(
        '$_GET["salvar"] = "1";',
        'saveData.php'
    ),
    'CONS-02: save without consent yields HTTP 400'
);

assertTrue(
    strpos($src, 'requireConsent') !== false
    && strpos($src, 'requireConsent') < strpos($src, 'executeBound'),
    'CONS-02: consent is required before any INSERT'
);

assertTrue(
    preg_match(
        "/executeBound\s*\(\s*'INSERT INTO `resposta`[^']*`aceitou_termo`[^']*\?/",
        $src
    )
    && preg_match(
        "/executeBound\s*\(\s*'INSERT INTO `resposta`[\s\S]*?array\s*\([\s\S]*?,\s*1\s*\)/",
        $src
    )
    && strpos($src, '`Codigo_G_Exp`') !== false,
    'CONS-03: resposta insert binds aceitou_termo to 1 and Codigo_G_Exp'
);

assertSame(
    200,
    qpjCaptureInclude('', 'saveData.php'),
    'edge: saveData.php with no write flag does not run SQL or connect'
);
