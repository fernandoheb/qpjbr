<?php
	include 'functions.inc2.php';
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
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta charset="utf-8" />
	    <style>
	          .fb-share-button
		{
		transform: scale(1.2);
		-ms-transform: scale(1.2);
		-webkit-transform: scale(1.2);
		-o-transform: scale(1.2);
		-moz-transform: scale(1.2);

		}
	        </style>

	<?php
                        function qpjQueryNumber($raw)
                        {
                                if (!is_numeric($raw)) {
                                        return 0;
                                }
                                return 0 + $raw;
                        }
			$aux = qpjQueryNumber(
                                isset($_GET["id"]) ? $_GET["id"] : ''
                        );
		  	$avanco = qpjQueryNumber(
                                isset($_GET["avc"]) ? $_GET["avc"] : ''
                        );
			$competicao = qpjQueryNumber(
                                isset($_GET["cpc"]) ? $_GET["cpc"] : ''
                        );
			$mecanica = qpjQueryNumber(
                                isset($_GET["mca"]) ? $_GET["mca"] : ''
                        );
			$socializacao = qpjQueryNumber(
                                isset($_GET["scz"]) ? $_GET["scz"] : ''
                        );
			$relacionamento = qpjQueryNumber(
                                isset($_GET["rlc"]) ? $_GET["rlc"] : ''
                        );
			$trabalhoemequipe = qpjQueryNumber(
                                isset($_GET["tbe"]) ? $_GET["tbe"] : ''
                        );
			$descoberta = qpjQueryNumber(
                                isset($_GET["dsc"]) ? $_GET["dsc"] : ''
                        );
			$roleplaying = qpjQueryNumber(
                                isset($_GET["rpg"]) ? $_GET["rpg"] : ''
                        );
			$customizacao = qpjQueryNumber(
                                isset($_GET["ctz"]) ? $_GET["ctz"] : ''
                        );
			$escapismo = qpjQueryNumber(
                                isset($_GET["ecp"]) ? $_GET["ecp"] : ''
                        );
                        $flag_resposta = qpjQueryNumber(
                                isset($_GET["resp"]) ? $_GET["resp"] : ''
                        );



                        $maiorValor = max($avanco, $escapismo,  $socializacao, $competicao, $customizacao,  $relacionamento, $mecanica, $roleplaying, $trabalhoemequipe, $descoberta);
			$arrayNomeFatores = array("Avanco", "Escapismo", "Socializacao", "Competicao", "Customizacao", "Relacionamento", "Mecanica", "Roleplaying", "Trabalhoequipe", "Descoberta");
			$arrayFatores = array($avanco, $escapismo,  $socializacao, $competicao, $customizacao,  $relacionamento, $mecanica, $roleplaying, $trabalhoemequipe, $descoberta);

			//alterar o endereço
			//$url = "http://200.144.255.42:8003/questionario/resultado3c.php?id=".$aux."&avc=".$avanco."&cpc=".$competicao."&mca=".$mecanica."&scz=".$socializacao."&rlc=".$relacionamento."&tbe=".$trabalhoemequipe."&dsc=".$descoberta."&rpg=".$roleplaying."&ctz=".$customizacao."&ecp=".$escapismo."&resp=0&fixface=".time();
			$url = $endereco."resultado3c.php?id=".$aux."&avc=".$avanco."&cpc=".$competicao."&mca=".$mecanica."&scz=".$socializacao."&rlc=".$relacionamento."&tbe=".$trabalhoemequipe."&dsc=".$descoberta."&rpg=".$roleplaying."&ctz=".$customizacao."&ecp=".$escapismo."&resp=0&fixface=".time();
	 		$i = 0;
			$s = 0;
			$j = 0;
			$nomes="";
			foreach ($arrayNomeFatores as $value){

					$customQuery='SELECT  `descricao`, `nomeFantasia` FROM `subfator` WHERE id = '.(int)$i.'+1';
					$query2 = $puxaBD->selectCustomQuery($customQuery);
					$queryLP = $query2->fetch_assoc();

					$descricao = $queryLP["descricao"];
					$nomeFantasia = $queryLP["nomeFantasia"];

					$explic[$s]=$descricao;
					$s = $s+1;
					$i = $i + 1;
			}


			$avanco = str_replace(",", ".", $avanco);

			$escapismo = str_replace(",", ".", $escapismo);

			$socializacao = str_replace(",", ".", $socializacao);

			$competicao = str_replace(",", ".", $competicao);

			$customizacao = str_replace(",", ".", $customizacao);

			$relacionamento = str_replace(",", ".", $relacionamento);

			$mecanica = str_replace(",", ".", $mecanica);

			$roleplaying = str_replace(",", ".", $roleplaying);

			$trabalhoemequipe = str_replace(",", ".", $trabalhoemequipe);

			$descoberta = str_replace(",", ".", $descoberta);

			$macroRealizacao = ($avanco + $mecanica + $competicao);
			$macroSocial = ($relacionamento +$socializacao + $trabalhoemequipe);
			$macroImersao = ($customizacao + $escapismo + $descoberta + $roleplaying);

			if ($macroRealizacao<0){
				$macroRealizacao=0;
			}
			if ($macroSocial<0){
				$macroSocial=0;
			}
			if ($macroImersao<0){
				$macroImersao=0;
			}

			$positivos = qpjSomaPositivos($arrayFatores);
			$maiorValor = str_replace(",", ".", $maiorValor);



  ?>




  		<?php
		/*
	//Set the Image source variables
	$backgroundSource = "http://www.64bitjungle.com/wp-content/themes/openbook22-en/images/rss-subscribe.jpg";
	$feedBurnerStatsSource = "http://feeds2.feedburner.com/~fc/64BitJungle?bg=151515&fg=ffffff&anim=0";
	//Create new images
	$outputImage = imagecreatefromjpeg($backgroundSource);
	$feedBurnerStats = imagecreatefromgif($feedBurnerStatsSource);
	//Grab width and height of the FeedBurner image
	$feedBurnerStatsX = imagesx($feedBurnerStats);
	$feedBurnerStatsY = imagesy($feedBurnerStats);
	//Merge the two images
	imagecopymerge($outputImage,$feedBurnerStats,156,50,0,0,$feedBurnerStatsX,$feedBurnerStatsY,100);
	//Output header
	header('Content-type: image/png');
	//send new image to browser
	imagepng($outputImage);
	imagedestroy($outputImage);
	*/
?>
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
  </style>
<script>


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
    </script>


	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.charts.load("visualization", "1", {packages:["corechart", "bar"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {

      	<?php
      	$arrayNomeFatores = array("Avanco", "Escapismo", "Socializacao", "Competicao", "Customizacao", "Relacionamento", "Mecanica", "Roleplaying", "Trabalho em equipe", "Descoberta");
	$arrayFatores = array($avanco, $escapismo,  $socializacao, $competicao, $customizacao,  $relacionamento, $mecanica, $roleplaying, $trabalhoemequipe, $descoberta);
	$explicacao = $explic;
      	?>

      	if (<?php echo $flag_resposta; ?> == 1){
		{document.getElementById("b3").style.display="none";}
	}else{
	document.getElementById("form-group").style.display="none";
	document.getElementById("b3").style.display="none";
	}
	var i;


      	var jarrayNomeFatores= <?php echo json_encode($arrayNomeFatores); ?>;
      	var jarrayFatores = <?php echo json_encode($arrayFatores); ?>;
      	var descr = <?php echo json_encode($explicacao); ?>;

		var macroRealizacao = <?php echo $macroRealizacao; ?>/3;
		var macroSocial = <?php echo $macroSocial; ?>/3;
		var macroImersao = <?php echo $macroImersao; ?>/4;




      	for (i=0; i<10; i++){
      		jarrayFatores[i] = Number(jarrayFatores[i].replace(",","."));
      		if (jarrayFatores[i]<0){
      			jarrayFatores[i]=0;
      		}
      	}

        var data = google.visualization.arrayToDataTable([
          ['Fator', 'Relevancia'],
          [jarrayNomeFatores[0],    jarrayFatores[0] ],
          [jarrayNomeFatores[1],    jarrayFatores[1] ],
          [jarrayNomeFatores[2],    jarrayFatores[2] ],
          [jarrayNomeFatores[3],    jarrayFatores[3] ],
          [jarrayNomeFatores[4],    jarrayFatores[4] ],
          [jarrayNomeFatores[5],    jarrayFatores[5] ],
          [jarrayNomeFatores[6],    jarrayFatores[6] ],
          [jarrayNomeFatores[7],    jarrayFatores[7] ],
          [jarrayNomeFatores[8],    jarrayFatores[8] ],
          [jarrayNomeFatores[9],    jarrayFatores[9] ]
        ]);

        var options = {
          title: '',
          backgroundColor: '#FAFAFA'
        };

        var options2 = {
          title: '',
          backgroundColor: '#FAFAFA'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

		    var chart2 = new google.visualization.PieChart(document.getElementById('piechart2'));

        function selectHandler() {
          var selectedItem = chart.getSelection()[0];
          if (selectedItem) {
            i = 0;
            var topping = data.getValue(selectedItem.row, 0);
            while (topping!=jarrayNomeFatores[i]){
            	i++;
            }
            {
            if(i==0){swal("O componente Avanço representa o seu interesse em desempenho indivídual e pela aquisição de recompensas em função do seu esforço.");}
            if(i==1){swal("O componente de Escapismo representa seu interesse utilizar os jogos como um lugar para relaxar ou aliviar o seu stress do mundo real.");}
            if(i==2){swal("O componente de Socialização representa seu interesse em conhecer pessoas nos jogos e participar de atividades em que você não esteja absolutamente sozinho.");}
            if(i==3){swal("O componente de Competição representa seu interesse em participar de atividades em que você posso avaliar se desempenho contra o desempenho de outros jogadores.");}
            if(i==4){swal("O componente de Customização representa o seu interesse por opções que permitam que você modifique o jogo, o personagem e o ambiente de modo que se tornem mais próximo do seu gosto.");}
            if(i==5){swal("O componente de Relacionamento representa o seu interesse em fazer amizades nos jogos e/ou conhecer as pessoas que jogam os mesmos jogos que você e os seus costumes.");}
            if(i==6){swal("O componente de Mecânica representa seu interesse por compreender o funcionamento do jogo, suas regras e os meios de aumentarem seu desempenho.");}
            if(i==7){swal("O componente de Role-playing representa seu interesse pela História do jogo e as possibilidades de realizar alguma forma de Interpretação, manifestação ou influência dentro do jogo.");}
            if(i==8){swal("O componente de Trabalho em equipe representa seu interesse em atuar com outros jogadores para a solução de problemas e melhoria do desempenho do grupo como um todo.");}
            if(i==9){swal("O componente de Descoberta representa o seu interesse por conhecer tudo que o jogo tem para oferecer, seja na forma de conhecer todos os pontos do cenário, missões, itens, mapas, personagens ou jogadores.");}
            }
          }
        }

                function selectHandler2() {
alert("oi");
          var selectedItem = chart2.getSelection()[0];
          if (selectedItem) {
            i = 0;
            var topping = data.getValue(selectedItem.row, 0);
            while (topping!=jarrayNomeFatores[i]){
            	i++;
            }
            {

            }
          }
        }

        google.visualization.events.addListener(chart, 'select', selectHandler);
        //google.visualization.events.addListener(chart2, 'select', selectHandler2);


		chart.draw(data, options);

		 var data2 = google.visualization.arrayToDataTable([
          ['Fator', 'Relevancia'],
          ['Realização',    macroRealizacao ],
          ['Social',    macroSocial ],
          ['Imersão',    macroImersao ]
        ]);
        chart2.draw(data2, options2);

		$(window).resize(function(){
		  drawChart();
		});

      }
    </script>

     <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.charts.load("visualization", "1", {packages:["corechart", "bar"]});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        <?php
      	$arrayNomeFatores = array("Avanco", "Escapismo", "Socializacao", "Competicao", "Customizacao", "Relacionamento", "Mecanica", "Roleplaying", "Trabalho em Equipe", "Descoberta");
	$arrayFatores =array($avanco, $escapismo,  $socializacao, $competicao, $customizacao,  $relacionamento, $mecanica, $roleplaying, $trabalhoemequipe, $descoberta);
      	?>
      	var jarrayNomeFatores= <?php echo json_encode($arrayNomeFatores ); ?>;
      	var jarrayFatores = <?php echo json_encode($arrayFatores); ?>;

      	var i;

      	for (i=0; i<10;i++){
		{document.getElementById("expbar"+i).style.display="none";}
	}

      	for (i=0; i<10; i++){
      		jarrayFatores[i] = Number(jarrayFatores[i].replace(",","."));
      	}

        var data = google.visualization.arrayToDataTable([
          ['Fator', 'Relevancia'],
          [jarrayNomeFatores[0],    jarrayFatores[0] ],
          [jarrayNomeFatores[1],    jarrayFatores[1] ],
          [jarrayNomeFatores[2],    jarrayFatores[2] ],
          [jarrayNomeFatores[3],    jarrayFatores[3] ],
          [jarrayNomeFatores[4],    jarrayFatores[4] ],
          [jarrayNomeFatores[5],    jarrayFatores[5] ],
          [jarrayNomeFatores[6],    jarrayFatores[6] ],
          [jarrayNomeFatores[7],    jarrayFatores[7] ],
          [jarrayNomeFatores[8],    jarrayFatores[8] ],
          [jarrayNomeFatores[9],    jarrayFatores[9] ]
        ]);

        var options = {
          title: 'Todos Fatores',
          legend: { position: 'none' },
          backgroundColor: '#FAFAFA',
		  color:  '#FAFAFA',
          axes: {
            x: {
              0: { side: 'top', label: 'Todos Fatores'} // Top x-axis.
            }
          }
          };

        var chart = new google.charts.Bar(document.getElementById('chart_div'));


         function selectHandler() {
        for (i=0; i<10;i++){
		{document.getElementById("expbar"+i).style.display="none";}
	}
          var selectedItem = chart.getSelection()[0];
          if (selectedItem) {
            i = 0;
            var topping = data.getValue(selectedItem.row, 0);
            while (topping!=jarrayNomeFatores[i]){
            	i++;
            }
            {document.getElementById("expbar"+i).style.display="block";}
          }
        }

        google.visualization.events.addListener(chart, 'select', selectHandler);




        chart.draw(data, options);

		$(window).resize(function(){
		  drawStuff();
		});
      };
    </script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="assets/js/RGraph.common.core.js"></script>
<script src="assets/js/RGraph.radar.js"></script>
<script src="assets/js/RGraph.common.dynamic.js"></script>
<script src="assets/js/RGraph.common.key.js"></script>
<script src="assets/js/RGraph.drawing.rect.js"></script>
<script src="assets/js/RGraph.common.tooltips.js"></script>
<script src="assets/js/RGraph.common.effects.js"></script>


<script>
    function myClick (e, bar)
    {
        var obj = bar[0];
        var x   = bar[1];
        var y   = bar[2];
        var w   = bar[3];
        var h   = bar[4];
        var idx = bar[5];

        alert('The onclick listener just fired with index: ' + idx);
    }


    $(document).ready(function ()
    {
			var jarrayNomeFatores= <?php echo json_encode($arrayNomeFatores ); ?>;
      	var jarrayFatores = <?php echo json_encode($arrayFatores); ?>;

      	var i;

      	for (i=0; i<10; i++){
      		jarrayFatores[i] = Number(jarrayFatores[i].replace(",","."));

			if (jarrayFatores[i]<=0){
				jarrayFatores[i]=0.01;
			}
      	}
        var radar = new RGraph.Radar({
            id: 'cvs',
			data: [[jarrayFatores[0],jarrayFatores[3],jarrayFatores[6],0.01,0.01,0.01,0.01,0.01,0.01,0.01],[0.01,0.01,0.01,jarrayFatores[5],jarrayFatores[2],jarrayFatores[8],0.01,0.01,0.01,0.01],[0.01,0.01,0.01,0.01,0.01,0.01,jarrayFatores[4],jarrayFatores[1],jarrayFatores[9],jarrayFatores[7]]],
            options: {
				tooltips: [
                               jarrayNomeFatores[0],jarrayNomeFatores[3],jarrayNomeFatores[6],jarrayNomeFatores[5],jarrayNomeFatores[2],jarrayNomeFatores[8],jarrayNomeFatores[4],jarrayNomeFatores[1],jarrayNomeFatores[9],jarrayNomeFatores[7],
							   jarrayNomeFatores[0],jarrayNomeFatores[3],jarrayNomeFatores[6],jarrayNomeFatores[5],jarrayNomeFatores[2],jarrayNomeFatores[8],jarrayNomeFatores[4],jarrayNomeFatores[1],jarrayNomeFatores[9],jarrayNomeFatores[7],
							   jarrayNomeFatores[0],jarrayNomeFatores[3],jarrayNomeFatores[6],jarrayNomeFatores[5],jarrayNomeFatores[2],jarrayNomeFatores[8],jarrayNomeFatores[4],jarrayNomeFatores[1],jarrayNomeFatores[9],jarrayNomeFatores[7]
                              ],
							   background: {
                        circles: {
                            poly: {
                                self: true,
                                spacing: 30
                            }
                        }
                    },
                    colors: ['Gradient(white:#3366cc)','Gradient(white:#dc3912)','Gradient(white:#ff9900)'],
                    axes: {
                        color: 'transparent'
                    },
				  highlights: true,
                strokestyle: ['#3366cc', '#dc3912','#ff9900'],
                linewidth: 3,
                key: {
				//	self: [jarrayNomeFatores[0],jarrayNomeFatores[3],jarrayNomeFatores[6],jarrayNomeFatores[5],jarrayNomeFatores[2],jarrayNomeFatores[8],jarrayNomeFatores[4],jarrayNomeFatores[1],jarrayNomeFatores[9],jarrayNomeFatores[7]]
                    self: ['Realização','Social','Imersão'],
                    colors: ['#3366cc', '#dc3912','#ff9900'],
                    interactive: true
                },
         //       labels: [jarrayNomeFatores[0],jarrayNomeFatores[3],jarrayNomeFatores[6],jarrayNomeFatores[5],jarrayNomeFatores[2],jarrayNomeFatores[8],jarrayNomeFatores[4],jarrayNomeFatores[1],jarrayNomeFatores[9],jarrayNomeFatores[7]]
            }
        }).grow()
        radar.$1.onclick = function(){swal("O componente de Competição representa seu interesse em participar de atividades em que você posso avaliar se desempenho contra o desempenho de outros jogadores.");}
        radar.$2.onclick = function(){swal("O componente de Mecânica representa seu interesse por compreender o funcionamento do jogo, suas regras e os meios de aumentarem seu desempenho.");}
        radar.$13.onclick = function(){swal("O componente de Relacionamento representa o seu interesse em fazer amizades nos jogos e/ou conhecer as pessoas que jogam os mesmos jogos que você e os seus costumes.");}
        radar.$14.onclick = function(){swal("O componente de Socialização representa seu interesse em conhecer pessoas nos jogos e participar de atividades em que você não esteja absolutamente sozinho.");}
        radar.$15.onclick = function(){swal("O componente de Trabalho em equipe representa seu interesse em atuar com outros jogadores para a solução de problemas e melhoria do desempenho do grupo como um todo.");}
        radar.$26.onclick = function(){swal("O componente de Customização representa o seu interesse por opções que permitam que você modifique o jogo, o personagem e o ambiente de modo que se tornem mais próximo do seu gosto.");}
        radar.$27.onclick = function(){swal("O componente de Escapismo representa seu interesse utilizar os jogos como um lugar para relaxar ou aliviar o seu stress do mundo real.");}
        radar.$28.onclick = function(){swal("O componente de Descoberta representa o seu interesse por conhecer tudo que o jogo tem para oferecer, seja na forma de conhecer todos os pontos do cenário, missões, itens, mapas, personagens ou jogadores.");}
        radar.$29.onclick = function(){swal("O componente de Role-playing representa seu interesse pela História do jogo e as possibilidades de realizar alguma forma de Interpretação, manifestação ou influência dentro do jogo.");}
        radar.$0.onclick = function(){swal("O componente Avanço representa o seu interesse em desempenho indivídual e pela aquisição de recompensas em função do seu esforço.");}

    });
</script>

<?php
            $i = 0;
			$s = 0;
			$j = 0;
			$teste = 0;
			$nomesarray = array();
			$geraimgv = array_fill(1, count($arrayNomeFatores), 0);
			foreach ($arrayNomeFatores as $value){
			$arrayFatores[$i] = str_replace(",", ".", $arrayFatores[$i]);
					$teste = qpjDistanciaDoTopo(
                                                $arrayFatores[$i],
                                                $maiorValor,
                                                $positivos
                                        );
				if ($teste <= 0.05) {
					$customQuery='SELECT  `descricao`, `nomeFantasia` FROM `subfator` WHERE id = '.(int)$i.'+1';
					$query2 = $puxaBD->selectCustomQuery($customQuery);
					$queryLP = $query2->fetch_assoc();
					$nomeFantasia = $queryLP["nomeFantasia"];
					$nomesarray[$s]=utf8_encode($nomeFantasia);
					$geraimgv[$i+1]=1;
					$s++;
				}
			$i = $i + 1;
			}
			//alterar endereço
			//$imagemgerada = "http://localhost/questionario/geraimg.php?fixface=".time()."&img1=".$geraimgv[1]."&img2=".$geraimgv[2]."&img3=".$geraimgv[3]."&img4=".$geraimgv[4]."&img5=".$geraimgv[5]."&img6=".$geraimgv[6]."&img7=".$geraimgv[7]."&img8=".$geraimgv[8]."&img9=".$geraimgv[9]."&img10=".$geraimgv[10];
			$imagemgerada = $endereco."geraimg.php?fixface=".time()."&img1=".$geraimgv[1]."&img2=".$geraimgv[2]."&img3=".$geraimgv[3]."&img4=".$geraimgv[4]."&img5=".$geraimgv[5]."&img6=".$geraimgv[6]."&img7=".$geraimgv[7]."&img8=".$geraimgv[8]."&img9=".$geraimgv[9]."&img10=".$geraimgv[10];
?>


		<title>Questionário do jogador</title>
		<!-- start: META -->
		<!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />
		<meta property="og:title" content="Meu perfil de jogador é:" />
		<meta property="og:url" content="<?php echo $url;?>" />
		<meta property="og:image" content="<?php echo $imagemgerada; ?>" />
		<meta property="og:image:width" content="1410"/>
		<meta property="og:image:height" content="630"/>
		<meta property="og:description" content="<?php $i=0;while(isset($nomesarray[$i])){if($i>0){echo " + ";}echo $nomesarray[$i];$i++;}echo". Faça o teste você também!";?>"  />


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

        <link href="star/css/star-rating.min.css" media="all" rel="stylesheet" type="text/css" />
        <script src="star/js/star-rating.min.js" type="text/javascript"></script>

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














 <!-- <script>
    $(document).ready(function(){
    $("#button1").click(function(){
        $("#hide1").toggle(500);
    });
});

    $(document).ready(function(){
    $("#button2").click(function(){
        $("#hide2").toggle(500);
    });
});

    $(document).ready(function(){
    $("#button3").click(function(){
        $("#hide3").toggle(500);
    });
});
    $(document).ready(function(){
    $("#button4").click(function(){
        $("#hide4").toggle(500);
    });
});
    $(document).ready(function(){
    $("#button5").click(function(){
        $("#hide5").toggle(500);
    });
});
    $(document).ready(function(){
    $("#button6").click(function(){
        $("#hide6").toggle(500);
    });
});
    $(document).ready(function(){
    $("#button7").click(function(){
        $("#hide7").toggle(500);
    });
});
    $(document).ready(function(){
    $("#button8").click(function(){
        $("#hide8").toggle(500);
    });
});
    $(document).ready(function(){
    $("#button9").click(function(){
        $("#hide9").toggle(500);
    });
});
    $(document).ready(function(){
    $("#button10").click(function(){
        $("#hide10").toggle(500);
    });
});
</script>-->

<script>
    var focus = 1;
window.onfocus = function(){focus=1;};
window.onblur =  function(){focus=0;};



    var tempo; var tempo2;
function Tempo(estado){
if(estado==1){
tempo = new Date();
tempo = tempo.getTime();
}
}

var detalhesabertos=0;
var totaldetalhes=0;

var tempod = 0; var tempod2; var tempodtotal=0;
var detalhescheck=0;
var estado=[0,0,0,0,0,0,0,0,0,0,0];
var foiaberto=[0,0,0,0,0,0,0,0,0,0,0];
function Detalhes(id,force){
//if(id>100){alert(tempodtotal+"/"+detalhescheck);return;}
var acao=0;
if(foiaberto[id]==0){foiaberto[id]=1;detalhesabertos++;}
if(estado[id]==0){estado[id]=1;acao=1;}else{estado[id]=0;acao=0;}
if(force==1&&detalhescheck>0){detalhescheck=1;acao=0;}
if(acao==1){detalhescheck++;}
if(acao==0){detalhescheck--;
    if(detalhescheck==0){tempod2 = new Date(); tempod2 = tempod2.getTime();tempodtotal=tempodtotal + tempod2 - tempod;}
}
if(tempod==0&&detalhescheck>0){
tempod = new Date();
tempod = tempod.getTime();
}
if(detalhescheck==0){tempod=0;}
}





  function feedbackjs() {
  tempo2 = new Date();
tempo2 = tempo2.getTime();
graf1 = document.getElementById("graf1").value;
graf2 = document.getElementById("graf2").value;
graf3 = document.getElementById("graf3").value;
timespent = tempo2 - tempo;
Detalhes(0,1);
        var xhr = new XMLHttpRequest();
        xhr.open('get',"feedback.php?id="+<?php echo $aux;?>+"&tempo="+timespent+"&graf1="+graf1+"&graf2="+graf2+"&graf3="+graf3+"&tempodetalhes="+tempodtotal+"&totaldetalhes="+totaldetalhes+"&detalhesabertos="+detalhesabertos,false);
        xhr.send();
}
  window.onbeforeunload = feedbackjs;




    </script>

<script src="swal/dist/sweetalert.min.js"></script> <link rel="stylesheet" type="text/css" href="swal/dist/sweetalert.css">
	</head>
	<!-- end: HEAD -->
	<body onload="Tempo(1)">

<script>
    </script>

	<div id="fb-root"></div>

		<script>


  window.fbAsyncInit = function() {
    FB.init({
      appId      : '926416844107084',
      xfbml      : true,
      version    : 'v2.5'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/pt_BR/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
		</script>


		<div class="center bg-blue">
		<img src="./img/background.png" style="max-height:200px; width:auto;min-width:auto;max-width:100%;" width="auto" alt="Clip-two">
		</div>







			<div class="text-center">
			<br></br>
			<?php if($flag_resposta==1){echo '<h1>Este é o seu Perfil de Jogador!</h1>';}else{echo '<h1>Veja detalhes dos resultados de seu amigo!</h1>';} ?>

			<?php
			echo '

			<table class="table table-condensed center text-center">
			<tr>
			';

			$i = 0;
			$s = 0;
			$j = 0;
			$nomes = "";
			$teste = 0;
			foreach ($arrayNomeFatores as $value){
			$arrayFatores[$i] = str_replace(",", ".", $arrayFatores[$i]);
					$teste = qpjDistanciaDoTopo(
                                                $arrayFatores[$i],
                                                $maiorValor,
                                                $positivos
                                        );

				if ($teste <= 0.05) {

					$customQuery='SELECT  `descricao`, `nomeFantasia` FROM `subfator` WHERE id = '.(int)$i.'+1';
					$query2 = $puxaBD->selectCustomQuery($customQuery);
					$queryLP = $query2->fetch_assoc();

					$descricao = $queryLP["descricao"];
					$nomeFantasia = $queryLP["nomeFantasia"];

				if($s!=0){
					$nomes .= ", ";
				}
					$nomes .= $nomeFantasia;
					$nomeDescr[$s]= $nomeFantasia;
					$descr[$s]=$descricao;
					$s = $s+1;

					$j = $i+1;
				if ($s % 4 == 1){
					echo '</tr><tr>';
				}
				else if($s > 0){
				echo '

					<td width="1%" id="td'.$i.'">
					<img style="position:relative;" src="img/plus.png" width="70px" margin="0" >
					</td>
					<script>
					    if(screen.width<800){
					    document.getElementById("td'.$i.'").style.display = "none";
					    document.getElementById("td2'.$i.'").style.display = "none";
					    document.getElementById("td3'.$i.'").style.display = "none";
					    }
					    </script>
					';
				}
									$customQuery='SELECT  `descricao`, `nomeFantasia` FROM `subfator` WHERE id = '.(int)$i.'+1';
					$query2 = $puxaBD->selectCustomQuery($customQuery);
									$queryLP = $query2->fetch_assoc();

					$descricao = $queryLP["descricao"];
				$descr[$s]=$descricao;
				 echo '

<script>if(screen.width<800){document.write("</tr><tr>");}</script>
	                                                                                    <td align="center"  class="box effect6" width="25%" id="tdmain'.$i.'">
            <br></br>
	                                                                                         <h3>'.$nomeFantasia.' </h3> <br></br>
	                                                                                     <img src="./img/personalidade/'.$j.'.png" style="align: center;">
<br></br>
			<script>
					    if(screen.width<800){
					    document.getElementById("tdmain'.$i.'").style.width = "100%";
					    }
					    </script>
';?>
        <script>
            <?php $auxtext =$descr[$s]; $auxtext = preg_replace( "/\r|\n/", "", $auxtext );  $auxtext = str_split($auxtext, 250);?>
<?php echo"swaltext".$s." = '".$auxtext[0]."';";?>
<?php if(isset($auxtext[1])){echo "swaltext".$s."2='".$auxtext[1]."';";}else{echo "swaltext".$s."2='';";} ?>
<?php if(isset($auxtext[2])){echo "swaltext".$s."3='".$auxtext[2]."';";}else{echo "swaltext".$s."3='';";} ?>
<?php echo"swaltext".$s." = swaltext".$s."+swaltext".$s."2 + swaltext".$s."3;"; ?>
            function Alertdet<?php echo$s;?>(){
            swal({   title: "<?php echo $nomeFantasia;?>",
               text:swaltext<?php echo $s?>+'<br><button type="button" class="btn btn-info" disabled="disabled" style="display:none;">Saiba mais</button>',
                  type: "info",
                     html: true,
                       confirmButtonColor: "#0099CC",
                        confirmButtonText: "Ok!",
                           closeOnConfirm: true }, function(){Detalhes(<?php echo $s;?>,0);});
                           }

        </script>
      <?php  echo '

        <button type="button" class="btn btn-success" onclick="Detalhes('.$s.',0);Alertdet'.$s.'();" id="button'.($s).'">Detalhes</button>
        <script>totaldetalhes='.$s.';</script>
        <br></br>
        </td>



	 ';



				}

			$i = $i + 1;
			}

			echo '

			 </tr>
			 </table>
			 ';
			 echo '




			</div>

			';
		?><br>
		<div class="text-center">
		    		        						<div class="form-group" id="form-group">
							<label>
								<strong>Você concorda com o resultado?</strong> <span class="symbol required"></span>
							</label>
							</br>

							<a id="b1" class="btn btn-danger  submitConcordo" alt="nao"  >
								Não
							</a>
							<a id="b2" class="btn btn-success submitConcordo" alt="sim"  >
								Sim
							</a>
						</div>
						<br><br>



		        <div class="text-center">
		            <div style="display:inline-block;background:#5E8296;padding:12px 28px;">
		                <h2 style="color:white;margin:0;font-size:22px;line-height:1.3;">
		                    Veja mais<br>detalhes abaixo
		                </h2>
		            </div>
		        </div>


<br><br>
							<div class="text-center" id="b3">
										<label >
											<strong>Obrigado pela sua participação</strong>
										</label>
										<br></br><!--alterar o endereço-->
										<a  class="btn btn-primary" href="./index.php">
											Retornar a página inicial.
										</a>
										<br></br>

									</div>
						<br><br>

						    <?php
						    if($flag_resposta==0){
								//alterar o enderço
						    echo'					<div class="text-center" id="b3">
										<br></br>
												
										<a  class="btn btn-primary"  href="./index.php">
											<h2 style="color:blue"><strong>Faça a pesquisa você também!</span></h2>
										</a>
									</div>';
						    }
						    ?>
									<br><br>
		<h1>Veja detalhes dos seus resultados!</h1>
		<h4>Clique nos gráficos para obter mais informações!</h4>
		</div>

		<style>
		.chart {
		  width: 100%;
		  height: 600px;
		}
		</style>
<script>
    if(screen.width<800){
    var rand = Math.random();
    }else{
    var rand = -1;
    }
   if(rand==-1){
   document.write(
   '\
   <br><br>\
   <div class="row">\
			  <div class="col-xs-4">\
			      <center><h3>Principais subfatores</h3></center>\
				<center><div id="piechart" class="chart" style="height: 300px;"></div></center>\
				<center><div style="text-align: left; margin-left: 30%;"><b>Este gráfico é útil?</b></div></center>\
				<center><div style="text-align: left; margin-left: 20%;"><input class="rating" data-size="xs" id="graf1"></div></center>\
			  </div>\
			  <div class="col-xs-4" style="text-align: center;">\
                <canvas id="cvs" width="400" height="300">[No canvas support]</canvas>\
                <center><div style="text-align: center;"><b>Este gráfico é útil?</b></div></center>\
                <center><div style="text-align: left; margin-left: 30%;"><input class="rating" data-size="xs" id="graf2"></div></center>\
			  </div>\
			  <div class="col-xs-4">\
			      <center><h3>Principais fatores</h3></center>\
				<div id="piechart2" class="chart" style="height: 300px"></div>\
				<center><div style="text-align: left; margin-left: 30%;"><b>Este gráfico é útil?</b></div></center>\
				<center><div style="text-align: left; margin-left: 20%;"><input class="rating" data-size="xs" id="graf3"></div></center>\
			  </div>\
			</div>\
			');}
			if(rand>=0&&rand<1/3){
			   document.write(
   '<div class="row">\
			  <div class="col-xs-4">\
				<div id="piechart" class="chart" style="height: 300px"></div>\
				<center><div style="text-align: left; margin-left: 30%;"><b>Este gráfico é útil?</b></div></center>\
				<center><div style="text-align: left; margin-left: 20%;"><input class="rating" data-size="xs" id="graf1"></div></center>\
			  </div>');
			}
			if(rand>=(1/3)&&rand<2/3){
			     document.write('<div class="row">\
			  <div class="col-xs-4" style="text-align: center;">\
                <canvas id="cvs" width="400" height="300">[No canvas support]</canvas>\
                <center><div style="text-align: center;"><b>Este gráfico é útil?</b></div></center>\
                <center><div style="text-align: left; margin-left: 30%;"><input class="rating" data-size="xs" id="graf2"></div></center>\
			  </div>');
			  }
			  			if(rand>=(2/3)&&rand<=1){
   document.write('<div class="row">\
			  <div class="col-xs-4">\
				<div id="piechart2" class="chart" style="height: 300px"></div>\
				<center><div style="text-align: left; margin-left: 30%;"><b>Este gráfico é útil?</b></div></center>\
				<center><div style="text-align: left; margin-left: 20%;"><input class="rating" data-size="xs" id="graf3"></div></center>\
			  </div>\
			</div>');}
 </script>

		<?php
		$i=0;
		$expfatores = array("O componente Avanço representa o seu interesse em desempenho indivídual e pela aquisição de recompensas em função do seu esforço.",
		"O componente de Escapismo representa seu interesse utilizar os jogos como um lugar para relaxar ou aliviar o seu stress do mundo real.",
		"O componente de Socialização representa seu interesse em conhecer pessoas nos jogos e participar de atividades em que você não esteja absolutamente sozinho.",
		"O componente de Competição representa seu interesse em participar de atividades em que você posso avaliar se desempenho contra o desempenho de outros jogadores.",
		"O componente de Customização representa o seu interesse por opções que permitam que você modifique o jogo, o personagem e o ambiente de modo que se tornem mais próximo do seu gosto.",
		"O componente de Relacionamento representa o seu interesse em fazer amizades nos jogos e/ou conhecer as pessoas que jogam os mesmos jogos que você e os seus costumes.",
		"O componente de Mecânica representa seu interesse por compreender o funcionamento do jogo, suas regras e os meios de aumentarem seu desempenho.",
		"O componente de Role-playing representa seu interesse pela História do jogo e as possibilidades de realizar alguma forma de Interpretação, manifestação ou influência dentro do jogo.",
		"O componente de Trabalho em equipe representa seu interesse em atuar com outros jogadores para a solução de problemas e melhoria do desempenho do grupo como um todo.",
		"O componente de Descoberta representa o seu interesse por conhecer tudo que o jogo tem para oferecer, seja na forma de conhecer todos os pontos do cenário, missões, itens, mapas, personagens ou jogadores.",
		);
		//while($i<10){
		//	echo '

			//	<div id="exp'.$i.'" class="text-justified">
			//		<center><table width="80%" class="box effect6"><td><strong>&nbsp&nbsp&nbsp'.$expfatores[$i].'</strong></td></table></center>
			//		<br></br>
			//	</div>
		//	';
			//$i++;
	//	}//
		?>

			<?php
		$i=0;
		$nPerfis = count($arrayNomeFatores);
		while($i < $nPerfis){
			echo '

				<div id="expbar'.$i.'" class="text-justified">
					<h3>'.utf8_encode($explicacao[$i]).'</h3>
				</div>
			';
			$i++;
		}
		?>

<br>
<center><div class="fb-share-button" data-href="<?php echo $url; ?>" data-layout="button"></div></center><br>









				<?php
					if ($flag_resposta==1){
					echo '<div class="text-center" id="b2">
						<img id="imagemPerfil" />
						<h2 id="titulo" class="StepTitle"></h2>
						<p  id="descricao" class="text-large"></p>

					</div>';


							echo '


								</div>
						';
					}
					else {
					echo'

								</div>
					';
					}


					echo '
					<p><center><table width="80%"><td style="text-align:justify;">
					*O presente questionário avalia as motivações para jogar com base no artigo
					<a href="https://nickyee.com/pubs/Yee%20-%20Motivations%20(2007).pdf" target="_blank" rel="noopener noreferrer">Motivations for Play in Online Games</a>,
					de Nick Yee, e na adaptação validada para o português-brasileiro publicada em
					<a href="https://sol.sbc.org.br/index.php/sbie/article/view/41721/41491" target="_blank" rel="noopener noreferrer">QPJ-BR: Questionário para Identificação de Perfis de Jogadores para o Português-Brasileiro</a>.
					O resultado aqui apresentado são aproximações da combinação dos subcomponentes com maior pontuação no questionário.
					Gostaríamos de registrar e salientar o caráter experimental da ferramenta aqui oferecida.
					Caso opte por receber posteriormente uma avaliação do perfil de jogador mais precisa, ficaremos contentes em lhe enviar após uma análise ampla com o público brasileiro.
					</td></table></center></p>
					';
				?>
					<br>
					    <center>
						<!-- alterar endereço -->
					        <a href="./colaboradores.php"><input type="button" class="btn-primary" value="Quem somos"></input></a>
					        <br><br>
					            <table style="background:#F0F0F0;"><td>
					        <div class="col-sm-3">&nbsp</div>
<a href="http://www5.usp.br/" target="_blank"><img src="img/usp.png" class="col-sm-1"></a>
<a href="http://www.icmc.usp.br/Portal/" target="_blank"><img src="img/icmc.png" class="col-sm-1"></a>
<a href="http://caed-lab.com/" target="_blank"><img src="img/caed.png" style="margin-top: 10px;" class="col-sm-1"></a>
<a href="http://www.cnpq.br/" target="_blank"><img src="img/cnpq.png" style="margin-top: 10px;" class="col-sm-1"></a>
<a href="http://www.fapesp.br/" target="_blank"><img src="img/fapesp.png" style="margin-top: 25px;" class="col-sm-1"></a>
<a href="http://www.capes.gov.br/" target="_blank"><img src="img/capes.png" class="col-sm-1"></a>
<div class="col-sm-3">&nbsp</div>
</td><tr><td align="center">
<div class="col-sm-12"><p>Email de contato para sugestões e comentários: fernando.heb@alumni.usp.br</p></div>
</td></table> 
                    </center>
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

			jQuery(document).ready(function() {







			$(".submitConcordo").click(function (e) {
            	var check = $(this).attr("alt");//pega o atributo alt do ultimo elemento instanciado.
            		var	idResposta = "<?php echo $aux; ?>";
            		var	tipoJogador = "<?php echo $nomes; ?>";
            		document.getElementById("form-group").style.display="none";
						//alterar o endereço
            			$.ajax({
					url : './saveData.php?concordo',
					type: 'POST',
					dataType: 'json',
					data: ({respostaOpinao:check , respostaId:idResposta, respostaTipoJogador:tipoJogador}),

					success: function(dados){

					}

		   		});

			if(check=="nao"){
				//alterar o endereço
			url = "./nconcordo.php?id="+idResposta;
				window.location.assign(url);
			}
			else if(<?php echo $flag_resposta; ?> == 1){
			{document.getElementById("b3").style.display="block";}
			{document.getElementById("b2").style.display="none";}
			}
	//		window.location.assign('http://200.144.255.42:8003/questionario/index.php');

		});

		});


			function finalizar(){//alterar o endereco
				window.location.assign('./index.php');
			}






		</script>


		<!-- end: JavaScript Event Handlers for this page -->
		<!-- end: CLIP-TWO JAVASCRIPTS -->
	</body>
</html>
