<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'functions.inc2.php';

assertTrue(
    boundQueryAllowed(
        'INSERT INTO resposta (nome) VALUES (?)',
        array('alice')
    ),
    'SQLI-03: SQL with matching placeholders is allowed'
);

assertTrue(
    !boundQueryAllowed(
        'INSERT INTO resposta (nome, email) VALUES (?, ?)',
        array('alice')
    ),
    'SQLI-03: placeholder count must match values'
);

assertTrue(
    !boundQueryAllowed(
        "INSERT INTO resposta (nome) VALUES ('" . "OR 1=1" . "')",
        array('OR 1=1')
    ),
    'SQLI-01: quoted interpolation in SQL is rejected'
);

assertSame(
    400,
    qpjCaptureStatus("requireInt('1 OR 1=1', 'idade');"),
    'SQLI-03: garbage integer yields HTTP 400'
);

assertSame(
    400,
    qpjCaptureStatus("requireInt('', 'idade');"),
    'SQLI-03: missing numeric field yields HTTP 400'
);

assertSame(
    400,
    qpjCaptureStatus("requireConsent('0');"),
    'CONS-02: consent other than 1 yields HTTP 400'
);
