
<?php
class mydb extends SQLite3 {
      function __construct() {
         $this->open('mydatabase.db');
      }
   }
 $db = new mydb();
?>
