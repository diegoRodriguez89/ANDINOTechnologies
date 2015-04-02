<?php

  session_start();

  $oldName = $_POST['oldName'];
  $newName = $_POST['newName'];
  $oldPassword = $_POST['oldPassword'];
  $newPassword = $_POST['newPassword'];

  $serverName = "127.0.0.1";
  $connectionInfo = array("Database"=>"PoliceTest", "UID"=>"sa", "PWD"=>"A06a30adr5d");

  $conn = sqlsrv_connect($serverName, $connectionInfo);

  if(!$conn) {
    die( print_r( sqlsrv_errors(), true));
  }

  $sql = "UPDATE Employee SET Username = '$newUsername', Password = '$newPassword' WHERE Username = '$oldUsername'";
  $stmt = sqlsrv_query($conn, $sql);
  $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
  if ($stmt === false) {
    die(print_r( sqlsrv_errors(), true));
  }
  else {
    $sql2 = "SELECT Username, Name, MiddleName, LastName, MaidenName, Job FROM Employee WHERE Username = '$newName' and UserPassword = '$newPassword'";
    $stmt2 = sqlsrv_query($conn, $sql);
    $row2 = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    $_SESSION['username'] = $row['Username'];
    $_SESSION['name'] = $row['Name'];
    $_SESSION['initial'] = $row['MiddleName'];
    $_SESSION['last'] = $row['LastName'];
    $_SESSION['maiden'] = $row['MaidenName'];
    if ($stmt2 === false) {
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
  }
  
  sqlsrv_close($conn);

?>
