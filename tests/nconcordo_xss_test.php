<?php
$nconcordo = dirname(__DIR__)
    . DIRECTORY_SEPARATOR
    . 'disagreement.php';
$src = file_get_contents($nconcordo);

assertTrue(
    strpos($src, 'htmlspecialchars') !== false
    || strpos($src, 'htmlentities') !== false
    || preg_match('/echo\s+\$aux/', $src) === 0,
    'XSS-01: disagreement.php escapes echoed id'
);
