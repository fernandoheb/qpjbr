<?php
$envFile = dirname(__DIR__)
    . DIRECTORY_SEPARATOR
    . 'src'
    . DIRECTORY_SEPARATOR
    . 'Config'
    . DIRECTORY_SEPARATOR
    . 'Env.php';
$src = file_get_contents($envFile);

assertTrue(
    strpos($src, 'bd.cfg') === false,
    'resolveDbConfig must not read bd.cfg'
);

assertTrue(
    strpos($src, 'loadDotEnv(') !== false
    && strpos($src, 'envOr(') !== false
    && strpos($src, '$parsed') !== false
    && strpos($src, '.env') !== false,
    'DB config is loaded from .env via loadDotEnv'
);
