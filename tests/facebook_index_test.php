<?php
$index = dirname(__DIR__)
    . DIRECTORY_SEPARATOR
    . 'pages'
    . DIRECTORY_SEPARATOR
    . 'questionnaire.php';
$src = file_get_contents($index);

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

assertTrue(
    strpos($src, 'name="nomeApelido"') !== false
    && strpos($src, 'name="idade"') !== false
    && strpos($src, 'name="email"') !== false
    && strpos($src, 'name="escolaridade"') !== false
    && strpos($src, 'name="generoSexual"') !== false,
    'FACE-03: manual registration fields remain after Facebook removal'
);
