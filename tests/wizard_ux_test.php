<?php
$index = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'index.php';
$src = file_get_contents($index);

assertTrue(
    preg_match(
        '/<button\b([^>]*)>\s*Continuar/i',
        $src,
        $continuar
    ) === 1
    && preg_match('/\bdisabled\b/i', $continuar[1]) === 1,
    'WIZ-01: Continuar starts disabled while consent is unchecked'
);

$tracksConsent = preg_match(
    '/aceitou_termo[\s\S]{0,1200}disabled\s*=\s*!/i',
    $src
) === 1;
$onChange = preg_match(
    '/#aceitou_termo["\']\s*\)\.on\(\s*["\']change["\']/i',
    $src
) === 1
    || preg_match(
        '/aceitou_termo["\']\s*\)[\s\S]{0,200}addEventListener\(\s*["\']change["\']/i',
        $src
    ) === 1;
assertTrue(
    $tracksConsent && $onChange,
    'WIZ-02/WIZ-03: Continuar enabled only while aceitou_termo is checked'
);
