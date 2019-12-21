<?php

include('config.php');

$ip = $_GET['ip']
$port = $_GET['port'];
$community = $_GET['community'];
$version = $_GET['version'];

if(empty($ip) || empty($port) || empty($community) || empty($version)) {
    echo "FALSE" ;   
}

else {
    $run1 = $db->query('SELECT * FROM info');
    $count = 0;
    foreach ($run1 as $run1) {
        if($run1['ip']==$ip && $run1['port']==$port && $run1['community']==$community && $run1['version']==$version){
            $count = $count+1;

        }
    }

    if($count==0){
        $db->exec("INSERT INTO info (ip,port,community,version) VALUES ('$ip','$port','$community','$version')");
        echo "OK";
    }
    else {
        echo "FALSE";
    }
}
$db->close();

?>
