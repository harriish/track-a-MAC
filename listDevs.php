<?php

include('config.php');

$statistics = $db->query('SELECT * FROM info');

while ($row = $statistics->fetchArray()){
	echo $row['IP']. "|" .$row['PORT']. "|" .$row['COMMUNITY']. "|" .$row['VERSION']. "|" .$row['FIRST_PROBE']. "|" .$row['LATEST_PROBE']. "|" .$row['Failed_attempts']. "\n";
}
}
?>
