<?php

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
