<?php

$resp  = "";
$pdata = null;

header("Content-Type: text/plain");

if (function_exists("curl_init")) {
  
  if (isset($_POST["url"])) {
      
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, (string) $_POST["url"]);
    
    curl_setopt($c, CURLOPT_FOLLOWLOCATION , 1);
    curl_setopt($c, CURLOPT_FRESH_CONNECT  , 1);
    curl_setopt($c, CURLOPT_HEADER         , 0);
    curl_setopt($c, CURLOPT_MAXREDIRS      , 10);
    
    if (isset($_POST["data"])) {
      
      $pdata = $_POST["data"];
      
      curl_setopt($c, CURLOPT_POST, true);
      curl_setopt($c, CURLOPT_POSTFIELDS, 
        (is_array($pdata) ? http_build_query($pdata) : (string) $pdata));
      
    } else {
      curl_setopt($c, CURLOPT_HTTPGET, 1);
    }
    
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($c, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    
    $resp = curl_exec($c);
    
  }
  
}

echo $resp;

exit;
