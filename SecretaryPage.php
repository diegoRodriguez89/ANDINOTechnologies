<?php
  session_start();

  $serverName = "127.0.0.1";
  $connectionInfo = array("Database"=>"PoliceTest", "UID"=>"sa", "PWD"=>"A06a30adr5d");

  $conn = sqlsrv_connect($serverName, $connectionInfo);

  if($conn) {
    echo "Ok";
    header("Location:secretaryPagehtml.php");
  }
  
?>
