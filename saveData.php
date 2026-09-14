<?php

	include 'functions.inc2.php';

	$puxaBD = new Crud();
	$puxaBD->conn();
	
	/*	$email = utf8_decode($_POST["email"]);
		consoleLog($email);
		$retorno = $puxaBD->selectCustomQuery("select * from resposta where email = '$email'");
		
		$row = $retorno->fetch_assoc();
		consoleLog("id =".$row['id']);	*/
	//Salva as Respostas dos usuários
	if(isset($_GET["salvar"])){
			$Codigo_Experimental='expontaneo';
            $nome=$email=$genero=$escolaridade=$idade='';	
            if(isset($_POST['nomeApelido'])) {	
                    $nome = utf8_decode($_POST["nomeApelido"]);
            }	
            if(isset($_POST['email'])) {
                    $email = utf8_decode($_POST["email"]);
            }	
            if(isset($_POST['generoSexual'])) {
                    $genero = utf8_decode($_POST["generoSexual"]);
            }			
            if(isset($_POST['escolaridade'])) {
                    $escolaridade = utf8_decode($_POST["escolaridade"]);
            }	
            if(isset($_POST['CodGrpExp'])) {
                    $Codigo_Experimental = utf8_decode($_POST["CodGrpExp"]);
            }	
            if(isset($_POST['idade'])) {
                    $idade = utf8_decode($_POST["idade"]);
            }

                /*$link = mysql_connect("localhost","root","");
                mysql_select_db("brunopra_yee");
                $sql1="select * from `resposta` order by id DESC";
                $array = mysql_fetch_object(mysql_query($sql1));
                $idnext = $array->id + 1;*/

	$puxaBD->executeBound(
                'INSERT INTO `resposta`(`nome`, `email`, `genero`, `escolaridade`, `idade`,`Codigo_G_Exp`) VALUES (?, ?, ?, ?, ?, ?)',
                'ssssss',
                array(
                    $nome,
                    $email,
                    $genero,
                    $escolaridade,
                    $idade,
                    $Codigo_Experimental
                )
        );
	

		//$query1 = $puxaBD->selectCustomQuery('INSERT INTO `resposta`( `email`) VALUES ("'.utf8_decode($_POST["email"]).'")');	
	
                //getLastID() recupera o último auto_incremento inserido. 
               $id =$puxaBD -> getLastID();
		// consoleLog($testeid);
   
		//$retorno = $puxaBD->selectCustomQuery("select * from resposta where email = '$email' order by datetime DESC");
		//$row = $retorno->fetch_assoc();
		$idnext = $id; // = $row['id'];
	        //echo ("id = $id");	
                
                foreach ($_POST as $indice => $val) {
                    try {
                        if (substr($indice,0,strpos($indice,"_")) == "questao" ) {
                                $questaoid = substr(
                                    $indice,
                                    strpos($indice, "_") + 1
                                );
                                $questaoid = requireInt(
                                    $questaoid,
                                    'questaoid'
                                );
                                $valorResposta = requireInt(
                                    $val,
                                    'valorResposta'
                                );
                                $puxaBD->executeBound(
                                    'INSERT INTO `resp_quest`( `questaoid`,`respostaid`,`valorResposta`) VALUES (?, ?, ?)',
                                    'iii',
                                    array($questaoid, $id, $valorResposta)
                                );
                        }
                    } catch (Exception $e){consoleLog($e);}
                        
                                                       
                }
                $avanco = $mecanica = $competicao = $descoberta =  $roleplaying =  $escapismo =    $customizacao = $trabalhoequipe = 
                                $socializacao = $social = $relacionamento= $realizacao = $imersao = 0;
                
                $resultadoMediaSubFator = calculaMediaSUBFator($id);
                while ($row = $resultadoMediaSubFator->fetch_assoc()){
                    switch ($row["subfator"]) {
                        
                    //Realização
                            case "Avanço" :                           
                                 $avanco = $row["Media"];
                               break;
                            case "Mecanica" :
                                $mecanica = $row["Media"];
                                break;
                            case "Competição" :
                                 $competicao = $row["Media"];
                                break;
                    //imersao
                            case "Descoberta" :
                                $descoberta = $row["Media"];
                                break;
                            case "Role Playing" :
                                $roleplaying = $row["Media"];
                                break;
                            case "Escapismo" :
                                $escapismo = $row["Media"];
                                break;
                            case "Customização" :
                                $customizacao = $row["Media"];
                                break;
                    //Social
                            case "Trabalho em equipe" :
                                $trabalhoequipe = $row["Media"];
                                break;
                            case "Socialização" :
                                $socializacao = $row["Media"];
                                break;
                            case "Relacionamento" :
                                 $relacionamento = $row["Media"];
                            break;                                                        
                    }
                }
                         
                               
                                 
                $resultadoMediaFator = calculaMediaFator($id);
                while ($row = $resultadoMediaFator->fetch_assoc()){
                    switch($row["fator"]){
                        case "A" :  $realizacao = $row["Media"]; break;
                        case "S" :  $social = $row["Media"]; break;
                        case "I" :  $imersao = $row["Media"]; break;
                    }
                }
        //}
        
                

		$maiorFator = max($realizacao,$imersao,$social);

		$nomeTipoJogador = "";
		$tiposEmpatados = "";

		if($maiorFator == $realizacao){
			$arrayRealizacao = array("Avanco"=>$avanco,"Competicao"=>$competicao,"Mecanica"=>$mecanica);
			$arrayRetornoMaiorValor =  $puxaBD->maiorValor($arrayRealizacao);
			$nomeTipoJogador = $arrayRetornoMaiorValor['nomeCorreto'];
			$tiposEmpatados = $arrayRetornoMaiorValor['perfisEmpate'];
                        $nomeFatorPrincipal = "Realizacao";
		}
		elseif($maiorFator == $social){
			$arraySocial = array("Relacionamento"=>$relacionamento,"Socializacao"=>$socializacao,"Trabalhoequipe"=>$trabalhoequipe);
			$arrayRetornoMaiorValor =  $puxaBD->maiorValor($arraySocial);
			$nomeTipoJogador = $arrayRetornoMaiorValor['nomeCorreto'];
			$tiposEmpatados = $arrayRetornoMaiorValor['perfisEmpate'];
                        $nomeFatorPrincipal = "Social";
		}
		elseif($maiorFator == $imersao){
			$arrayImersao = array("Customizacao"=>$customizacao,"Escapismo"=>$escapismo,"Descoberta"=>$descoberta,"Roleplaying"=>$roleplaying);
			$arrayRetornoMaiorValor =  $puxaBD->maiorValor($arrayImersao);
			$nomeTipoJogador = $arrayRetornoMaiorValor['nomeCorreto'];
			$tiposEmpatados = $arrayRetornoMaiorValor['perfisEmpate'];
                        $nomeFatorPrincipal = "Imersao";
		}

                if(($realizacao == $maiorFator && ($realizacao == $imersao || $social == $realizacao)) || (($imersao == $maiorFator && $imersao == $social))){
                        $nomeFatorPrincipal="Empate";
                }


		$maiorValor= array("avanco"=>$avanco,"competicao"=>$competicao,"mecanica"=>$mecanica,"socializacao"=>$socializacao,"relacionamento"=>$relacionamento,"trabalhoequipe"=>$trabalhoequipe,"descoberta"=>$descoberta,"roleplaying"=>$roleplaying,"customizacao"=>$customizacao,"escapismo"=>$escapismo);
	//	$pegaIdResposta = $puxaBD->selectCustomQuery('SELECT id FROM `resposta` where nome = "'.utf8_decode($_POST["nomeApelido"]).'" and email = "'.utf8_decode($_POST["email"]).'"'); //procura pro nome e e-mail, mudando o nome pode ter 2 com o mesmo email.
	//	$idResposta = $pegaIdResposta->fetch_assoc();



	//////	$pegaIdResposta = $puxaBD->selectCustomQuery('SELECT id FROM `resposta` where nome = "'.utf8_decode($_POST["nomeApelido"]).'" and email = "'.utf8_decode($_POST["email"]).' order by nome, email Desc"');
	//////	$idReposta = $pegaIdResposta->fetch_assoc();

		$xid = array($avanco, $escapismo,  $socializacao, $competicao, $customizacao,  $relacionamento, $mecanica, $roleplaying, $trabalhoequipe, $descoberta, $idnext);
            //    echo "xid = $xid[0] <br>";
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
                            $nomeFatorPrincipal
                        )
                );

	//	$insereSubfatores_query = $puxaBD->selectCustomQuery('INSERT INTO `soma`(`idResposta`, `avanco`, `competicao`, `mecanica`, `socializacao`, `relacionamento`, `trabalhoemequipe`, `descoberta`, `roleplaying`, `customizacao`, `escapismo`, `achiever`, `relatedness`, `imersao`, `majoritario`) VALUES ('.$idResposta["id"].','.$avanco.','.$competicao.','.$mecanica.','.$socializacao.','.$relacionamento.','.$trabalhoequipe.','.$descoberta.','.$roleplaying.','.$customizacao.','.$escapismo.','.$realizacao.','.$social.','.$imersao.',"'.$nomeFatorPrincipal.'")');
	//	
		//die($insereSubfatores_query);
		$nomeCorreto= array("avanco"=>"Avanco","competicao"=>"Competicao","mecanica"=>"Mecanica","socializacao"=>"Socializacao","relacionamento"=>"Relacionamento","trabalhoequipe"=>"Trabalho em equipe","descoberta"=>"Descoberta","roleplaying"=>"Role Playing","customizacao"=>"Customizacao","escapismo"=>"Escapismo");


		$puxaSubfatorBanco = $puxaBD->selectArrayPostWhere("*","`subfator`"," WHERE `subfator`='".$nomeTipoJogador."'");// Pega do banco buscando o valor referente na array de valores pelo perfil de maior resultado;
			$valoresSubfator = $puxaSubfatorBanco->fetch_assoc();




		//echo '<script> console.log('. $idResposta["id"].');</script>';

			echo json_encode($xid);

	}

	//Salva as respostas sobre a concordância do usuário
	if(isset($_GET["concordo"])){
		$respostaId = $_POST["respostaId"];
		$respostaOpinao = $_POST["respostaOpinao"];
		$respostaTipoJogador = $_POST["respostaTipoJogador"];

		$insereOpniao = $puxaBD->selectCustomQuery('INSERT INTO `concordo`(`idResposta`, `concordo`, `resultado`)
			VALUES ("'.$respostaId.'", "'.$respostaOpinao.'", "'.utf8_decode($respostaTipoJogador).'")');

		echo json_encode($insereOpniao);//Ã© obrigado o json receber alguma coisa;

	}
	//Salva as respostas caso o usuário discorde do resultado
	if(isset($_GET["nconcordo"])){
		$perfil = $_POST["perfilEscolhido"];
		$id= $_POST["idJogador"];

		$insereOpniao = $puxaBD->selectCustomQuery('INSERT INTO `nconcordo`(`idResposta`, `perfil`)
			VALUES ("'.$id.'", "'.utf8_decode($perfil).'")');

		echo json_encode($insereOpniao);//Ã© obrigado o json receber alguma coisa;

	}
    //Salva as respostas caso o usuário discorde do resultado - Opinião
	if(isset($_GET["perfilIdentificado"])){
		$respostaId = $_POST["respostaId"];
		$respostaOpinao = $_POST["respostaOpinao"];
		$respostaTipoJogador = $_POST["respostaTipoJogador"];

		$insereOpniao = $puxaBD->selectCustomQuery('INSERT INTO `concordo`(`idResposta`, `concordo`, `resultado`)
			VALUES ("'.$respostaId.'", "'.$respostaOpinao.'", "'.$respostaTipoJogador.'")');


		echo json_encode($insereOpniao);//Ã© obrigado o json receber alguma coisa;


		}

		
    //Cálcula a Média por Fator   
    function calculaMediaFator ($ID){
		$puxaBD = new Crud();
		$puxaBD->conn();
		return $res = $puxaBD->selectCustomQuery("select q.fator, Sum(peso),Sum(rq.ValorResposta)'Soma das Respostas', Sum(rq.ValorResposta*q.Peso)/Sum(q.peso) 'Media', AVG(valorResposta) 'MediaSimples', count(*) from resp_quest rq join questao q on q.id = rq.questaoid  where rq.RespostaID=$ID AND q.exibir=1 group by q.fator");
			//em casos de teste, cria a tabela com o resultado da string
	/*		$count = 1;
			echo ("Id  = $ID");
			echo ("<table>");
			while ($row = $res->fetch_assoc()){
				echo("<tr>");
				$size= 0;
				if($count == 1){
					foreach($row as $indice => $linha){
						echo ("<th> $indice      </th>");
						if (++$size == count($row)) 
							{ $size =0; echo ("</tr>");}				
					$count++;
					} 
				}	
				foreach($row as $indice => $linha){
					echo ("<td> $linha </td> ");
					//if (++$size == count($row))  echo "</td>";  
				}
				echo ("</tr>");
			}
			
			echo("</table>");
			$res->free();	*/
		}	
			//calcula a média por subcomponente
	function calculaMediaSUBFator ($ID){
            $puxaBD = new Crud();
            $puxaBD->conn();
            return $res = $puxaBD->selectCustomQuery("select q.subfator, Sum(peso),Sum(rq.ValorResposta)'Soma das Respostas', Sum(rq.ValorResposta*q.Peso)/Sum(q.peso) 'Media', AVG(valorResposta) 'MediaSimples', count(*) from resp_quest rq join questao q on q.id = rq.questaoid  where rq.RespostaID=$ID AND q.exibir=1 group by q.subfator order by q.fator");
			//em casos de teste, cria a tabela com o resultado da string
			/* $count = 1;
			echo ("Id  = $ID");
			echo ("<table>");
			while ($row = $res->fetch_assoc()){
				echo("<tr>");
				$size= 0;
				if($count == 1){
					foreach($row as $indice => $linha){
						echo ("<th> $indice      </th>");
						if (++$size == count($row)) 
							{ $size =0; echo ("</tr>");}				
					$count++;
					} 
				}	
				foreach($row as $indice => $linha){
					echo ("<td> $linha </td> ");
					//if (++$size == count($row))  echo "</td>";  
				}
				echo ("</tr>");
			}
			
			echo("</table>");
			$res->free();	*/
		}

?>
