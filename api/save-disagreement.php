<?php

require_once dirname(__DIR__) . '/src/bootstrap.php';

$puxaBD = new Crud();

$perfil = isset($_POST['perfilEscolhido'])
    ? $_POST['perfilEscolhido'] : '';
$rawId = isset($_POST['idJogador']) ? $_POST['idJogador'] : '';
$id = requireInt($rawId, 'id');

$insereOpniao = $puxaBD->executeBound(
    'INSERT INTO `nconcordo`(`idResposta`, `perfil`) VALUES (?, ?)',
    'is',
    array($id, utf8_decode($perfil))
);

echo json_encode($insereOpniao);
