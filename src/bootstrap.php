<?php

if (!defined('QPJBR_ROOT')) {
   define('QPJBR_ROOT', dirname(__DIR__));
}

header('Content-type: text/html; charset=utf-8');
setlocale(LC_ALL, 'pt_BR.UTF8');

require_once QPJBR_ROOT . '/src/Config/Env.php';
require_once QPJBR_ROOT . '/src/Http/Request.php';
require_once QPJBR_ROOT . '/src/Db/Crud.php';
require_once QPJBR_ROOT . '/src/Domain/ProfileScoring.php';
require_once QPJBR_ROOT . '/src/View/paths.php';


function consoleLog($texto)
{
   echo "<script> console.log('$texto'); </script>";
}
