<?php

function qpjSomaPositivos($fatores)
{
   $soma = 0.0;
   $total = count($fatores);
   $i = 0;
   while ($i < $total) {
      $valor = 0 + str_replace(',', '.', $fatores[$i]);
      if ($valor > 0) {
         $soma = $soma + $valor;
      }
      $i++;
   }
   return $soma;
}


function qpjDistanciaDoTopo($valor, $maiorValor, $positivos)
{
   if (!($positivos > 0)) {
      return 1;
   }
   $valor = 0 + str_replace(',', '.', $valor);
   $maior = 0 + str_replace(',', '.', $maiorValor);
   return ($maior / $positivos) - ($valor / $positivos);
}


function calculaMediaFator($ID)
{
   $puxaBD = new Crud();
   $puxaBD->conn();
   $id = intval($ID);
   return $puxaBD->selectCustomQuery(
      "select q.fator, Sum(peso),Sum(rq.ValorResposta)'Soma das Respostas',"
      . " Sum(rq.ValorResposta*q.Peso)/Sum(q.peso) 'Media',"
      . " AVG(valorResposta) 'MediaSimples', count(*)"
      . " from resp_quest rq join questao q on q.id = rq.questaoid"
      . " where rq.RespostaID=$id AND q.exibir=1 group by q.fator"
   );
}


function calculaMediaSUBFator($ID)
{
   $puxaBD = new Crud();
   $puxaBD->conn();
   $id = intval($ID);
   return $puxaBD->selectCustomQuery(
      "select q.subfator, Sum(peso),Sum(rq.ValorResposta)'Soma das Respostas',"
      . " Sum(rq.ValorResposta*q.Peso)/Sum(q.peso) 'Media',"
      . " AVG(valorResposta) 'MediaSimples', count(*)"
      . " from resp_quest rq join questao q on q.id = rq.questaoid"
      . " where rq.RespostaID=$id AND q.exibir=1"
      . " group by q.subfator order by q.fator"
   );
}
