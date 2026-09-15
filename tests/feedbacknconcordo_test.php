<?php
$file = dirname(__DIR__)
    . DIRECTORY_SEPARATOR
    . 'api'
    . DIRECTORY_SEPARATOR
    . 'disagreement-ratings.php';
$src = file_get_contents($file);

assertTrue(
    !preg_match('/DB_PASSWORD|password\s*=/', $src),
    'feedbacknconcordo.php'
);

assertTrue(
    (bool) preg_match(
        "/executeBound\s*\(\s*'insert into nconcordo/",
        $src
    ),
    'SECR: disagreement ratings binds insert'
);
