<?php

  $serverName = "127.0.0.1";
  $connectionInfo = array("Database"=>"PoliceTest", "UID"=>"sa", "PWD"=>"A06a30adr5d");

  $conn = sqlsrv_connect($serverName, $connectionInfo);
  if( !$conn ) {
    die( print_r( sqlsrv_errors(), true));
  }
  $sql = "DELETE FROM Employee WHERE Username = '$target'";
  $stmt = sqlsrv_query($conn, $sql);
