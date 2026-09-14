<?php
	include 'functions.inc2.php';
	$puxaBD = new Crud();
	$puxaBD->conn();
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

		<script type="text/javascript">
			window.onload = function(){
			inicializar();
			setTimeout(function() {
				fimInicializacao();
			}, 1000);
		}
		</script>

		<style>
		#loading {
			display: block;
			width: 10%;
		}
		.content { margin: 0 auto; }
			#all {
				width: 90%; overflow: hidden;
			}

		</style>

		<?php

		$aux = htmlspecialchars(
                        isset($_GET["id"]) ? $_GET["id"] : '',
                        ENT_QUOTES,
                        'UTF-8'
                );

		?>

		<title>Questionário do jogador</title>
		<!-- start: META -->
		<!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />

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


<script>
    TiposSelecionados=[0,0,0,0,0,0,0,0,0,0,0];
        function SelectType(id) {
       var e = document.getElementById("type"+id);
    if(TiposSelecionados[id]==1){
    TiposSelecionados[id]=0;
    e.style.background="transparent";
    }else{
    TiposSelecionados[id]=1;
    e.style.background= "#B0B0B0";
    }}
text =""; textbkp="";
    function SubmitResult(){
    i=0;total=0;
    while(i<11){
    total=total+TiposSelecionados[i];
    i++;
    }
    if(total==0){swal("Oops...","Você não selecionou nenhum tipo!","error");}
    if(total>3){swal("Oops...","Por favor, selecione no máximo 3 tipos!","error");}

    if(total>0&&total<4){
    text = "<strong>Avalie o quanto você se identifica com os perfis:</strong>";
    i=0;
    nomes=["","Campeão","Sonhador","Gente Boa","Competitivo","Estiloso","Parceiro","Estrategista","Ator","Líder","Explorador"];
    while(i<11){
    if(TiposSelecionados[i]==1){
    text=text+'<div style="max-height: 500px;"><br><img src="./img/personalidade/'+i+'.png" style="max-height:70px; width:auto;min-width:auto;max-width:100%;" width="auto"><b>'+nomes[i]+'</b><br><input class="rating" data-size="xs" id="rating'+i+'" data-step="1"></div>';
    }
    i++;
    }
    swal({
    title: "",
    allowOutsideClick: true,
    text: text,
    html: true,
    closeOnConfirm: false,
    },
    function(){
    i=0;rating=[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1];
         while(i<11){
     if(TiposSelecionados[i]==1){rating[i]=document.getElementById("rating"+i).value;}
     i++;
     }
    $('#action').fadeTo('slow',.6);
$('#action').append('<div style="position: absolute;top:0;left:0;width: 100%;height:100%;z-index:2;opacity:0.4;filter: alpha(opacity = 50)"></div>');
document.getElementById("buttonsubmit").class=document.getElementById("buttonsubmit").className +=" disabled";
     swal({
     title: "Obrigado",
     text: "Avaliação feita com sucesso! Obrigado por participar!",
     type: "success"
     },
     function(){//alterar endereço
     window.location = "./";
     })
     url = "./feedbacknconcordo.php?id="+<?php echo $aux;?>;
     i=0;
     while(i<11){
     if(TiposSelecionados[i]==1){url=url+"&type"+i+"=1&rating"+i+"="+rating[i];}
     i++;
     }
        var xhr = new XMLHttpRequest();
        xhr.open('get',url,true);
        xhr.send();
     });



    $.getScript('star/js/star-rating.min.js', function(){});
    }
    }
    </script>
    <script src="swal/dist/sweetalert.min.js"></script> <link rel="stylesheet" type="text/css" href="swal/dist/sweetalert.css">
        <link href="star/css/star-rating.min.css" media="all" rel="stylesheet" type="text/css" />
	</head>
	<!-- end: HEAD -->
	<body>
		<div class="center bg-blue">
		<img src="./img/background.png" style="max-height:200px; width:auto;min-width:auto;max-width:100%;" width="auto" alt="Clip-two">
		</div>
		<br></br>


		<div class="container-fluid container-fullw"  >
		<section id="all" class="content" style="display: none;">
						<div class="text-center" style="width:auto;min-width:auto;max-width:100%;" width="auto" alt="Clip-two">
						<h1>Escolha o seu tipo de jogador</h1>
						<div id="dv1">
							<div class="col-md-12" id="action">
										<fieldset class="text-center" >
											<legend>
												Escolha o seu Tipo de Jogador
											</legend>
												<div class="row">
												<div class="col-lg-12">
												    <center><h4>Escolha até três tipos!</h4></center>
													<table class="table table-condensed center" >
														<tbody>
															<tr class="active">
																<td>
																    <div id="type1" onclick="SelectType(1)" style="border-radius:10px;">
																	<a class="ps1" alt="Campeão" >
																	<img src="./img/personalidade/1.png" style="max-height:110px; width:auto;min-width:auto;max-width:100%;" width="auto" alt="Campeão">
																	<p><strong>Campeão</strong></p>
																	</a>
																	                                            <a href="#" title="Campeão" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content='
										Eu gosto mesmo é do topo, quanto mais pontos, dinheiro e o que mais eu puder ganhar, melhor'>
                                            <img src="img/quest.png" width="30px" height="30px" style="margin-bottom: 12px; margin-right: 6px;"></img></a>
																	</div>

																</td>
																<td>
																    <div id="type3" onclick="SelectType(3)" style="border-radius:10px;">
																	<a class="ps1" alt="Gente boa">
																	<img src="./img/personalidade/3.png" style="max-height:110px; width:auto;min-width:auto;max-width:100%;" width="auto" alt="Gente boa">
																	<p><strong>Gente boa</strong></p>
																	</a>
																	<a href="#" title="Gente Boa" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content='
										Um bate-papo casual, ajudar os outros e fazer amigos, isso sim é o que importa.'>
                                            <img src="img/quest.png" width="30px" height="30px" style="margin-bottom: 12px; margin-right: 6px;"></img></a>
																	</div>
																</td>
																	<td>
																	    <div id="type10" onclick="SelectType(10)" style="border-radius:10px;">
																		<a class="ps1" alt="Explorador" >
																		<img src="./img/personalidade/10.png" style="max-height:110px; width:auto;min-width:auto;max-width:100%;" width="auto" alt="Explorador">
																		<p><strong>Explorador</strong></p>
																		</a>
																		<a href="#" title="Explorador" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content='
										Para que jogar e acabar com a partida correndo se podemos explorar, conhecer e encontrar coisas escondidas? Ei!! Aquilo ali é um baú?'>
                                            <img src="img/quest.png" width="30px" height="30px" style="margin-bottom: 12px; margin-right: 6px;"></img></a>
																		</div>
																	</td>
																	<td>
																	    <div id="type7" onclick="SelectType(7)" style="border-radius:10px;">
																		<a class="ps1" alt="Estrategista" >
																		<img src="./img/personalidade/7.png" style="max-height:110px; width:auto;min-width:auto;max-width:100%;" width="auto" alt="Estrategista">
																		<p><strong>Estrategista</strong></p>
																		</a>
																		<a href="#" title="Estrategista" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content='
										Números, otimização, padronização, análises... Esses são os amigos que eu preciso pra me sair cada vez melhor.'>
                                            <img src="img/quest.png" width="30px" height="30px" style="margin-bottom: 12px; margin-right: 6px;"></img></a>
																		</div>
																	</td>
																	<td>
																	    <div id="type6" onclick="SelectType(6)" style="border-radius:10px;">
																		<a class="ps1" alt="Parceiro" >
																		<img src="./img/personalidade/6.png" style="max-height:110px; width:auto;min-width:auto;max-width:100%;" width="auto" alt="Parceiro">
																		<p><strong>Parceiro</strong></p>
																		</a>
																		<a href="#" title="Parceiro" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content='
										Empatia, intimidade, dar e receber suporte. Se precisa contar com alguém, conte comigo!'>
                                            <img src="img/quest.png" width="30px" height="30px" style="margin-bottom: 12px; margin-right: 6px;"></img></a>
																		</div>
																	</td>
																	</tr>
																<tr class="active">
																	<td>
																	    <div id="type8" onclick="SelectType(8)" style="border-radius:10px;">
																		<a class="ps1" alt="Ator" >
																		<img src="./img/personalidade/8.png" style="max-height:110px; width:auto;min-width:auto;max-width:100%;" width="auto" alt="Ator">
																		<p><strong>Ator</strong></p>
																		</a>
																		<a href="#" title="Ator" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content='
										O importante mesmo é entrar na história, ver os cenários e imaginar como seria sensacional estar ali!'>
                                            <img src="img/quest.png" width="30px" height="30px" style="margin-bottom: 12px; margin-right: 6px;"></img></a>
																		</div>
																	</td>

																	<td>
																	    <div id="type4" onclick="SelectType(4)" style="border-radius:10px;">
																		<a class="ps1" alt="Competitivo" >
																		<img src="./img/personalidade/4.png" style="max-height:110px; width:auto;min-width:auto;max-width:100%;" width="auto" alt="Competitivo">
																		<p><strong>Competitivo</strong></p>
																		</a>
																		<a href="#" title="Competitivo" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content='
										Quando eu entro numa disputa, é pra vencer. E se nesse tempo puder provocar os oponentes, é vitória em dobro!'>
                                            <img src="img/quest.png" width="30px" height="30px" style="margin-bottom: 12px; margin-right: 6px;"></img></a>
																		</div>
																	</td>
																	<td>
																	    <div id="type9" onclick="SelectType(9)" style="border-radius:10px;">
																		<a class="ps1" alt="Lider" >
																		<img src="./img/personalidade/9.png" style="max-height:110px; width:auto;min-width:auto;max-width:100%;" width="auto" alt="Lider">
																		<p><strong>Líder</strong></p>
																		</a>
																		<a href="#" title="Líder" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content='
										Vamos ganhar esse jogo juntos, só precisamos criar um grupo forte.'>
                                            <img src="img/quest.png" width="30px" height="30px" style="margin-bottom: 12px; margin-right: 6px;"></img></a>
																		</div>
																	</td>
																	<td>
																	    <div id="type5" onclick="SelectType(5)" style="border-radius:10px;">
																		<a class="ps1" alt="Estiloso" >
																		<img src="./img/personalidade/5.png" style="max-height:110px; width:auto;min-width:auto;max-width:100%;" width="auto" alt="Estiloso">
																		<p><strong>Estiloso</strong></p>
																		</a>
																		<a href="#" title="Estiloso" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content='
										Você viu minha nova espada? E a minha armadura reluzete? humm... Nada de capa! Acho que dava pra deixar esse cenário melhor...'>
                                            <img src="img/quest.png" width="30px" height="30px" style="margin-bottom: 12px; margin-right: 6px;"></img></a>
																		</div>
																	</td>
																	<td>
																	    <div id="type2" onclick="SelectType(2)" style="border-radius:10px;">
																		<a class="ps1" alt="Sonhador" >
																		<img src="./img/personalidade/2.png" style="max-height:110px; width:auto;min-width:auto;max-width:100%;" width="auto" alt="sonhador">
																		<p><strong>Sonhador</strong></p>
																		</a>
																		<a href="#" title="Sonhador" data-toggle="popover" data-trigger="hover" data-placement="bottom" data-content='
										Só quero aproveitar me divertir, relaxar e ficar aqui enquanto puder!'>
                                            <img src="img/quest.png" width="30px" height="30px" style="margin-bottom: 12px; margin-right: 6px;"></img></a>
																		</div>
																	</td>
																</tr>
														</tbody>
													</table>
												</div>
												</div>

										</fieldset>
										</div>
										</div>
										<br></br><br></br>
										<div class="center bg-white"  id="dv2">
											<h3>Muito Obrigado pela sua participação!</h3>
											</div>
										<br></br>
										<div class="text-center">
											<button class="btn btn-primary next-step btn-wide " id="buttonsubmit" onclick="SubmitResult()">
												Submeter
											</button><br><br>

											</div>
									</div>


							</section><!-- #all -->
							</div>
							<img src="http://goo.gl/atXpsl" alt="" id="loading" class="content"/>





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

$(document).ready(function(){
    $('[data-toggle="popover"]').popover();
});

			function inicializar(){
            			{document.getElementById("all").style.display="none";}
            			{document.getElementById("dv2").style.display="none";}
			}

			function fimInicializacao(){

            			{document.getElementById("loading").style.display="none";}
            			{document.getElementById("all").style.display="block";}
			}



		</script>
		<!-- end: JavaScript Event Handlers for this page --></html>
		<!-- end: CLIP-TWO JAVASCRIPTS -->

		<br><br><br>
		<br><br><br>
		<br><br><br>
		<br><br><br>
	</body>
