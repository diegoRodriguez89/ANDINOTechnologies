<?php

  session_start();

  $Name = $_POST['employeeName'];
  $Initial = $_POST['employeeInitial'];
  $lastName = $_POST['employeeLastname'];
  $maidenName = $_POST['employeeLastname2'];
  $employeeJob = $_POST['TypeEmployee'];
  $Username = $_POST['Username'];
  $Password = $_POST['passWord'];
//$Password = mysqli_real_escape_string($_POST['passWord']);

  $serverName = "127.0.0.1";
  $connectionInfo = array("Database"=>"PoliceTest", "UID"=>"sa", "PWD"=>"A06a30adr5d");

  $conn = sqlsrv_connect($serverName, $connectionInfo);

  if(!$conn) {
    die(print_r( sqlsrv_errors(), true));
  }


  $sql = "INSERT INTO Employee VALUES('$Username', '$Password', '$Name', '$Initial', '$lastName', '$maidenName', 'Hato Rey', '$employeeJob')";
  $stmt = sqlsrv_query($conn, $sql);
  $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
  if ($stmt === false) {
    die($sql);
  }
  header("Location:employeeListhtml.php");

  sqlsrv_close($conn);

?>
