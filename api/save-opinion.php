<?php

require_once dirname(__DIR__) . '/src/bootstrap.php';

$puxaBD = new Crud();

$rawRespostaId = isset($_POST['respostaId'])
    ? $_POST['respostaId'] : '';
$respostaId = requireInt($rawRespostaId, 'respostaId');
$respostaOpinao = isset($_POST['respostaOpinao'])
    ? $_POST['respostaOpinao'] : '';
$respostaTipoJogador = isset($_POST['respostaTipoJogador'])
    ? $_POST['respostaTipoJogador'] : '';

$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'concordo';
if ($tipo === 'perfilIdentificado') {
    $resultadoValor = $respostaTipoJogador;
} else {
    $resultadoValor = utf8_decode($respostaTipoJogador);
}

$insereOpniao = $puxaBD->executeBound(
    'INSERT INTO `concordo`(`idResposta`, `concordo`, `resultado`) VALUES (?, ?, ?)',
    'iss',
    array($respostaId, $respostaOpinao, $resultadoValor)
);

echo json_encode($insereOpniao);
