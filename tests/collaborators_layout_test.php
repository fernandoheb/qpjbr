<?php
$file = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'collaborators.php';
$src = file_get_contents($file);

assertTrue(
    substr_count($src, 'box effect6') === 1,
    'COLAB-01: collaborator card markup is defined once'
);

assertTrue(
    strpos($src, 'col-xs-12 col-sm-6 col-md-4') !== false,
    'COLAB-02: grid uses 1/2/3 columns (xs/sm/md)'
);

assertTrue(
    strpos($src, '$num%2') === false
    && strpos($src, 'if($num%2') === false,
    'COLAB-03: listing does not branch markup by column index'
);
