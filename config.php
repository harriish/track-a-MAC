
<?php
class mydb extends SQLite3 {
      function __construct() {
         $this->open('mydatabase.db');
      }
}
$db = new Mydb();

$sqlite1 =<<<EOF

   CREATE TABLE IF NOT EXISTS List(DeviceIP varchar not null, VLANs varchar not null, port varchar, MACS varchar);
EOF;
$result = $db->exec($sq1);
if(!$result){
   echo $db->lastErrorMsg();
}
$sqlite1 =<<<EOF

      CREATE TABLE IF NOT EXISTS info (IP varchar not null,PORT varchar not null,COMMUNITY string not null ,VERSION varchar not null, FIRST_PROBE varchar, LATEST_PROBE varchar null,FAIED_ATTEMPTS int default 0 not null);

EOF;

   $result = $db->exec($sqlite1);
   if(!$result){
      echo $db->lastErrorMsg();
   }

?>
