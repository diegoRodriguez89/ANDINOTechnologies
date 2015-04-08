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
    $eDate = date the document was received
    $cDate = date the document was issued
    $deadline = document's deadline date
    $Precedence = precedence of the document
    $description = description of the document
    $appellant = name of the appellant
    $titulo = type of the document
    $subcategory = subcategory of the document's type
    $sender = from where the document comes
    $comentario = comments to the database
  */
    $eDate = $_POST['fechaEntrada'];
    $cDate = $_POST['fechaComu'];
    $deadline = $_POST['fechaLimite'];
    $Precedence = $_POST['Precedence'];
    $description = $_POST['DocDescription'];
    $appellant = $_POST['Appellant'];
    $titulo = $_POST['DocType'];
    $subcategory = $_POST['DocSubcategory'];
    $sender = $_POST['Sender'];
    $comentario = $_POST['caseCommentEdit'];


    //The function mysql_real_escape_string will clear the special characters from the variable.
    $eDate = mysql_real_escape_string($eDate);
    $cDate = mysql_real_escape_string($cDate);
    $deadline = mysql_real_escape_string($deadline);
    $appellant = mysql_real_escape_string($appellant);
    $sender = mysql_real_escape_string($sender);
    $Precedence = mysql_real_escape_string($Precedence);
    $titulo = mysql_real_escape_string($titulo);
    $subcategory = mysql_real_escape_string($subcategory);
    $description = mysql_real_escape_string($description);

    /* SQL
    $sql = query to update the information of the case in the database with the variables above
    $stmt = sqlsrv_query() = prepares and executes the query
    $row = sqlsrv_fetch_array() = returns the row as an array
     */
    $sql = "UPDATE Documents SET EntryDate = '$eDate', CommunicationDate = '$cDate', Deadline = '$deadline', Appellant = '$appellant' , Sender = '$sender', Precedence = '$Precedence', DocType = 
      '$titulo', DocSubcategory = '$subcategory', DocDescription = '$description'  WHERE DocNumber ='$_SESSION[docID]'";

      $stmt = sqlsrv_query($conn, $sql);
      $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

       if ($stmt === false) {
        echo "primer if";
        echo $sql;
        die(print_r( sqlsrv_errors(), true));
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

  //redirect to the page secretaryPagehtml.php
    header("Location:secretaryPagehtml.php");

  //close the server connection
    sqlsrv_close($conn);

?>
