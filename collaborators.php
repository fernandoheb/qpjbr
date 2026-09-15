<?php
header('Content-Type: text/html; charset=utf-8');
require_once __DIR__ . '/src/bootstrap.php';
$puxaBD = new Crud();
$puxaBD->conn();
$puxaBD->setCharSet();
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
<style>
      .effect6
{
  	position:relative;
    -webkit-box-shadow:0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
       -moz-box-shadow:0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
            box-shadow:0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
}
.effect6:before, .effect6:after
{
	content:"";
    position:absolute;
    z-index:-1;
    -webkit-box-shadow:0 0 20px rgba(0,0,0,0.8);
    -moz-box-shadow:0 0 20px rgba(0,0,0,0.8);
    box-shadow:0 0 20px rgba(0,0,0,0.8);
    top:50%;
    bottom:0;
    left:10px;
    right:10px;
    -moz-border-radius:100px / 10px;
    border-radius:100px / 10px;
}
.effect6:after
{
	right:10px;
    left:auto;
    -webkit-transform:skew(8deg) rotate(3deg);
       -moz-transform:skew(8deg) rotate(3deg);
        -ms-transform:skew(8deg) rotate(3deg);
         -o-transform:skew(8deg) rotate(3deg);
            transform:skew(8deg) rotate(3deg);
}
.box {
	background:#FFF;
}
.collaborators-grid {
	display: flex;
	flex-wrap: wrap;
	padding: 0 15px;
}
.collaborators-grid > [class*="col-"] {
	display: flex;
	margin-bottom: 24px;
}
.collaborator-card {
	width: 100%;
	border-radius: 20px;
	padding: 16px 20px 8px;
	text-align: left;
}
.collaborator-card img {
	margin: 20px auto;
	display: block;
	border-radius: 40px;
	width: 80px;
	height: 80px;
}
.collaborator-card h3 {
	text-align: center;
}
  </style>




		<title>Questionário do jogador</title>
		<!-- start: META -->
		<!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
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



	</head>
	<!-- end: HEAD -->
	<body>
		<div class="center bg-blue">
		<img src="./img/background.png" style="max-height:200px; width:auto;min-width:auto;max-width:100%;" width="auto" alt="Clip-two">
		</div>



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



		</script>
		<!-- end: JavaScript Event Handlers for this page -->
		<!-- end: CLIP-TWO JAVASCRIPTS -->
<br>




		<center><h2>Colaboradores</h2></center>
		<div class="row collaborators-grid">
		<?php
		$result = $puxaBD->selectCustomQuery("Select * from colaboradores");
		while ($row = $result->fetch_object()) {
			$name = htmlspecialchars($row->Name, ENT_QUOTES, 'UTF-8');
			$formacao = htmlspecialchars($row->Formacao, ENT_QUOTES, 'UTF-8');
			$afiliacao = htmlspecialchars($row->Afiliacao, ENT_QUOTES, 'UTF-8');
			$lattes = htmlspecialchars($row->lattes, ENT_QUOTES, 'UTF-8');
			$email = htmlspecialchars($row->email, ENT_QUOTES, 'UTF-8');
			$foto = htmlspecialchars($row->Foto, ENT_QUOTES, 'UTF-8');
			echo '<div class="col-xs-12 col-sm-6 col-md-4">'
				. '<div class="box effect6 collaborator-card">'
				. '<img src="img/fotos/' . $foto . '" alt="' . $name . '">'
				. '<h3>' . $name . '</h3>'
				. '<p>'
				. '<b>Formação:</b> ' . $formacao . '<br>'
				. '<b>Afiliação:</b> ' . $afiliacao . '<br>'
				. '<b>Lattes:</b> <a target="_blank" rel="noopener noreferrer" href="'
				. $lattes . '">' . $lattes . '</a><br>'
				. '<b>Email:</b> ' . $email . '<br>'
				. '</p>'
				. '</div></div>';
		}
		?>
		</div>


<br>
<div class="row">
    <center>
        <table width="60%"><tr><td>
	<p style="text-align:justify" >
    O Laboratório de Computação Aplicada à Educação e Tecnologia Social Avançada (CAEd) foi criado em 2012 junto ao Instituto de Ciências Matemáticas e de Computação da Universidade de São Paulo (ICMC-USP)  e tem como objetivo desenvolver atividades de ensino, pesquisa e extensão de forma a gerar conhecimento de vanguarda, profissionais especializados e produtos tecnológicos inovadores que tem o potencial de auxiliar o processo de ensino e aprendizagem nos mais diversos domínios de conhecimento.

	O laboratório é composto por profissionais de diferentes áreas (e.g. Computação, Ensino, Engenharia, Educação, e Psicologia) funcionando como um pólo de divulgação dos avanços científicos da área em nível nacional e internacional. E o principal ramo de atuação é o desenvolvimento e aplicação de técnicas computacionais para resolver problemas educacionais.
</p></td></tr>
<br>

                <a href="https://www.sites.google.com/site/labcaed/home" target="_blank">
                    <img src="img/caed.png">
                        </a>
            </center>
</div>
	</body>
</html>
