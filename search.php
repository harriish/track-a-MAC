<?php
include('config.php');

if(empty($_GET)){
    echo "It is False";
    }
else {
    $my_search_is = $_GET["mac"];


    $sq1 = <<<EOF
                SELECT * FROM List WHERE LIKE "%$my_search_is%" ORDER BY MACS;
EOF;

$my_output_is = $db->query($sq1ite1);
$data = array();
while($row = $my_output_is->fetchArray(SQLITE3_ASSOC) ) {


        $data[] = $row['DeviceIP']. "|" .$row['VLAN']. "|" .$row['PORT']. "|" . "$my_search_is";
    
    }


$flag = count($data);
if($flag == 0){



    $count = $db->query('SELECT count(*) FROM info')
    while($check = $count->fetchArray(SQLITE_ASSOC)) {
        $number_of_devices = $check['count(*)'];#support wildcards
        echo "we found no match in $number_of_devices devices";
    }
}



$my_result_is = array_unique($data);
$total = count($my_result_is);


for($i=0; $i < $total; $i++){
    echo $my_result_is[$i]. "\n";
    }
}
$db->close();
?>
