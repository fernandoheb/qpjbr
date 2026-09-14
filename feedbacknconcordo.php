<?php
include 'functions.inc2.php';
$rawId = isset($_GET['id']) ? $_GET['id'] : '';
$id = requireInt($rawId, 'id');
echo "loading...";
if(isset($_GET['type1'])){$type1 = @$_GET['type1'];}
if(isset($_GET['type2'])){$type2 = @$_GET['type2'];}
if(isset($_GET['type3'])){$type3 = @$_GET['type3'];}
if(isset($_GET['type4'])){$type4 = @$_GET['type4'];}
if(isset($_GET['type5'])){$type5 = @$_GET['type5'];}
if(isset($_GET['type6'])){$type6 = @$_GET['type6'];}
if(isset($_GET['type7'])){$type7 = @$_GET['type7'];}
if(isset($_GET['type8'])){$type8 = @$_GET['type8'];}
if(isset($_GET['type9'])){$type9 = @$_GET['type9'];}
if(isset($_GET['type10'])){$type10 = @$_GET['type10'];}

if(isset($_GET['rating1'])){$rating1 = @$_GET['rating1'];}
if(isset($_GET['rating2'])){$rating2 = @$_GET['rating2'];}
if(isset($_GET['rating3'])){$rating3 = @$_GET['rating3'];}
if(isset($_GET['rating4'])){$rating4 = @$_GET['rating4'];}
if(isset($_GET['rating5'])){$rating5 = @$_GET['rating5'];}
if(isset($_GET['rating6'])){$rating6 = @$_GET['rating6'];}
if(isset($_GET['rating7'])){$rating7 = @$_GET['rating7'];}
if(isset($_GET['rating8'])){$rating8 = @$_GET['rating8'];}
if(isset($_GET['rating9'])){$rating9 = @$_GET['rating9'];}
if(isset($_GET['rating10'])){$rating10 = @$_GET['rating10'];}

$rating1 = $rating1 + 0;
$rating2 = $rating2 + 0;
$rating3 = $rating3 + 0;
$rating4 = $rating4 + 0;
$rating5 = $rating5 + 0;
$rating6 = $rating6 + 0;
$rating7 = $rating7 + 0;
$rating8 = $rating8 + 0;
$rating9 = $rating9 + 0;
$rating10 = $rating10 + 0;

$types = array("","Campeão","Sonhador","Gente Boa","Competitivo","Estiloso","Parceiro","Estrategista","Ator","Líder","Explorador");

$perfil = "";
if(isset($type1)){$perfil = $perfil .  $types[1]."[".$rating1."/5]+";}
if(isset($type2)){$perfil = $perfil .  $types[2]."[".$rating2."/5]+";}
if(isset($type3)){$perfil = $perfil .  $types[3]."[".$rating3."/5]+";}
if(isset($type4)){$perfil = $perfil .  $types[4]."[".$rating4."/5]+";}
if(isset($type5)){$perfil = $perfil .  $types[5]."[".$rating5."/5]+";}
if(isset($type6)){$perfil = $perfil .  $types[6]."[".$rating6."/5]+";}
if(isset($type7)){$perfil = $perfil .  $types[7]."[".$rating7."/5]+";}
if(isset($type8)){$perfil = $perfil .  $types[8]."[".$rating8."/5]+";}
if(isset($type9)){$perfil = $perfil .  $types[9]."[".$rating9."/5]+";}
if(isset($type10)){$perfil = $perfil .  $types[10]."[".$rating10."/5]+";}

printf($perfil);

$puxaBD = new Crud();
$puxaBD->executeBound(
    'insert into nconcordo (idResposta,perfil) values (?, ?)',
    'is',
    array($id, $perfil)
);

