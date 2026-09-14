<?php
$file = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Pesquisadores.php';
$src = file_get_contents($file);

assertTrue(
    strpos($src, 'FB.init') === false
    && strpos($src, 'connect.facebook.net') === false
    && strpos($src, 'fb:login-button') === false,
    'FACE-01: Pesquisadores.php has no Facebook SDK or login button'
);

assertTrue(
    strpos($src, '$_GET["name"]') === false
    && strpos($src, '$_GET["email"]') === false
    && strpos($src, '$_GET["gender"]') === false,
    'FACE-02: Pesquisadores.php does not prefill from Facebook GET params'
);
