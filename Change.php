<?php
  //This is to use the $_SESSION variables. This variables are to pass the values from page to page.
  session_start();

  /* Variables
    $oldName = the current username of the employee in the system
    $newName = the new username of the employee in the system
    $oldPassword = the current password of the emplyee in the system
    $newPassword = the new password of the employee in the system
  */
  $oldName = $_POST['oldName'];
  $newName = $_POST['newName'];
  $oldPassword = $_POST['oldPassword'];
  $newPassword = $_POST['newPassword'];

  /* Server
    $serverName = the name of the server to connect
    $connectionInfo = creates an array with the database name, the user id of the database and the user's password of the database
    $conn = sqlsrv_connect() = is the function to connect with the server
  */
  $serverName = "127.0.0.1";
  $connectionInfo = array("Database"=>"PoliceTest", "UID"=>"sa", "PWD"=>"A06a30adr5d");
  $conn = sqlsrv_connect($serverName, $connectionInfo);

  //to verify if the connection with the server is successful
  if(!$conn) {
    die( print_r( sqlsrv_errors(), true));
  }

  /* SQL
    $sql = query to insert the information of the employee in the database with the variable above
    $stmt = sqlsrv_query() = prepares and executes the query
    $row = sqlsrv_fetch_array() = returns the row as an array
    The function mysql_real_escape_string will clear the special characters from the variable.
  */
  $newUsername = mysql_real_escape_string($newUsername);
  $newPassword = mysql_real_escape_string($newPassword);
  $oldUsername = mysql_real_escape_string($oldUsername);

  $newCrypt = md5($newPassword);
  $oldCrypt = md5($oldPassword);
  $sql = "UPDATE Employee SET Username = '$newUsername', Password = '$newCrypt' WHERE Username = '$oldUsername' AND UserPassword = 'oldCrypt'";
  $stmt = sqlsrv_query($conn, $sql);
  $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

  //Verify if the query executed successfully
  if ($stmt === false) {
    die(print_r( sqlsrv_errors(), true));
  }
  else {
    /* SQL
      $sql2 = query to insert the information of the employee in the database with the variable above
      $stmt2 = sqlsrv_query() = prepares and executes the query
      $row2 = sqlsrv_fetch_array() = returns the row as an array
      The function mysql_real_escape_string will clear the special characters from the variable.
    */
    $newName = mysql_real_escape_string($newName);
    $newPassword = mysql_real_escape_string($newPassword);
    $sql2 = "SELECT Username, Name, MiddleName, LastName, MaidenName, Job FROM Employee WHERE Username = '$newName' and UserPassword = '$newPassword'";
    $stmt2 = sqlsrv_query($conn, $sql);
    $row2 = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    /* Variables
      $_SESSION[] = to pass the variables through the pages
    */
    $_SESSION['username'] = $row['Username'];
    $_SESSION['name'] = $row['Name'];
    $_SESSION['initial'] = $row['MiddleName'];
    $_SESSION['last'] = $row['LastName'];
    $_SESSION['maiden'] = $row['MaidenName'];
    //Verify if the query executed successfully
    if ($stmt2 === false) {
      die(print_r( sqlsrv_errors(), true));
    }
    //if the employee is a secretary go to the secretaryPagehtml.php
    elseif ($row['Job'] == "secretary") {
      echo "Login OK";
      header("Location:secretaryPagehtml.php");
    }
    //if the employee is a attorney go to the attorneyPagehtml.php
    elseif ($row['Job'] == "attorney") {
      echo "Login OK";
      header("Location:attorneyPagehtml.php");
    }
    //if the employee is the administrator go to the adminPagehtml.php
    elseif ($row['Job'] == "admin") {
      echo "Login OK";
      header("Location:adminPagehtml.php");
    }
  }
  
  //close the server connection
  sqlsrv_close($conn);
?>
