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

  /* Variables
    $dateDocument = date of the document when it is made
    $dateReceived = date when the document is received in the office
    $dateDue = deadline of the document
    $caseNumber = number id of the document
    $caseAppellant = appellant of the case in the document
    $caseReceiver = the attorney of the office that will work with the case
    $caseRegion = office where the document will be process
    $caseSender = attorney who defend the appellant of the case
    $caseSubject = brief description of the case
    $caseComment = comments added by the secretary or the attorney of the office
    $documentType = type of document
    $department = department where the document comes
    $documentSubcategory = specific type of document
    $caseCopy = digital copy scanned of the document
  */
  $dateDocument = $_POST['dateDocument'];
  $dateReceived = $_POST['dateReceived'];
  $dateDue = $_POST['dateDue'];
  $caseNumber = $_POST['caseNumber'];
  $caseAppellant = $_POST['caseAppellant'];
  $caseReceiver = $_POST['caseReceiver'];
  $caseRegion = $_POST['caseRegion'];
  $caseSender = $_POST['caseSender'];
  $caseSubject = $_POST['caseSubject'];
  $caseComment = $_POST['caseComment'];
  $documentType = $_POST['documentType'];
  $department = $_POST['department'];
  $documentSubcategory = $_POST['documentSubcategory'];
  $caseCopy = $_POST['caseCopy'];
  $quantity = $_POST['quantity'];

  // The function mysql_real_escape_string will clear the special characters from the variable.
  $caseNumber = mysql_real_escape_string($caseNumber);
  $dateReceived = mysql_real_escape_string($dateReceived);
  $dateDocument = mysql_real_escape_string($dateDocument);
  $dateDue = mysql_real_escape_string($dateDue);
  $caseAppellant = mysql_real_escape_string($caseAppellant);
  $caseSender = mysql_real_escape_string($caseSender);
  $department = mysql_real_escape_string($department);
  $documentType = mysql_real_escape_string($documentType);
  $documentSubcategory = mysql_real_escape_string($documentSubcategory);
  $caseSubject = mysql_real_escape_string($caseSubject);
  $caseCopy = mysql_real_escape_string($caseCopy);
  $quantity = mysql_real_escape_string($quantity);

  //hard cody
  $tar_dir = "copies\\$caseCopy";

  /* SQL
    $sql = query to insert the information of the employee in the database with the variable above
    $stmt = sqlsrv_query() = prepares and executes the query
    $row = sqlsrv_fetch_array() = returns the row as an array
  */
  $sql = "INSERT INTO Documents VALUES('$caseNumber','$dateReceived', '$dateDocument', '$dateDue', '$caseAppellant', '$caseSender', '$department', '$documentType', '$documentSubcategory', '$caseSubject', '$tar_dir', 'No')";
  $stmt = sqlsrv_query($conn, $sql);
  $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

  //Verify if the query executed successfully
  if ($stmt === false) {
    echo "primer if";
    //echo $sql;
    die(print_r( sqlsrv_errors(), true));
  }

  /* SQL
    $sql3 = query to insert the information of the employee in the database with the variable above
    $stmt3 = sqlsrv_query() = prepares and executes the query
    $row3 = sqlsrv_fetch_array() = returns the row as an array
    The function mysql_real_escape_string will clear the special characters from the variable.
  */
  $caseNumber = mysql_real_escape_string($caseNumber);
  $sql3 = "INSERT INTO AddDoc VALUES('$caseNumber', '$_SESSION[username]')";
  $stmt3 = sqlsrv_query($conn, $sql3);
  $row3 = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
  
  //to verify if the query executed successful
  if ($stmt3 === false) {
    echo "tercer if";
    echo $sql3;
    die(print_r( sqlsrv_errors(), true));
  }

  /* SQL
    $sql5 = query to insert the information of the employee in the database with the variable above
    $stmt5 = sqlsrv_query() = prepares and executes the query
    $row5 = sqlsrv_fetch_array() = returns the row as an array
    The function mysql_real_escape_string will clear the special characters from the variable.
  */
  $caseNumber = mysql_real_escape_string($caseNumber);
  $caseReceiver = mysql_real_escape_string($caseReceiver);
  $sql5 = "INSERT INTO Manage VALUES('$caseNumber', '$caseReceiver')";
  $stmt5 = sqlsrv_query($conn, $sql5);
  $row5 = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

  //Verify if the query executed successfully
  if ($stmt5 === false) {
    echo "quinto if";
    echo $sql5;
    die(print_r( sqlsrv_errors(), true));
  }

  //if the document is a lawsuit execute the query inside the if
  if($documentType == 'Lawsuit'){
    /* SQL
      $sql2 = query to insert the information of the employee in the database with the variable above
      $stmt2 = sqlsrv_query() = prepares and executes the query
      $row2 = sqlsrv_fetch_array() = returns the row as an array
      The function mysql_real_escape_string will clear the special characters from the variable.
    */
    $caseNumber = mysql_real_escape_string($caseNumber);
    $sql2 = "INSERT INTO Lawsuit VALUES ('$caseNumber', '$quantity')";
    $stmt2 = sqlsrv_query($conn, $sql2);
    $row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC);

    //Verify if the query executed successfully
    if ($stmt2 === false) {
      echo "seugndo if";
      die(print_r( sqlsrv_errors(), true));
    }
  }

  //if there are some comment of the document execute the query inside the if
  if ($caseComment <> "") {
    /* SQL
      $sql4 = query to insert the information of the employee in the database with the variable above
      $stmt4 = sqlsrv_query() = prepares and executes the query
      $row4 = sqlsrv_fetch_array() = returns the row as an array
      The function mysql_real_escape_string will clear the special characters from the variable.
    */
    $caseNumber = mysql_real_escape_string($caseNumber);
    $caseComment = mysql_real_escape_string($caseComment);
    $sql4 = "INSERT INTO Comments VALUES('$_SESSION[username]', '$caseNumber', GETDATE(), '$caseComment')";
    $stmt4 = sqlsrv_query($conn, $sql4);
    $row4 = sqlsrv_fetch_array($stmt4, SQLSRV_FETCH_ASSOC);

    //to verify if the query executed successful
    if ($stmt4 === false) {
      echo "cuarto if";
      die(print_r( sqlsrv_errors(), true));
    }
  }

  //redirect to the page secretaryPagehtml.php
  header("Location:secretaryPage.php");

  //close the server connection
  sqlsrv_close($conn);
?>
