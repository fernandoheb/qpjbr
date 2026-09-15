<?php
$feedbackFile = dirname(__DIR__)
    . DIRECTORY_SEPARATOR
    . 'api'
    . DIRECTORY_SEPARATOR
    . 'result-metrics.php';
$src = file_get_contents($feedbackFile);

assertTrue(
    !preg_match('/DB_PASSWORD|password\s*=/', $src),
    'feedback.php'
);

assertTrue(
    (bool) preg_match(
        "/executeBound\s*\(\s*'insert into feedback/",
        $src
    ),
    'SECR-03: feedback.php has no leftover password and binds insert'
);
