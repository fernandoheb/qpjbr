<?php
$file = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'resultado.php';
$src = file_get_contents($file);

assertTrue(
    strpos($src, 'echo $_GET') === false
    && strpos($src, 'is_numeric') !== false,
    'XSS-01: GET values are numeric-checked, not echoed raw'
);

assertTrue(
    preg_match('/WHERE id = \'\s*\.\s*\(int\)\$i/', $src)
    && !preg_match('/WHERE id = \'\s*\.\s*\$_GET/', $src),
    'XSS-02: subfator SQL uses the loop integer, not a GET score'
);

assertTrue(
    preg_match(
        '/qpjQueryNumber\s*\(\s*isset\(\$_GET\["avc"\]\)/',
        $src
    )
    || preg_match(
        '/is_numeric\s*\(\s*\$_GET\["avc"\]/',
        $src
    ),
    'XSS-02: score avc is rejected when not numeric'
);
