<?php

class Crud
{
   var $tabela;
   var $campos;
   var $valores;
   var $condicao;
   var $error = "erro";
   var $sucess = "sucesso";
   var $id;
   var $conn;
   var $bind_param;
   var $bind_param_values;
   var $query;
   private $DB_HOSTNAME = '';
   private $DB_USERNAME = '';
   private $DB_PASSWORD = '';
   private $DB_DATABASE = '';

   function __construct()
   {
      $results = resolveDbConfig();
      $this->DB_HOSTNAME = $results['DB_HOSTNAME'];
      $this->DB_USERNAME = $results['DB_USERNAME'];
      $this->DB_PASSWORD = $results['DB_PASSWORD'];
      $this->DB_DATABASE = $results['DB_DATABASE'];
   }

   function conn()
   {
      try {
         $this->conn = new mysqli(
            $this->DB_HOSTNAME,
            $this->DB_USERNAME,
            $this->DB_PASSWORD,
            $this->DB_DATABASE,
            3306
         );
      } catch (mysqli_sql_exception $e) {
         echo "Não foi possível conectar ao banco";
         exit;
      }
      if (mysqli_connect_errno()) {
         echo "Não foi possível conectar ao banco";
         exit;
      }
      return $this->conn;
   }

   function setCharSet()
   {
      consoleLog("Charset utf8mb4");
      $this->conn->set_charset("utf8mb4");
      if (true !== $this->conn->set_charset('utf8mb4')) {
         throw new \Exception($this->conn->errno);
      }
      if (true !== $this->conn->query(
         'SET collation_connection = @@collation_database;'
      )) {
         throw new \Exception($this->conn->errno);
      }
   }

   function close()
   {
      return $this->conn->close();
   }

   function selectArrayPostWhere($campos, $tabela, $condicao)
   {
      $this->campos = $campos;
      $this->tabela = $tabela;
      $this->condicao = $condicao;
      $this->query = "select $this->campos from $this->tabela $this->condicao";
      $conn = $this->conn;
      return $conn->query($this->query);
   }

   function selectCustomQuery($custom)
   {
      $conn = $this->conn;
      return $conn->query($custom);
   }

   function executeBound($sql, $types, $values)
   {
      if (!boundQueryAllowed($sql, $values)) {
         throw new InvalidArgumentException(
            'SQL must use bound placeholders'
         );
      }
      if (!is_string($types) || strlen($types) !== count($values)) {
         throw new InvalidArgumentException('bind types mismatch');
      }
      $conn = $this->conn();
      $stmt = $conn->prepare($sql);
      if ($stmt === false) {
         throw new RuntimeException('prepare failed');
      }
      $stmt->bind_param($types, ...$values);
      $ok = $stmt->execute();
      $stmt->close();
      return $ok;
   }

   function getLastID()
   {
      $conn = $this->conn;
      return $conn->insert_id;
   }

   function maiorValor(array $maiorValor)
   {
      $nomeCorreto = array(
         "Avanco" => "Avanco",
         "Competicao" => "Competicao",
         "Mecanica" => "Mecanica",
         "Socializacao" => "Socializacao",
         "Relacionamento" => "Relacionamento",
         "Trabalhoequipe" => "Trabalho em equipe",
         "Descoberta" => "Descoberta",
         "Roleplaying" => "Role Playing",
         "Customizacao" => "Customizacao",
         "Escapismo" => "Escapismo",
         "empate" => "Empate",
      );
      $valorAtual = 0;
      $valorIgual = 0;
      $arrayPerfisEmpate = array();
      $retorno = array();
      $perfilPrincipal = 'empate';
      foreach ($maiorValor as $key => $value) {
         if ($value > $valorAtual) {
            $valorAtual = $value;
            $perfilPrincipal = $key;
         } elseif ($value == $valorAtual) {
            $valorIgual = $valorAtual;
            $arrayPerfisEmpate[] = $key;
         }
      }
      if ($valorIgual == $valorAtual) {
         $perfilPrincipal = "empate";
      }
      $retorno['perfisEmpate'] = $arrayPerfisEmpate;
      $retorno['nomeCorreto'] = $nomeCorreto[$perfilPrincipal];
      return $retorno;
   }
}
