<?php
  session_start();

  $serverName = "127.0.0.1";
  $connectionInfo = array("Database"=>"PoliceTest", "UID"=>"sa", "PWD"=>"A06a30adr5d");

  $conn = sqlsrv_connect($serverName, $connectionInfo);
  $job = "$_SESSION[job]";

  if(!$conn) {
    die(print_r( sqlsrv_errors(), true));
  }

	if ($job == "secretary") {
		header("Location:secretaryPagehtml.php");
  }
  elseif ($job == "attorney") {
  	header("Location:attorneyPagehtml.php");
	}
	elseif ($job == "admin") {
		header("Location:adminPagehtml.php");
  }

  sqlsrv_close($conn);
  
?>
