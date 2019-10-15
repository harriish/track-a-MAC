<?php

include('config.php')

if (empty($_GET)){
    echo "none";
    }
else {
    $ip = $_GET["ip"]
    $port = $_GET["port"];
    $community = $_GET["community"];
    $version = $_GET["version"];
      
    $sqlite1 = <<<EOF
        CREATE TABLE IF NOT EXISTS info (IP VARCHAR(30), PORT VARCHAR(30), COMMUNITY VARCHAR(30), VERSION VARCHAR(10));
EOF;
    $run1 = $db->exec($sqlite1);
    if (!$run1) {
        echo $db->lastErrorMsg();}#Returns text which describes failed SQLite request
        
        
        $sqlite2 = <<<EOF
        CREATE TABLE IF NOT EXISTS Status  (IP VARCHAR(30), PORT VARCHAR(30), COMMUNITY VARCHAR(30), VERSION VARCHAR(30), FIRST_PROBE VARCHAR(30), LATEST_PROBE(30) VARCHAR(30), FAILED_ATTEMPTS INTEGER(30));
EOF;
    $run2 = $db->exec($sqlite2);
    if (!$run2) {
        echo $db->lastErrorMsg();}


        $sql3 = <<<EOF
        INSERT INTO info (IP,PORT,COMMUNITY,VERSION)
        VALUES ('$ip','$port','$community','$version');
EOF;
      $run3 = $db->exec($sql3);
      if (!$run3){
        echo $db->LastErrorMsg();
        } else {
            echo "OK";
              }
    $sql4 = <<<EOF
        INSERT INTO Status (IP,PORT,COMMUNITY,VERSION)
        VALUES ('$ip','$port','$community','$version');
EOF;
      $run4 = $db->exec($sql4);
      if (!$run4){
        echo $db->LastErrorMsg();
        }
    $db->close();
    }
    ?>
