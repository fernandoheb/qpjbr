<?php
 header("Content-type: text/html; charset=utf-8");
setlocale(LC_ALL, 'pt_BR.UTF8');

$endereco = './index.php';
$resultado = './resultado.php';
$salvar = './saveData.php';

function loadDotEnv($path)
{
   $out = array();
   if (!is_readable($path)) {
      return $out;
   }
   $lines = file($path, FILE_IGNORE_NEW_LINES);
   foreach ($lines as $line) {
      $line = trim($line);
      if ($line === '' || (isset($line[0]) && $line[0] === '#')) {
         continue;
      }
      $pos = strpos($line, '=');
      if ($pos === false) {
         continue;
      }
      $key = trim(substr($line, 0, $pos));
      $val = trim(substr($line, $pos + 1));
      $val = trim($val, "\"'");
      $out[$key] = $val;
      putenv($key . '=' . $val);
   }
   return $out;
}

function envOr($key, $fallback)
{
   $val = getenv($key);
   if ($val !== false) {
      return $val;
   }
   return $fallback;
}

function resolveDbConfig()
{
   $parsed = loadDotEnv(dirname(__FILE__) . '/.env');
   $fromFile = array();
   $cfg = dirname(__FILE__) . '/bd.cfg';
   if (is_readable($cfg)) {
      $json = json_decode(file_get_contents($cfg), true);
      if (is_array($json)) {
         $fromFile = $json;
      }
   }
   $legacyDb = '';
   if (isset($fromFile['DB_EXPERIMENTAL'])) {
      $legacyDb = $fromFile['DB_EXPERIMENTAL'];
   } elseif (isset($fromFile['DB_DATABASE'])) {
      $legacyDb = $fromFile['DB_DATABASE'];
   }
   return array(
      'DB_HOSTNAME' => envOr(
         'DB_HOSTNAME',
         isset($fromFile['DB_HOSTNAME']) ? $fromFile['DB_HOSTNAME'] : 'localhost'
      ),
      'DB_USERNAME' => envOr(
         'DB_USERNAME',
         isset($fromFile['DB_USERNAME']) ? $fromFile['DB_USERNAME'] : ''
      ),
      'DB_PASSWORD' => envOr(
         'DB_PASSWORD',
         isset($fromFile['DB_PASSWORD']) ? $fromFile['DB_PASSWORD'] : ''
      ),
      'DB_DATABASE' => envOr(
         'DB_DATABASE',
         isset($parsed['DB_DATABASE']) ? $parsed['DB_DATABASE'] : $legacyDb
      ),
   );
}

function boundQueryAllowed($sql, $values)
{
   if (!is_string($sql) || $sql === '' || !is_array($values)) {
      return false;
   }
   if (strpos($sql, '?') === false) {
      return false;
   }
   if (substr_count($sql, '?') !== count($values)) {
      return false;
   }
   if (strpos($sql, "'") !== false || strpos($sql, '"') !== false) {
      return false;
   }
   return true;
}

function httpBadRequest($detail)
{
   header('HTTP/1.1 400 Bad Request');
   http_response_code(400);
   echo $detail;
   exit;
}

function requireInt($raw, $name)
{
   if ($raw === null || $raw === false || $raw === '') {
      httpBadRequest('invalid ' . $name);
   }
   $int = filter_var($raw, FILTER_VALIDATE_INT);
   if ($int === false) {
      httpBadRequest('invalid ' . $name);
   }
   return $int;
}

function requireConsent($raw)
{
   if ($raw !== '1' && $raw !== 1) {
      httpBadRequest('consent required');
   }
   return 1;
}

/*
  $endereco = 'http://localhost/git/questionarioLocal/index.php';
  $resultado = 'http://localhost/git/questionarioLocal/resultado3c.php';
  $salvar = 'http://localhost/git/questionarioLocal/saveData3.php'; */

Class Crud {

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
   private $url = ".env";
   private $DB_HOSTNAME = '';
   private $DB_USERNAME = '';
   private $DB_PASSWORD = '';
   private $DB_DATABASE = '';

   function __construct() {
      $results = resolveDbConfig();
      $this->DB_HOSTNAME = $results['DB_HOSTNAME'];
      $this->DB_USERNAME = $results['DB_USERNAME'];
      $this->DB_PASSWORD = $results['DB_PASSWORD'];
      $this->DB_DATABASE = $results['DB_DATABASE'];
   }

   /* 	private $DB_HOSTNAME = 'localhost';
     private $DB_USERNAME = 'root';
     private $DB_PASSWORD = '';
     private $DB_DATABASE = 'bd'; */

   function conn() {
      try {
         $this->conn = new mysqli($this->DB_HOSTNAME, $this->DB_USERNAME, $this->DB_PASSWORD, $this->DB_DATABASE, 3306);
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

   function selectDB($DB) {
      return $this->conn->select_db($DB);
   }

   function setCharSet() {
      consoleLog("Charset utf8mb4");
      //$this->conn->set_charset("utf8");
       $this->conn->set_charset("utf8mb4");
       //$this->conn->query("set names utf8");
      
       if ( TRUE !==  $this->conn->set_charset( 'utf8' ) )
    throw new \Exception(  $this->conn->errno );

      if ( TRUE !==  $this->conn->query( 'SET collation_connection = @@collation_database;' ) )
    throw new \Exception(  $this->conn->errno );
      
   }

   function close() {
      return $this->conn->close();
   }

   function insert($campos, $tabela, $valores) {
      $this->campos = $campos;
      $this->valores = $valores;
      $this->tabela = $tabela;
      $this->query = "insert into $this->tabela ($this->campos) values ($this->valores)";
      $conn = $this->conn;
      $query = $conn->prepare($this->query);
      return $query;
   }

   function fastInsert($campos, $tabela, $valores) {
      $this->campos = $campos;
      $this->valores = $valores;
      $this->tabela = $tabela;
      $this->query = "insert into $this->tabela ($this->campos) values ($this->valores)";
      $conn = $this->conn;
      $w = $conn->query($this->query);
      return $w;
   }

   function update($valores, $tabela, $condicao) {
      $this->valores = $valores;
      $this->condicao = $condicao;
      $this->tabela = $tabela;
      $this->query = "update $this->tabela set $this->valores where $this->condicao";
      $conn = $this->conn;
      $query = $conn->prepare($this->query);
      return $query;
   }

   function selectArrayConditions($campos, $tabela, $condicao) {
      $this->campos = implode(",", $campos);
      $this->tabela = $tabela;
      $this->condicao = $condicao;
      $conn = $this->conn;
      $query = $conn->prepare("SELECT $this->campos FROM $this->tabela WHERE $this->condicao");
      return $query;
   }

   function selectArrayPostWhere($campos, $tabela, $condicao) {
      $this->campos = $campos;
      $this->tabela = $tabela;
      $this->condicao = $condicao;
      $this->query = "select $this->campos from $this->tabela $this->condicao";
      $conn = $this->conn;
      $w = $conn->query($this->query);
      return $w;
   }

   function selectCustomQuery($custom) {
      $this->custom = $custom;
      $conn = $this->conn;
      $w = $conn->query($this->custom);
      return $w;
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

   function getLastID() {
      $conn = $this->conn;
      $w = $conn->insert_id;
      return $w;
   }

   function getAffectedRows() {
      $conn = $this->conn;
      $num = $conn->affected_rows;
      return $num;
   }

   function selectArray($campos) {
      $this->campos = $campos;
      $this->query = "select $this->campos from $this->tabela";
      $w = mysql_query("$this->query");
      return $w;
   }

   function selectDistinct($campos, $tabela, $condicao) {
      $this->campos = $campos;
      $this->condicao = $condicao;
      $this->tabela = $tabela;
      $this->query = "SELECT DISTINCT $this->campos from $this->tabela $this->condicao";
      $conn = $this->conn;
      $w = $conn->query($this->query);
      return $w;
   }

   function delete($tabela, $condicao) {
      $this->condicao = $condicao;
      $this->tabela = $tabela;
      $this->query = "delete from $this->tabela where $this->condicao";
      $conn = $this->conn;
      $w = $conn->query($this->query);
      return $w;
   }

   function setMsgSucesso($msg) {
      $this->sucess = $msg;
   }

   function setMsgErro($msg) {
      $this->error = $msg;
   }

   function real_escape_string($var) {
      $this->value = $var;
      $conn = $this->conn;
      $w = $conn->real_escape_string($this->value);
      return $w;
   }

   function maiorValor(array $maiorValor) {
      $nomeCorreto = array("Avanco" => "Avanco", "Competicao" => "Competicao", "Mecanica" => "Mecanica", "Socializacao" => "Socializacao", "Relacionamento" => "Relacionamento", "Trabalhoequipe" => "Trabalho em equipe", "Descoberta" => "Descoberta", "Roleplaying" => "Role Playing", "Customizacao" => "Customizacao", "Escapismo" => "Escapismo", "empate" => "Empate");
      $valorAtual = 0;
      $valorIgual = 0;
      $arrayPerfisEmpate = array();
      $retorno = array();
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
         //teve impate
         $perfilPrincipal = "empate";
      }
      $retorno['perfisEmpate'] = $arrayPerfisEmpate;
      $retorno['nomeCorreto'] = $nomeCorreto[$perfilPrincipal];
      return $retorno;
   }
}

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

//General functions
function fetchAll($result) {
   while ($row = $result->fetch_assoc()) {
      $results_array[] = $row;
   }
   return $results_array;
}

function consoleLog($texto) {
   echo "<script> console.log('$texto'); </script>";
}

?>
