<?php

include('config.php');

$sqlite1 =<<<EOF
	SELECT * from List;
EOF;
	$result = $db->http_build_query($sqlite1);
	while($row = $result->fetchArray(SQLITE3_ASSOC) ) {
		echo  $row['DeviceIP']. "|" .$row['VLAN']. "|" .$row['PORT']. "|" .$row['MACS']. "\n";
	}
	$db->close();

?>
