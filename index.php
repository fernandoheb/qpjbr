<?php

	include 'functions.inc2.php';
	setlocale(LC_ALL, 'pt_BR.UTF8');
        //database connection
	$puxaBD = new Crud();
	$puxaBD->conn();
	$puxaBD->setCharSet();
        //Variáveis que vem quando se faz o login  com o facebook        
        //Facebook Login
        $name = null;
	$email = null;
	$gender = null;
	if(isset($_GET["name"])){
		$name = $_GET['name'];
	}
	if(isset($_GET["email"])){
		$email = $_GET['email'];
	}
	if(isset($_GET["gender"])){
		$gender = $_GET['gender'];
        }
        //código do grupo experimental
        //identtyfier code 
        $cod_grupo_exp = null;
	if(isset($_GET["codgrp"])){
		$cod_grupo_exp = strtoupper($_GET["codgrp"]);
	}
        //get variable to allow fast test - "it is a test"
	$eh_um_teste = '';
        if(isset($_GET["teste"])){
		$eh_um_teste = "checked = true";
	}
?>

<!DOCTYPE html>
<!-- Template Name: Clip-Two - Responsive Admin Template build with Twitter Bootstrap 3.x | Author: ClipTheme -->
<!--[if IE 8]><html class="ie8" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="pt-Br">
	<!--<![endif]-->
	<!-- start: HEAD -->
	<head>


		<title>Questionário do jogador</title>
		<!-- start: META -->
		<!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />
        <script src="swal/dist/sweetalert.min.js"></script>
		<script src="vendor/jquery/jquery.min.js"></script>
		<!-- end: META -->
		<!-- start: GOOGLE FONTS -->
		<link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
		<!-- end: GOOGLE FONTS -->
		<!-- start: MAIN CSS -->
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
		<link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
		<link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
		<link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">

		<!-- end: MAIN CSS -->
		<!-- start: CLIP-TWO CSS -->
		<link rel="stylesheet" href="assets/css/styles.css">
		<link rel="stylesheet" href="assets/css/plugins.css">
		<link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
		<!-- end: CLIP-TWO CSS -->
		<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
		<link href="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" media="screen">
		<link href="vendor/select2/select2.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-datepicker/bootstrap-datepicker3.standalone.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet" media="screen">
        <link rel="shortcut icon" href="./favicon.ico">
		<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
		<link rel="stylesheet" type="text/css" href="swal/dist/sweetalert.css">
	</head>
	<!-- end: HEAD -->
	<body>
	    <!--Script Facebook-->
	    <script>



	        step = 0;
	        function callalert(){
	        vartemp = setTimeout(alertstep, 1000);
	        }
	        function alertstep(){
	        if(step == 2){swal('Perguntas de importância','Responda as questões da seção seguinte pensando na importância que você confere ao que é perguntado ou afirmado.');}
	        if(step == 4){swal('Perguntas gerais','Para finalizar, responda algumas questões gerais sobre gosto, frequência e interesse.');}
	        if(step == 3){swal('Perguntas de gosto e frequência','Responda as questões da seção seguinte pensando no quanto você gosta dos itens enunciados e com que frequência você faz as ações perguntadas.');}
	        }
//Funcao de debug (aparentemente)
    function dump(arr,level) {
	var dumped_text = "";
	if(!level) level = 0;

	//The padding given at the beginning of the line.
	var level_padding = "";
	for(var j=0;j<level+1;j++) level_padding += "    ";

	if(typeof(arr) == 'object') { //Array/Hashes/Objects
		for(var item in arr) {
			var value = arr[item];

			if(typeof(value) == 'object') { //If it is an array,
				dumped_text += level_padding + "'" + item + "' ...\n";
				dumped_text += dump(value,level+1);
			} else {
				dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
			}
		}
	} else { //Stings/Chars/Numbers etc.
		dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
	}
	return dumped_text;
}




//funcao de comunicação com a API do Facebook
  function testAPI(cod_grupo_exp) {
	  //testar se está funcionando
	  //quando fizer o login usando o facebook não pode perder a identificação do grupo, 
	  //se a url tiver o cod_grupo_exp anteriormente tem que trazer ele junto
	    //console.log(cod_grupo_exp);
        FB.api('/me', function(response) {
        //alert(dump(response));
		var url = 'index.php?name='+response.name+'&email='+response.email+'&gender='+response.gender+'&birthday='+response.birthday;
		if (cod_grupo_exp != null)
				url += 'codgrp='+cod_grupo_exp;			
        parent.window.location.href= url;

    });
  }
  // This is called with the results from from FB.getLoginStatus().
  
  function statusChangeCallback(response) {
	 

    //console.log('statusChangeCallback');
    //console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      <?php
      if(!$name){echo"
      testAPI(".$cod_grupo_exp.");";}
      ?>
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
    document.getElementById('status').innerHTML = '';
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      document.getElementById('status').innerHTML = '';
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
  FB.init({
    appId      : '456156691222796',
    cookie     : true,  // enable cookies to allow the server to access
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.2' // use version 2.2
  });

  // Now that we've initialized the JavaScript SDK, we call
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = '//connect.facebook.net/en_US/sdk.js';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.


</script>






		<div class="center bg-blue">
		<img src="./img/background.png" style="max-height:200px; width:auto;min-width:auto;max-width:100%;" width="auto" alt="Clip-two">
		</div>
		<div class="container-fluid container-fullw">
			<div class="row">
				<div class="col-md-12">


					<!-- start: WIZARD FORM -->
					<form action="" role="form" class="" method="post" id="form">
						<div id="wizard" class="swMain ">
							<!-- start: WIZARD SEPS -->
							<ul class="bg-white">
								<li>
									<a href="#step-1">
										<div class="stepNumber">
											1
										</div>
										<span class="stepDesc"><small>Começando</small></span>
									</a>
								</li>
								<li>
									<a href="#step-2">
										<div class="stepNumber">
											2
										</div>
										<span class="stepDesc"> <small>Perguntas rápidas</small></span>
									</a>
								</li>
								<li>
									<a href="#step-3">
										<div class="stepNumber">
											3
										</div>
										<span class="stepDesc"> <small>Já estamos no meio</small> </span>
									</a>
								</li>
								<li>
									<a href="#step-4">
										<div class="stepNumber">
											4
										</div>
										<span class="stepDesc"> <small>Está acabando</small> </span>
									</a>
								</li>
								<li>
									<a href="#step-5">
										<div class="stepNumber">
											5
										</div>
										<span class="stepDesc"> <small>Resultado</small> </span>
									</a>
								</li>
							</ul>
							<!-- end: WIZARD SEPS -->
							<!-- start: WIZARD STEP 1 -->
							<div id="step-1">
								<div class="row">
									<div class="col-md-7">
										<fieldset>
											<legend>
												1 - Informações pessoais
											</legend>
											<div class="row">
											    <?php
											    if (!$name){ echo'
											    <center><b>Preencha os dados utilizando o Facebook</b><br></br>
											    <div id="status"></div><br></br>
											    <fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
</fb:login-button></center><br></br>
';}?>
												<div class="col-md-6">
													<div class="form-group">
														<label>
															<strong>Nome ou apelido</strong> <span class="symbol required"></span>
														</label>
														<input type="text" placeholder="Digite seu nome ou o seu apelido" class="form-control" name="nomeApelido" id="nomeApelido" value="<?php echo $name; ?>"/>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>
															<strong>Idade</strong> <span class="symbol required"></span>
														</label>
														<input type="text" placeholder="Digite a sua idade" class="form-control" name="idade"  id="idade"/>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>
															<strong>E-mail</strong> <span class="symbol required"></span>
														</label>
														<input type="text" placeholder="Digite o seu e-mail" class="form-control" name="email"  id="email" value="<?php echo $email; ?>"/>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>
															<strong>Grau de escolaridade</strong> <span class="symbol required"></span>
														</label>
														<select class="form-control" name="escolaridade" id="escolaridade">
															<option value="" disabled selected>Selecionar...</option>
															<option value="Ensino Fundamental Incompleto">Ensino Fundamental Incompleto</option>
															<option value="Ensino Fundamental Completo">Ensino Fundamental Completo</option>
															<option value="Ensino Médio Incompleto">Ensino Médio Incompleto</option>
															<option value="Ensino Médio Completo">Ensino Médio Completo</option>
															<option value="Ensino Superior Incompleto">Ensino Superior Incompleto</option>
															<option value="Ensino Superior Completo">Ensino Superior Completo</option>
															<option value="Pós-Graduação Incompleta">Pós-Graduação Incompleta</option>
															<option value="Pós-Graduação Completa">Pós-Graduação Completa</option>
														</select>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>
															<strong>Gênero sexual?</strong> <span class="symbol required"></span>
														</label>
														<div class="clip-radio radio-primary">
															<input type="radio" value="m" name="generoSexual" id="generoSexual_m" <?php if($gender=="male"){echo "checked";} ?>>
															<label for="generoSexual_m">
																Masculino
															</label>
															<input type="radio" value="f" name="generoSexual" id="generoSexual_f" <?php if($gender=="female"){echo "checked";} ?>>
															<label for="generoSexual_f">
																Feminino
															</label>
															<input type="radio" value="n" name="generoSexual" id="generoSexual_p">
															<label for="generoSexual_p">
																Prefiro não informar
															</label>
															<input type="radio" value="o" name="generoSexual" id="generoSexual_o">
															<label for="generoSexual_o">
																Outros
															</label>
														</div>
													</div>
												</div>

											</div>
											<div class="row">
												<div class="col-md-12">
													<p style="text-align:justify">
												Os dados coletados por meio deste questionário destinam-se exclusivamente para a pesquisa e serão mantidos em sigilo.

												A sua participação envolve responder o questionário de caracterização dos perfis de jogadores. Todos os seus dados serão mantido confidenciais e serão utilizados somente para os fins da pesquisa de forma acumulada, mantendo sempre o seu nome em sigilo. Você pode se recusar a participar do estudo ou retirar seu consentimento a qualquer momento, sem precisar justificar. Se você estiver de acordo com este termo, nós gostaríamos que você aceitasse participar e se compremeter a dizer a verdade ao questionário a seguir.
													</p>
													<div class="form-group">
														<label>
															<input type="checkbox" name="aceitou_termo" id="aceitou_termo" value="1" />
															Li e aceito o termo de aceitação e confidencialidade
														</label>
													</div>
												</div>
											</div>
											<p>
												<a href="javascript:void(0)" class="pop" data-content="Todos os dados coletados por meio deste questionário destinam-se exclusivamente para a pesquisa e todas as informações serão mantidos em sigilo absoluto." data-title="Não se preocupe!" data-placement="top" data-toggle="popover">
													Porque você quer minhas informações?
												</a>
											</p>
										 <?php
										 if ($cod_grupo_exp){ echo'
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label>
																<strong>Integrante do grupo </strong>
															</label>
															<input type="text"  class="form-control" name="CodGrpExp"  id="CodGrpExp" value='.$cod_grupo_exp.' readonly/>
														</div>
													</div>
												</div>					    
';}?>
										</fieldset>


											<div class="center  margin-top-20">
											<button class="btn btn-primary next-step btn-wide " onclick="if(document.getElementById('escolaridade').value){step = 2;callalert();}">
												Continuar <i class="fa fa-arrow-circle-right"></i>
											</button>
											</div>

									</div>

									<div class="col-md-5">
										<fieldset>
											<legend>
												Tipos de jogadores
											</legend>
											<div class="row">
												<div class="col-lg-12">
													<table class="table table-condensed center">
														<tbody>
															<tr class="active">
																<td>
																	<a href="javascript:void(0)" class="pop" data-content="Eu gosto mesmo é do topo, quanto mais pontos, dinheiro e o que mais eu puder ganhar, melhor!" data-title="Conquistador" data-placement="top" data-toggle="popover">
																	<img src="./img/personalidade/1.png" style="max-height:110px; width:auto;min-width:auto;max-width:100%;" width="auto" alt="Conquistador">
																	<p><strong>Conquistador</strong></p>
																	</a>
																</td>
																<td>
																	<a href="javascript:void(0)" class="pop"  data-content="Um bate-papo casual, ajudar os outros e fazer amigos, isso sim é o que importa." data-title="Gente boa" data-placement="top" data-toggle="popover">
																	<img src="./img/personalidade/3.png" style="max-height:110px; width:auto;min-width:auto;max-width:100%;" width="auto" alt="Gente boa">
																	<p><strong>Gente boa</strong></p>
																	</a>
																</td>
																	<td>
																		<a href="javascript:void(0)" class="pop" data-content="Para que jogar e acabar com a partida correndo se podemos explorar, conhecer e encontrar coisas escondidas? Ei!! Aquilo ali é um baÃº?" data-title="Explorador" data-placement="top" data-toggle="popover">
																		<img src="./img/personalidade/10.png" style="max-height:110px; width:auto;min-width:auto;max-width:100%;" width="auto" alt="Explorador">
																		<p><strong>Explorador</strong></p>
																		</a>
																	</td>
																</tr>
																<tr>
																	<td>
																		<a href="javascript:void(0)" class="pop"  data-content="NÃºmeros, otimização, padronização, análises... Esses são os amigos que eu preciso pra me sair cada vez melhor" data-title="Estrategista" data-placement="top" data-toggle="popover">
																		<img src="./img/personalidade/7.png" style="max-height:110px; width:auto;min-width:auto;max-width:100%;" width="auto" alt="Estrategista">
																		<p><strong>Estrategista</strong></p>
																		</a>
																	</td>
																	<td>
																		<a href="javascript:void(0)" class="pop" data-content="Empatia, intimidade, dar e receber suporte. Se precisa contar com alguém, conte comigo!" data-title="Parceiro" data-placement="top" data-toggle="popover">
																		<img src="./img/personalidade/6.png" style="max-height:110px; width:auto;min-width:auto;max-width:100%;" width="auto" alt="Parceiro">
																		<p><strong>Parceiro</strong></p>
																		</a>
																	</td>
																	<td>
																		<a href="javascript:void(0)" class="pop"  data-content="O importante mesmo é entrar na história, ver os cenários e imaginar como seria sensacional estar ali!" data-title="Ator" data-placement="top" data-toggle="popover">
																		<img src="./img/personalidade/8.png" style="max-height:110px; width:auto;min-width:auto;max-width:100%;" width="auto" alt="Ator">
																		<p><strong>Ator</strong></p>
																		</a>
																	</td>
																</tr>
																<tr class="active">
																	<td>
																		<a href="javascript:void(0)" class="pop" data-content="Quando eu entro numa disputa, é pra vencer. E se nesse tempo puder provocar os oponentes, é vitória em dobro!" data-title="Competitivo" data-placement="top" data-toggle="popover">
																		<img src="./img/personalidade/4.png" style="max-height:110px; width:auto;min-width:auto;max-width:100%;" width="auto" alt="Competitivo">
																		<p><strong>Competitivo</strong></p>
																		</a>
																	</td>
																	<td>
																		<a href="javascript:void(0)" class="pop" data-content="Vamos ganhar esse jogo juntos, só precisamos criar um grupo forte" data-title="Lider" data-placement="top" data-toggle="popover">
																		<img src="./img/personalidade/9.png" style="max-height:110px; width:auto;min-width:auto;max-width:100%;" width="auto" alt="Lider">
																		<p><strong>Lider</strong></p>
																		</a>
																	</td>
																	<td>
																		<a href="javascript:void(0)" class="pop" data-content="Você viu minha nova espada? E a minha armadura reluzente? humm... Nada de capa! Acho que dava pra deixar esse cenário melhor..." data-title="Estilista" data-placement="top" data-toggle="popover">
																		<img src="./img/personalidade/5.png" style="max-height:110px; width:auto;min-width:auto;max-width:100%;" width="auto" alt="Estiloso">
																		<p><strong>Estiloso</strong></p>
																		</a>
																	</td>
																</tr>
																<tr>
																	<td>
																		<a href="javascript:void(0)" class="pop" data-content="Só quero aproveitar me divertir, relaxar e ficar aqui enquanto puder!" data-title="Sonhador" data-placement="top" data-toggle="popover">
																		<img src="./img/personalidade/2.png" style="max-height:110px; width:auto;min-width:auto;max-width:100%;" width="auto" alt="sonhador">
																		<p><strong>Sonhador</strong></p>
																		</a>
																	</td>
																</tr>
														</tbody>
													</table>
												</div>
											</div>
										</fieldset>
									</div>

								</div>
							</div>
							<!-- end: WIZARD STEP 1 -->
							<!-- start: WIZARD STEP 2 -->
							<div id="step-2">
								<div class="row">
									<div class="col-md-12">
										<div class="text-center">


                                        <a href="#" title="Identificação do perfil de jogador" data-toggle="popover" data-trigger="hover" data-placement="top" data-content='
										As próximas seções buscam conhecer o que você gosta, considera importante e com que frequência você realiza determinadas ações para podermos compreender o seu perfil de jogador'>
                                            <img src="img/quest.png" width="30px" height="30px" style="margin-bottom: 12px; margin-right: 6px;"></img></a><h2 style="display: inline;">Identificação do perfil de jogador</h2>

<br></br>

<a href="#" title="Perguntas de importância" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content='
Responda as questões da seção seguinte pensando na importância que você confere ao que é perguntado ou afirmado.'><img src="img/quest.png" width="30px" height="30px"  style="margin-bottom: 12px; margin-right: 6px;"></img></a>
<h3 style="display: inline;">Perguntas de importância</h3>

										<br></br>

							<?php
								$bloco = '<div id="step-valorStep"><div class="row"><div class="col-md-12"><div class="text-center">';
								$footer = '<div class="form-group"><button class="btn btn-primary back-step btn-wide pull-left" onclick="step = step - 1;"><i class="fa fa-circle-arrow-left"></i> Voltar</button>
								<button class="btn btn-primary next-step btn-wide pull-right" onclick="step = step + 1;callalert();">Próximo <i class="fa fa-arrow-circle-right"></i></button></div></div></div></div></div>';



								$customQuery='SELECT  MAX(`id`) as max FROM `resposta` ';

								$query2 = $puxaBD->selectCustomQuery($customQuery);

								$queryLP = $query2->fetch_assoc();
								global $aux;
								$aux = $queryLP["max"];


                                                                     //ficar atento a mudanças no banco. Quando o select não for associativo       
								$customQuery='SELECT  `questao` . * ,  `escala`. * FROM `questao` INNER JOIN `escala` ON `questao`.`escalaId` = `escala`.`id` WHERE exibir = 1 ORDER BY ordem ASC';

								$query2 = $puxaBD->selectCustomQuery($customQuery);


								$step=2;
								$respostaId=1;
                                                                $questaoId =0;
								$paginacao=1;

								while($queryLP = $query2->fetch_row()){//fetch_assoc
                                                                   //  consoleLog("questao ID".$questaoId = $queryLP["0"]);
                                                                   //  consoleLog("respID".$respostaId);
                                                                       //   if($queryLP["codspss"]==2440){

								

                                                                         //    }

                                                                         if($respostaId==10){$respostaId++;} //<h3>'. utf8_encode($queryLP["questao"]).'</h3>
								// consoleLog("questao ID ".$queryLP[0]) ;
								echo '
																
										<div class="container-fluid container-fullw bg-white">
												<div class="row">
													<div class="col-md-6" style="margin:0 auto; float: none!important">
														<div class="panel panel-transparent">
															<div class="panel-heading">
																<h3>'. $queryLP[1].'</h3>
															</div>
															<div class="larguraFixa" style="margin:0 auto; float: none!important">
																<div class="panel-body" style="text-align:left!important">
																	<div class="radio clip-radio radio-primary">
                                                                                                                                       
																	<input type="radio" id="alt5_'.$queryLP[0] .'" name="questao_'.$queryLP[0] .'"  value="2" >
																	<label for="alt5_'.$queryLP[0] .'">
																	<strong>'.$queryLP[17] /*utf8_encode($queryLP["alt5"])*/ .'</strong>																		</label>																	</div>
																	<div class="radio clip-radio radio-primary">
																	<input type="radio" id="alt4_'.$queryLP[0] .'" name="questao_'.$queryLP[0] .'"  value="1" '.$eh_um_teste.'>
																	<label for="alt4_'.$queryLP[0] .'">
																	<strong>'.$queryLP[16] .'</strong>																		</label>																	</div>
																	<div class="radio clip-radio radio-primary">
																	<input type="radio" id="alt3_'.$queryLP[0] .'" name="questao_'.$queryLP[0] .'" value="0">
																	<label for="alt3_'.$queryLP[0] .'">
																	<strong>'. $queryLP[15] .'</strong>																		</label>																	</div>
																	<div class="radio clip-radio radio-primary">
																	<input type="radio" id="alt2_'.$queryLP[0] .'" name="questao_'.$queryLP[0] .'"  value="-1">
																	<label for="alt2_'.$queryLP[0] .'">
																	<strong>'. $queryLP[14] .'</strong>																		</label>																	</div>
																	<div class="radio clip-radio radio-primary">
																		<input type="radio" id="alt1_'.$queryLP[0] .'" name="questao_'.$queryLP[0] .'" value="-2">
																		<label for="alt1_'.$queryLP[0] .'">
																			<strong>'. $queryLP[13] .'</strong>
																		</label>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>';
									$paginacao ++;
									$respostaId ++;


                                                                        if($step == 2){

									}

									if($step == 4){

									}

									elseif($paginacao == 10){//quantidade de questoes por paginas // era 15
										$step++;
										echo $footer;
										echo str_replace("valorStep", $step, $bloco);
										$paginacao=1;
										if($step == 3){
                                                                                echo '
                                                                                     <a href="#" title="Perguntas de Gosto e Frequência" data-toggle="popover" data-placement="top" data-trigger="hover" data-content="Responda as questões da seção seguinte pensando no quanto você gosta dos itens enunciados e com que
                                                                                     frequência você faz as ações perguntadas"><img src="img/quest.png" style="margin-bottom: 12px; margin-right: 6px;" width="30px" height="30px"></img></a><h3 style="display: inline;">Perguntas de Gosto e Frequência</h3>

                                                                                                          ';  }
                                                                                                          if($step == 4){
                                                                         echo '
                                                                        <a href="#" title="Perguntas gerais" data-toggle="popover" data-placement="top" data-trigger="hover" data-content="Para finalizar responda agora algumas questões gerais sobre gosto, frequência e interesse.">
                                                                            <img src="img/quest.png" style="margin-bottom: 12px; margin-right: 6px;" width="30px" height="30px"></img>
                                                                        </a><h3 style="display: inline;">Perguntas gerais</h3>

                                                                        '; 									}
									}

								}

							?>

											<div class="form-group">
											<button class="btn btn-primary btn-o back-step btn-wide pull-left" onclick="step = step - 1;">
												<i class="fa fa-circle-arrow-left"></i> Voltar
											</button>
											<button class="submitQuestionario btn btn-primary btn-o btn-wide pull-right" >
												Ver resultado <i class="fa fa-arrow-circle-right"></i>
											</button>
										</div>
										</div>
									</div>
								</div>
							</div>

							<!-- start: WIZARD STEP 5 -->
							<div id="step-5">
								<div class="row">
									<div class="col-md-12">
										<div class="text-center">
										</div>
									</div>
								</div>
							</div>
							<!-- end: WIZARD STEP 5 -->
						</div>
					</form>
					<!-- end: WIZARD FORM -->
				</div>
			</div>
		</div>
		<!-- start: WIZARD DEMO -->

		<!-- Default Modal -->
										<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
														<h4 class="modal-title" id="myModalLabel">Obrigado!</h4>
													</div>
													<div class="modal-body">
														Obrigado por participar desse questionário! Se quiser saber mais sobre a pesquisa, entre em contato com os pesquisadores!
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-primary" onclick="finalizar()">
															Ok
														</button>
													</div>
												</div>
											</div>
										</div>
										<!-- /Default Modal -->





		<!-- start: MAIN JAVASCRIPTS -->
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="vendor/modernizr/modernizr.js"></script>
		<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
		<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="vendor/switchery/switchery.min.js"></script>
		<script src="vendor/selectFx/classie.js"></script>
		<script src="vendor/selectFx/selectFx.js"></script>
		<!-- end: MAIN JAVASCRIPTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script src="vendor/jquery-validation/jquery.validate.min.js"></script>
		<script src="vendor/jquery-smart-wizard/jquery.smartWizard.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<!-- start: CLIP-TWO JAVASCRIPTS -->
		<script src="assets/js/main.js"></script>
		<!-- start: JavaScript Event Handlers for this page -->
		<script src="assets/js/form-wizard.js"></script>
		<script>

		aux = -1;

		jQuery(document).ready(function() {
				Main.init();
				FormWizard.init();

                    $('.pop').on('click', function (e) {
      			$('.pop').not(this).popover('hide');
                    });

		    $(".submitQuestionario").click(function (e) {
                        if (!$("#aceitou_termo").prop("checked")) {
                            swal("Oops...","Você precisa aceitar o termo para enviar.","error");
                            return;
                        }
                        //Validação dos componentes radio buttons
                        var nulo = 0;
 //                       console.log("valor de nulo no começo "+nulo);
                            var frm = document.forms[0];                                                                               
                            var elementoAntigo="";                            
                            var numElementos = frm.elements.length;
                            console.log("numelementos "+numElementos);
                            for(var i = 0; i < numElementos; i++){
                                if(elementoAntigo == frm.elements[i].name){
                                    //console.log(elementoAntigo +" == "+frm.elements[i].name);
                                    //console.log(nulo);
                                        if( nulo ==0){
                                            console.log("continue");
                                            continue;
                                   }
                                } else {
                                    elementoAntigo = frm.elements[i].name;
                                    //console.log("Elemento antiog "+elementoAntigo );
                                    //console.log("Elemento novo " +frm.elements[i].name);                          
                                    if( nulo ==1&&frm.elements[i-1].type=="radio"){
                                       // console.log(frm.elements[i-1].name);
                                       // console.log("break");
                                        break;
                                    }                                            
                                }
                                if(i < numElementos-1){
                                    if(frm.elements[i].type =="radio") {
                                        nulo =1;                      
                                        if (frm.elements[i].checked) 
                                            nulo=0;                                  
                                        }
                                    }
                                }                      
                        if(nulo==1)  {
                            swal("Oops...","Você não selecionou alguma alternativa!","error");
                        } else  {
                            $.ajax({
                                            //url : 'http://localhost/git/questionarioLocal/saveData.php?salvar',					
                                            url : './saveData.php?salvar',					
                                            dataType: 'json',
                                            data: $('#form').serialize(),  //transforma o formulario em 1 linha por meio do POST para a pagina da URL; *dados do ajax para o php
                                            type: 'POST',
                                            /*beforeSend: function(){
                                                    //$(".next-step").click();
                                                    console.log("ajax before");
                                            },*/
                                            success: function(result){
                                                resultado(result); 
                                                //  var xid = result;
                                                //  console.log(xid);
                                                //  resultado(xid);
                                                //  console.log("sucesso");
                                            },
                                            error:function(){
                                                console.log("algo deu erraro na recuperação dos dados..")
                                            }
                                    });
                        }   
                    });

                    $(".submitConcordo").click(function (e) {
                        var check = $(this).attr("alt");//pega o atributo alt do ultimo elemento instanciado.
                        var idResposta = $("#idResposta").val();//recebe  value idResposta quando .val() está vazio.
                                        var tipoJogador = $("#resultadoTipoJogador").val();//recebe  value idResposta quando .val() está vazio

                        $.ajax({
                                                //url : 'http://localhost/git/questionarioLocal/saveData.php?concordo',
                                                url : './saveData.php?concordo',
                                                type: 'POST',
                                                dataType: 'json',
                                                data: ({respostaOpinao:check , respostaId:idResposta, respostaTipoJogador:tipoJogador}),

                                                success: function(dados){
                                                        $("#myModal").modal('show');

                                                }

                                        });

                    });

                    $(".submitPerfilIdentificado").click(function (e) {
                        var perfilEscolhido = $("#perfilIdentificado").val();//pega o valor digitado pelo usuario
                        var idResposta = $("#idResposta").val();//recebe  value idResposta quando .val() está vazio.
                                        var tipoJogador = $("#resultadoTipoJogador").val();//recebe  value idResposta quando .val() está vazio.
                        $.ajax({
                                                //url : 'http://localhost/git/questionarioLocal/saveData.php?perfilIdentificado',
                                                url : './saveData.php?perfilIdentificado',
                                                type: 'POST',
                                                dataType: 'json',
                                                data: ({respostaOpinao:perfilEscolhido , respostaId:idResposta, respostaTipoJogador:tipoJogador}),

                                                success: function(dados){
                                                        $("#myModal").modal('show');
                                                }

                                        });

                    });


                });

                function resultado(xid){
                    //console.log("resultado");
                    var jarrayFatores= xid;
                    //var url = 'http://localhost/git/questionarioLocal/resultado.php?id='+jarrayFatores[10]+'&avc='+jarrayFatores[0]+'&cpc='+jarrayFatores[3]+'&mca='+jarrayFatores[6]+'&scz='+jarrayFatores[2]+'&rlc='+jarrayFatores[5]+'&tbe='+jarrayFatores[8]+'&dsc='+jarrayFatores[9]+'&rpg='+jarrayFatores[7]+'&ctz='+jarrayFatores[4]+'&ecp='+jarrayFatores[1]+'&resp=1';
                    var url = './resultado.php?id='+jarrayFatores[10]+'&avc='+jarrayFatores[0]+'&cpc='+jarrayFatores[3]+'&mca='+jarrayFatores[6]+'&scz='+jarrayFatores[2]+'&rlc='+jarrayFatores[5]+'&tbe='+jarrayFatores[8]+'&dsc='+jarrayFatores[9]+'&rpg='+jarrayFatores[7]+'&ctz='+jarrayFatores[4]+'&ecp='+jarrayFatores[1]+'&resp=1';
                    window.location.assign(url);
                }
        		
		</script>
		<!-- end: JavaScript Event Handlers for this page --></html>
		<!-- end: CLIP-TWO JAVASCRIPTS -->
	</body>
