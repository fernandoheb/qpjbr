<?php
$functionsFile = dirname(__DIR__)
    . DIRECTORY_SEPARATOR
    . 'functions.inc2.php';
$src = file_get_contents($functionsFile);

assertTrue(
    strpos($src, 'bd.cfg') === false,
    'resolveDbConfig must not read bd.cfg'
);

assertTrue(
    strpos($src, "loadDotEnv(dirname(__FILE__) . '/.env')") !== false
    && strpos($src, 'envOr(') !== false
    && strpos($src, '$parsed') !== false,
    'DB config is loaded from .env via loadDotEnv'
);
