<?php

include('config.php');

$read = $db->query('SELECT count(*) FROM List');
while($i = $read->fetchArray(SQLITE3_ASSOC)){

	if ($i['count(*)']==0) {
		echo "we didn't find any assosiated mac addresses ";
	}

else{
$statistics = $db->query('SELECT * FROM List');

while ($row = $statistics->fetchArray()){
	echo $row['IP']. "|" .$row['VLAN']. "|" .$row['PORT']. "|" .$row['MACS']. "\n";
}
}
}
?>
