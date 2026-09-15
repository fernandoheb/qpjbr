<?php

require_once dirname(__DIR__) . '/src/bootstrap.php';

$puxaBD = new Crud();

$rawConsent = isset($_POST['aceitou_termo'])
    ? $_POST['aceitou_termo'] : '';
requireConsent($rawConsent);
$Codigo_Experimental = 'expontaneo';
$nome = $email = $genero = $escolaridade = $idade = '';
if (isset($_POST['nomeApelido'])) {
    $nome = utf8_decode($_POST['nomeApelido']);
}
if (isset($_POST['email'])) {
    $email = utf8_decode($_POST['email']);
}
if (isset($_POST['generoSexual'])) {
    $genero = utf8_decode($_POST['generoSexual']);
}
if (isset($_POST['escolaridade'])) {
    $escolaridade = utf8_decode($_POST['escolaridade']);
}
if (isset($_POST['CodGrpExp'])) {
    $Codigo_Experimental = utf8_decode($_POST['CodGrpExp']);
}
if (isset($_POST['idade'])) {
    $idade = utf8_decode($_POST['idade']);
}

$puxaBD->executeBound(
    'INSERT INTO `resposta`(`nome`, `email`, `genero`, `escolaridade`, `idade`,`Codigo_G_Exp`, `aceitou_termo`) VALUES (?, ?, ?, ?, ?, ?, ?)',
    'ssssssi',
    array(
        $nome,
        $email,
        $genero,
        $escolaridade,
        $idade,
        $Codigo_Experimental,
        1
    )
);

$id = $puxaBD->getLastID();
$idnext = $id;

foreach ($_POST as $indice => $val) {
    try {
        if (substr($indice, 0, strpos($indice, '_')) == 'questao') {
            $questaoid = substr(
                $indice,
                strpos($indice, '_') + 1
            );
            $questaoid = requireInt($questaoid, 'questaoid');
            $valorResposta = requireInt($val, 'valorResposta');
            $puxaBD->executeBound(
                'INSERT INTO `resp_quest`( `questaoid`,`respostaid`,`valorResposta`) VALUES (?, ?, ?)',
                'iii',
                array($questaoid, $id, $valorResposta)
            );
        }
    } catch (Exception $e) {
        consoleLog($e);
    }
}

$avanco = $mecanica = $competicao = $descoberta = $roleplaying
    = $escapismo = $customizacao = $trabalhoequipe = $socializacao
    = $social = $relacionamento = $realizacao = $imersao = 0;

$resultadoMediaSubFator = calculaMediaSUBFator($id);
while ($row = $resultadoMediaSubFator->fetch_assoc()) {
    switch ($row['subfator']) {
        case 'Avanço':
            $avanco = $row['Media'];
            break;
        case 'Mecanica':
            $mecanica = $row['Media'];
            break;
        case 'Competição':
            $competicao = $row['Media'];
            break;
        case 'Descoberta':
            $descoberta = $row['Media'];
            break;
        case 'Role Playing':
            $roleplaying = $row['Media'];
            break;
        case 'Escapismo':
            $escapismo = $row['Media'];
            break;
        case 'Customização':
            $customizacao = $row['Media'];
            break;
        case 'Trabalho em equipe':
            $trabalhoequipe = $row['Media'];
            break;
        case 'Socialização':
            $socializacao = $row['Media'];
            break;
        case 'Relacionamento':
            $relacionamento = $row['Media'];
            break;
    }
}

$resultadoMediaFator = calculaMediaFator($id);
while ($row = $resultadoMediaFator->fetch_assoc()) {
    switch ($row['fator']) {
        case 'A':
            $realizacao = $row['Media'];
            break;
        case 'S':
            $social = $row['Media'];
            break;
        case 'I':
            $imersao = $row['Media'];
            break;
    }
}

$maiorFator = max($realizacao, $imersao, $social);
$nomeTipoJogador = '';
$tiposEmpatados = '';
$nomeFatorPrincipal = '';

if ($maiorFator == $realizacao) {
    $arrayRealizacao = array(
        'Avanco' => $avanco,
        'Competicao' => $competicao,
        'Mecanica' => $mecanica,
    );
    $arrayRetornoMaiorValor = $puxaBD->maiorValor($arrayRealizacao);
    $nomeTipoJogador = $arrayRetornoMaiorValor['nomeCorreto'];
    $tiposEmpatados = $arrayRetornoMaiorValor['perfisEmpate'];
    $nomeFatorPrincipal = 'Realizacao';
} elseif ($maiorFator == $social) {
    $arraySocial = array(
        'Relacionamento' => $relacionamento,
        'Socializacao' => $socializacao,
        'Trabalhoequipe' => $trabalhoequipe,
    );
    $arrayRetornoMaiorValor = $puxaBD->maiorValor($arraySocial);
    $nomeTipoJogador = $arrayRetornoMaiorValor['nomeCorreto'];
    $tiposEmpatados = $arrayRetornoMaiorValor['perfisEmpate'];
    $nomeFatorPrincipal = 'Social';
} elseif ($maiorFator == $imersao) {
    $arrayImersao = array(
        'Customizacao' => $customizacao,
        'Escapismo' => $escapismo,
        'Descoberta' => $descoberta,
        'Roleplaying' => $roleplaying,
    );
    $arrayRetornoMaiorValor = $puxaBD->maiorValor($arrayImersao);
    $nomeTipoJogador = $arrayRetornoMaiorValor['nomeCorreto'];
    $tiposEmpatados = $arrayRetornoMaiorValor['perfisEmpate'];
    $nomeFatorPrincipal = 'Imersao';
}

if (
    ($realizacao == $maiorFator
        && ($realizacao == $imersao || $social == $realizacao))
    || ($imersao == $maiorFator && $imersao == $social)
) {
    $nomeFatorPrincipal = 'Empate';
}

$xid = array(
    $avanco,
    $escapismo,
    $socializacao,
    $competicao,
    $customizacao,
    $relacionamento,
    $mecanica,
    $roleplaying,
    $trabalhoequipe,
    $descoberta,
    $idnext,
);

$puxaBD->executeBound(
    'INSERT INTO `soma`(`idResposta`, `avanco`, `competicao`, `mecanica`, `socializacao`, `relacionamento`, `trabalhoemequipe`, `descoberta`, `roleplaying`, `customizacao`, `escapismo`, `achiever`, `relatedness`, `imersao`, `majoritario`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
    'iddddddddddddds',
    array(
        $idnext,
        $avanco,
        $competicao,
        $mecanica,
        $socializacao,
        $relacionamento,
        $trabalhoequipe,
        $descoberta,
        $roleplaying,
        $customizacao,
        $escapismo,
        $realizacao,
        $social,
        $imersao,
        $nomeFatorPrincipal,
    )
);

$puxaSubfatorBanco = $puxaBD->selectArrayPostWhere(
    '*',
    '`subfator`',
    " WHERE `subfator`='" . $nomeTipoJogador . "'"
);
$valoresSubfator = $puxaSubfatorBanco->fetch_assoc();

echo json_encode($xid);
