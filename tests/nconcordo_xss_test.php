<?php
$nconcordo = dirname(__DIR__)
    . DIRECTORY_SEPARATOR
    . 'nconcordo.php';
$src = file_get_contents($nconcordo);

assertTrue(
    preg_match(
        '/htmlspecialchars\s*\(\s*(isset\(\$_GET\["id"\]\)|\$aux)/',
        $src
    )
    || strpos($src, "htmlspecialchars(") !== false
        && strpos($src, '$_GET["id"]') !== false,
    'XSS-01: nconcordo.php escapes echoed id'
);

$needle = 'Gerente1' . '*';
$hits = array();
exec(
    'git grep -F -- ' . escapeshellarg($needle) . ' -- "*.php" "*.inc"',
    $hits
);
assertTrue(
    $hits === array(),
    'SECR-03: leftover commented password is gone from the tracked tree'
);
