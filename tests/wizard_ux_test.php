<?php
$index = dirname(__DIR__)
    . DIRECTORY_SEPARATOR
    . 'pages'
    . DIRECTORY_SEPARATOR
    . 'questionnaire.php';
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

assertTrue(
    strpos($src, 'function callalert') === false
    && !preg_match('/callalert\s*\(/', $src)
    && strpos($src, "swal('Perguntas de importância'") === false
    && strpos($src, "swal('Perguntas de gosto e frequência'") === false
    && strpos($src, "swal('Perguntas gerais'") === false,
    'WIZ-04: section copy is not shown as SweetAlert'
);

assertTrue(
    substr_count($src, 'sessao-intro') === 3
    && strpos(
        $src,
        'Responda as questões da seção seguinte pensando na importância que você confere ao que é perguntado ou afirmado.'
    ) !== false
    && strpos(
        $src,
        'Responda as questões da seção seguinte pensando no quanto você gosta dos itens enunciados e com que frequência você faz as ações perguntadas.'
    ) !== false
    && strpos(
        $src,
        'Para finalizar, responda algumas questões gerais sobre gosto, frequência e interesse.'
    ) !== false,
    'WIZ-05: each section shows its explanation as a visible block'
);
