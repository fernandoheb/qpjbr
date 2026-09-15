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

function envOr($key, $fallback, $parsed = array())
{
   $val = getenv($key);
   if ($val !== false) {
      return $val;
   }
   if (array_key_exists($key, $parsed)) {
      return $parsed[$key];
   }
   return $fallback;
}

function resolveDbConfig()
{
   $parsed = loadDotEnv(dirname(__FILE__) . '/.env');
   return array(
      'DB_HOSTNAME' => envOr(
         'DB_HOSTNAME', 'localhost', $parsed
      ),
      'DB_USERNAME' => envOr(
         'DB_USERNAME', '', $parsed
      ),
      'DB_PASSWORD' => envOr(
         'DB_PASSWORD', '', $parsed
      ),
      'DB_DATABASE' => envOr(
         'DB_DATABASE', 'qpjbr', $parsed
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
   
   function setCharSet() {
      consoleLog("Charset utf8mb4");
       $this->conn->set_charset("utf8mb4");
       if ( TRUE !==  $this->conn->set_charset( 'utf8mb4' ) ) {
         throw new \Exception(  $this->conn->errno );
       }
       if ( TRUE !==  $this->conn->query( 'SET collation_connection = @@collation_database;' ) ) {
         throw new \Exception(  $this->conn->errno );
       }
   }

   function close() {
      return $this->conn->close();
   }

   function selectArrayPostWhere($campos, $tabela, $condicao) {
      // why: callers pass campos as a string and condicao already
      // including WHERE / ORDER BY (see saveData.php).
      $this->campos = $campos;
      $this->tabela = $tabela;
      $this->condicao = $condicao;
      $this->query = "select $this->campos from $this->tabela $this->condicao";
      $conn = $this->conn;
      return $conn->query($this->query);
   }

   function selectCustomQuery($custom) {
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

   function getLastID() {
      $conn = $this->conn;
      return $conn->insert_id;
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


function consoleLog($texto) {
   echo "<script> console.log('$texto'); </script>";
}

?>
