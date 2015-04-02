<?php

  session_start();
  
  $userName = $_POST['userName'];
  $userPassword = $_POST['userPassword'];

  $serverName = "127.0.0.1";
  $connectionInfo = array("Database"=>"PoliceTest", "UID"=>"sa", "PWD"=>"A06a30adr5d");

  $conn = sqlsrv_connect($serverName, $connectionInfo);

  if(!$conn) {
    die(print_r( sqlsrv_errors(), true));
  }

  $sql = "SELECT Username, Name, MiddleName, LastName, MaidenName, Job FROM Employee WHERE Username = '$userName' and UserPassword = '$userPassword'";
  $stmt = sqlsrv_query($conn, $sql);
  $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
  $_SESSION['username'] = $row['Username'];
  $_SESSION['name'] = $row['Name'];
  $_SESSION['initial'] = $row['MiddleName'];
  $_SESSION['last'] = $row['LastName'];
  $_SESSION['maiden'] = $row['MaidenName'];
  $_SESSION['job'] = $row['Job'];
  
  if ($stmt === false) {
    die(print_r( sqlsrv_errors(), true));
  }
  elseif ($row['Job'] == "secretary") {
    echo "Login OK";
    header("Location:secretaryPagehtml.php");
  }
  elseif ($row['Job'] == "attorney") {
    echo "Login OK";
    header("Location:attorneyPagehtml.php");
  }
  elseif ($row['Job'] == "admin") {
    echo "Login OK";
    header("Location:adminPagehtml.php");
  }
  else {
    echo "Error";
    header("Location:IniciarSesionhtml.php");
  }

  sqlsrv_close($conn);

?>
