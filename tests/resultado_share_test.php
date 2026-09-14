<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'functions.inc2.php';

assertSame(
    3.5,
    qpjSomaPositivos(array(1, 2.5, -4, 0)),
    'DIV-01: sum only positive profile scores'
);
assertSame(
    0.0,
    qpjSomaPositivos(array(-1, 0, -0.5)),
    'DIV-01: all non-positive scores sum to 0'
);
assertSame(
    0.0,
    qpjSomaPositivos(array()),
    'DIV-01: empty profile list sums to 0'
);

assertSame(
    1,
    qpjDistanciaDoTopo(2, 2, 0),
    'DIV-01: zero positive sum does not divide'
);
assertSame(
    0.0,
    qpjDistanciaDoTopo(2, 2, 4),
    'DIV-02: top profile sits at distance 0'
);

$src = file_get_contents(
    dirname(__DIR__) . DIRECTORY_SEPARATOR . 'resultado.php'
);
assertTrue(
    strpos($src, 'qpjSomaPositivos') !== false
    && strpos($src, 'qpjDistanciaDoTopo') !== false
    && preg_match(
        '/^[^\/\n]*while\s*\(\s*\$i\s*<\s*10\s*\)/m',
        $src
    ) !== 1,
    'DIV-02: profile loops use helpers/count, not a literal 10'
);
