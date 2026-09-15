<?php
$functionsFile = dirname(__DIR__)
    . DIRECTORY_SEPARATOR
    . 'src'
    . DIRECTORY_SEPARATOR
    . 'Db'
    . DIRECTORY_SEPARATOR
    . 'Crud.php';
$src = file_get_contents($functionsFile);
preg_match(
    '/function conn\(\)\s*\{(.*?)\n   function /s',
    $src,
    $match
);
$body = isset($match[1]) ? $match[1] : '';

assertTrue(
    strpos($body, 'Não foi possível conectar ao banco') !== false
    && !preg_match('/echo[^;]*DB_PASSWORD/', $body),
    'SECR-01: conn() echoes only the generic message'
);

assertTrue(
    !preg_match(
        '/echo[^;]*(DB_HOSTNAME|DB_USERNAME|DB_PASSWORD)/',
        $body
    ),
    'SECR-02: conn() does not echo host, user, or password'
);
