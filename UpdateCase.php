<?php
    session_start();

	$serverName = "127.0.0.1";
	$connectionInfo = array("Database"=>"PoliceTest", "UID"=>"sa", "PWD"=>"A06a30adr5d");

	$conn = sqlsrv_connect($serverName, $connectionInfo);
    
    if(!$conn) {
        die(print_r( sqlsrv_errors(), true));
    }
    $documentoEstado = $_POST['Estado'];
    $comentario = $_POST['attorneyComment'];

    if(!is_null($documentoEstado)){
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
        $sql2 = "INSERT INTO Comments VALUES('$_SESSION[username]', '$_SESSION[docID]', GETDATE(), '$comentario')";
        $stmt2 = sqlsrv_query($conn, $sql2);
        $row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC);
        if ($stmt2 === false) {
            echo "cuarto if";
            die(print_r( sqlsrv_errors(), true));
        }
    }


    header("Location:attorneyPagehtml.php");

    sqlsrv_close($conn);

?>
