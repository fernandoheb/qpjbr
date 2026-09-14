<?php
$srcFile = dirname(__DIR__)
    . DIRECTORY_SEPARATOR
    . 'feedbacknconcordo.php';
$src = file_get_contents($srcFile);

assertSame(
    400,
    qpjCaptureInclude(
        '$_GET["id"] = "abc";',
        'feedbacknconcordo.php'
    ),
    'SQLI-02: invalid id yields HTTP 400'
);

assertTrue(
    strpos($src, 's3nh4r00t') === false
    && preg_match(
        "/executeBound\s*\(\s*'insert into nconcordo/",
        $src
    ),
    'SECR-03: disagreement file has no leftover password and binds insert'
);
