<?php
$root = dirname(__DIR__);
$ignore = file_get_contents($root . DIRECTORY_SEPARATOR . '.gitignore');
$required = array(
    'teste/',
    'CurPhpVersion.php',
    'adminMeusAnuncios.inc.php',
    'vendor/jquery-file-upload/server/php/',
    'experimental.sql',
    'experimental2.sql',
    'banco_de_dados.sql',
    'Estrutura_banco_de_dados.sql',
);

$missing = array();
foreach ($required as $path) {
    if (strpos($ignore, $path) === false) {
        $missing[] = $path;
    }
}
assertTrue(
    $missing === array(),
    'SURF-02: gitignore lists dead files and extra dumps'
);

$tracked = array();
exec('git ls-files -- ' . implode(' ', array_map('escapeshellarg', $required)), $tracked);
$indexHtml = array();
exec('git ls-files -- index.html', $indexHtml);
$onDisk = true;
foreach ($required as $path) {
    $full = $root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $path);
    if (!file_exists($full)) {
        $onDisk = false;
        break;
    }
}
assertTrue(
    $tracked === array()
    && $onDisk
    && $indexHtml === array('index.html'),
    'SURF-01 SURF-06: dead paths untracked, still on disk, index.html stays'
);
