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

    //Verify if the connection with the server is successful
    if(!$conn) {
        die(print_r( sqlsrv_errors(), true));
    }

    /* Variables
    $documentoEstado - status of the document (processed or non processed)
    $comentario - comments made about the document
    */
    $documentoEstado = $_POST['Estado'];
    $comentario = $_POST['attorneyComment'];

  //The function mysql_real_escape_string will clear the special characters from the variable.
    if(!is_null($documentoEstado)){
      $documentoEstado = mysql_real_escape_string($documentoEstado); 
      
      /* SQL
      $sql = query that modifies the information of the document in the database with the variables above
      $stmt = sqlsrv_query() = prepares and executes the query
      $row = sqlsrv_fetch_array() = returns the row as an array
      */      
      $sql = "UPDATE Documents SET DocStatus = '$documentoEstado' WHERE DocNumber ='$_SESSION[docID]'";
      $stmt = sqlsrv_query($conn, $sql);
      $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

       if ($stmt === false) {
        echo "primer if";
        echo $sql;
        die(print_r( sqlsrv_errors(), true));
       }
    }

    if ($comentario <> "") {
        $comentario = mysql_real_escape_string($comentario);
        $sql2 = "INSERT INTO Comments VALUES('$_SESSION[username]', '$_SESSION[docID]', GETDATE(), '$comentario')";
        $stmt2 = sqlsrv_query($conn, $sql2);
        $row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC);
        if ($stmt2 === false) {
            echo "cuarto if";
            die(print_r( sqlsrv_errors(), true));
        }
    }

    //Redirect to the page attorneyPagehtml.php
    header("Location:attorneyPagehtml.php");
    
    //Close the server connection
    sqlsrv_close($conn);

?>
