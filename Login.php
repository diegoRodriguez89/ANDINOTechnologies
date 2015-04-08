<?php
  session_start();


  /* Server
    $serverName = the name of the server to connect
    $connectionInfo = creates an array with the database name, the user id of the database and the user's password of the database
    $conn = sqlsrv_connect() = is the function to connect with the server
  */
  $serverName = "127.0.0.1";
  $connectionInfo = array("Database"=>"PoliceTest", "UID"=>"sa", "PWD"=>"A06a30adr5d");
  $conn = sqlsrv_connect($serverName, $connectionInfo);

  /*
    $userName and $userPassword variables contain the username and the password of the users signed in the log in page.
    These variables are used to verify if the input information are part of the system and identify the employee's identity (administrator, attorney
    or secretary).
  */
  $userName = $_POST['userName'];
  $userPassword = $_POST['userPassword'];
  
  $userName = mysql_real_escape_string($userName);
  $userPassword = mysql_real_escape_string($userPassword);
  
  //Verifies if the connection with the server is successful
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
  
  /*
  The following code will redirect the user depending on its function. If the logged user is a secretary it will redirect the user to
  the secretary's main page. If the first condition is false, then it will verify if the logged user is an attorney. If the condition is true,
  it will redirect the user to the attorney's main page. If the user is an administator then it redirects to the administrator's main page.
  If none of the conditions are met then it returns nothing. 
  */
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

  //Close the server connection
  sqlsrv_close($conn);
?>
