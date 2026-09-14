<?php
$index = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'index.php';
$src = file_get_contents($index);

assertTrue(
    preg_match(
        '/<input[^>]*name="aceitou_termo"[^>]*>/',
        $src
    )
    && !preg_match(
        '/<input[^>]*name="aceitou_termo"[^>]*checked/i',
        $src
    ),
    'CONS-01: consent checkbox exists and starts unchecked'
);

preg_match(
    '/\$\("\.submitQuestionario"\)\.click\(function.*?url\s*:\s*[\'"]\.\/saveData\.php\?salvar/s',
    $src,
    $click
);
$handler = isset($click[0]) ? $click[0] : '';
assertTrue(
    $handler !== ''
    && strpos($handler, 'aceitou_termo') !== false
    && preg_match('/checked|is\([\'"]:checked[\'"]\)/', $handler),
    'CONS-02: submit without checkbox does not call saveData.php?salvar'
);

assertTrue(
    strpos($src, 'name="nomeApelido"') !== false
    && strpos($src, 'name="idade"') !== false
    && strpos($src, 'name="email"') !== false
    && strpos($src, 'name="escolaridade"') !== false
    && strpos($src, 'name="generoSexual"') !== false,
    'FACE-03: manual name, age, email, education, gender remain'
);
