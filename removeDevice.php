<?php
include('config.php');

if (empty($_GET)){
	echo "none";
    }
else{

	$ip = $_GET["ip"];

	$check = $db->query("SELECT * FROM info WHERE IP='$ip'");
	while($i = $check->fetchArray(SQLITE3_ASSOC)){
		//print_r($i['IP']);
		if ($i['IP'] != $ip) {
			echo 'No IP Found';
		}
		else{
			$sql1 =<<<EOF
			DELETE FROM info WHERE IP = '$ip';
EOF;
			$run1 = $db->exec($sql1);
			//print($run1);
			if(!$run1){
				echo "FAIL";
			}
			else{
				echo "REMOVED";}

			$sql2 =<<<EOF
			DELETE FROM status WHERE IP = '$ip';
EOF;
			$run2 = $db->exec($sql2);
			//print($run2);
			if(!$run1){
				echo "FAIL";
			}
			else{
				echo "REMOVED";}
		}
	}
}

$db->close();
?>

