<?php
$root = dirname(__DIR__);
$ignore = file_get_contents($root . DIRECTORY_SEPARATOR . '.gitignore');
$required = array(
    '*.cfg',
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

$trackedPaths = array(
    'teste/',
    'CurPhpVersion.php',
    'adminMeusAnuncios.inc.php',
    'vendor/jquery-file-upload/server/php/',
    'experimental.sql',
    'experimental2.sql',
    'banco_de_dados.sql',
    'Estrutura_banco_de_dados.sql',
);
$tracked = array();
exec(
    'git ls-files -- ' . implode(' ', array_map('escapeshellarg', $trackedPaths)),
    $tracked
);
$indexHtml = array();
exec('git ls-files -- index.html', $indexHtml);
assertTrue(
    $tracked === array() && $indexHtml === array('index.html'),
    'SURF-01 SURF-06: dead paths untracked, index.html stays'
);

$web = file_get_contents($root . DIRECTORY_SEPARATOR . 'web.config');
assertTrue(
    strpos($web, 'directoryBrowse enabled="false"') !== false
    && strpos($web, 'fileExtension=".cfg"') !== false
    && strpos($web, 'fileExtension=".sql"') !== false
    && preg_match('/allowed="false"/', $web),
    'SURF-04: IIS listing off and .cfg/.sql blocked'
);

$gaps = file_get_contents($root . DIRECTORY_SEPARATOR . 'GAPS.md');
$gapMissing = array();
foreach ($trackedPaths as $path) {
    if (strpos($gaps, $path) === false) {
        $gapMissing[] = $path;
    }
}
assertTrue(
    $gapMissing === array()
    && strpos($gaps, 'index.html') !== false,
    'SURF-03 SURF-05: GAPS.md has a card per untracked path'
);
