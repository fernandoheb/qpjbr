<?php
	include 'functions.inc2.php';

	if(!isset($_GET['tempo'])){exit();}

	$rawId = isset($_GET['id']) ? $_GET['id'] : '';
	$id = requireInt($rawId, 'id');
	$tempo = requireInt($_GET['tempo'], 'tempo');
	$rawTempod = isset($_GET['tempodetalhes']) ? $_GET['tempodetalhes'] : '';
	$tempod = requireInt($rawTempod, 'tempodetalhes');
	$rawGraf1 = isset($_GET['graf1']) ? $_GET['graf1'] : '';
	$graf1 = requireInt($rawGraf1, 'graf1');
	$rawGraf2 = isset($_GET['graf2']) ? $_GET['graf2'] : '';
	$graf2 = requireInt($rawGraf2, 'graf2');
	$rawGraf3 = isset($_GET['graf3']) ? $_GET['graf3'] : '';
	$graf3 = requireInt($rawGraf3, 'graf3');
	$rawTotal = isset($_GET['totaldetalhes']) ? $_GET['totaldetalhes'] : '';
	$totaldetalhes = requireInt($rawTotal, 'totaldetalhes');
	$rawAbertos = isset($_GET['detalhesabertos']) ? $_GET['detalhesabertos'] : '';
	$detalhesabertos = requireInt($rawAbertos, 'detalhesabertos');
	$detalhesabertos--;
	$aux = $detalhesabertos."/".$totaldetalhes;
	echo "loading...";
	echo $aux;

	$puxaBD = new Crud();
	$puxaBD->executeBound(
		'insert into feedback (id,tempo,graf1,graf2,graf3,tempodetalhes,detalhesabertos) values (?, ?, ?, ?, ?, ?, ?)',
		'iiiiiis',
		array($id, $tempo, $graf1, $graf2, $graf3, $tempod, $aux)
	);
