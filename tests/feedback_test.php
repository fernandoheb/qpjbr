<?php
$feedbackFile = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'feedback.php';
$src = file_get_contents($feedbackFile);

assertSame(
    400,
    qpjCaptureInclude(
        '$_GET["tempo"] = "1"; $_GET["id"] = "abc";',
        'feedback.php'
    ),
    'SQLI-02: invalid numeric query string yields HTTP 400'
);

assertTrue(
    strpos($src, 's3nh4r00t') === false
    && preg_match(
        "/executeBound\s*\(\s*'insert into feedback/",
        $src
    ),
    'SECR-03: feedback.php has no leftover password and binds insert'
);
