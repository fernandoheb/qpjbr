<?php

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
   $root = defined('QPJBR_ROOT')
      ? QPJBR_ROOT
      : dirname(dirname(__DIR__));
   $parsed = loadDotEnv($root . DIRECTORY_SEPARATOR . '.env');
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
