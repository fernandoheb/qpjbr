<?php
$file = dirname(__DIR__)
    . DIRECTORY_SEPARATOR
    . 'pages'
    . DIRECTORY_SEPARATOR
    . 'questionnaire.php';
$src = file_get_contents($file);
$entry = file_get_contents(
    dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Pesquisadores.php'
);

assertTrue(
    strpos($entry, 'researchers.php') !== false,
    'FACE-00: Pesquisadores.php delegates to researchers.php'
);

assertTrue(
    strpos($src, 'FB.init') === false
    && strpos($src, 'connect.facebook.net') === false
    && strpos($src, 'fb:login-button') === false,
    'FACE-01: questionnaire has no Facebook SDK or login button'
);

assertTrue(
    strpos($src, '$_GET["name"]') === false
    && strpos($src, '$_GET["email"]') === false
    && strpos($src, '$_GET["gender"]') === false,
    'FACE-02: questionnaire does not prefill from Facebook GET params'
);
