<?php
  //This is to use the $_SESSION variables. This variables are to pass the values from page to page.
  session_start();

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
    die(print_r( sqlsrv_errors(), true));
  }

  //$newName = the name of the new employee that will be in charge of the document
  $newName = $_POST['caseReceiver'];

   /* SQL
    $sql = query to insert the information of the employee in the database with the variable above
    $stmt = sqlsrv_query() = prepares and executes the query
    $row = sqlsrv_fetch_array() = returns the row as an array
    The function mysql_real_escape_string will clear the special characters from the variable.
  */
  $newName = mysql_real_escape_string($newname);
  $sql = "INSERT INTO History VALUES('$_SESSION[docID]', GETDATE(), '$_SESSION[oldName]', '$newName')";
  $stmt = sqlsrv_query($conn, $sql);
  $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

  //Verify if the query executed successfully
  if ($stmt === false) {
    echo "primer if";
    echo $sql;
    die(print_r( sqlsrv_errors(), true));
  }

  /* SQL
    $sql2 = query to insert the information of the employee in the database with the variable above
    $stmt2 = sqlsrv_query() = prepares and executes the query
    $row2 = sqlsrv_fetch_array() = returns the row as an array
    The function mysql_real_escape_string will clear the special characters from the variable.
  */
  $newName = mysql_real_escape_string($newname);
  $sql2 = "UPDATE Manage SET EmployeeName = '$newName' WHERE DocID = $_SESSION[docID]";
  $stmt2 = sqlsrv_query($conn, $sql2);
  $row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC);

  //to verify if the query executed successful
  if ($stmt2 === false) {
    echo "primer if";
    echo $sql2;
    die(print_r( sqlsrv_errors(), true));
  }

  //redirect to the page adminPagehtml.php
  header("Location:adminPagehtml.php");

  //close the server connection
  sqlsrv_close($conn);
?>
