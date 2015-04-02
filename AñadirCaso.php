<?php
    session_start();

	$serverName = "127.0.0.1";
	$connectionInfo = array("Database"=>"PoliceTest", "UID"=>"sa", "PWD"=>"A06a30adr5d");

	$conn = sqlsrv_connect($serverName, $connectionInfo);
    
    if(!$conn) {
        die(print_r( sqlsrv_errors(), true));
    }

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
    $caseReferred = $_POST['caseReferred'];
    $caseCoy = $_POST['caseCoy'];
    $Ok = 'si';
    //$secreatryName = $_SESSION[username];

    $sql = "INSERT INTO Documents VALUES('$caseNumber','$dateReceived', '$dateDocument', '$dateDue', '$caseAppellant', '$caseSender', '$department', '$documentType', '$documentSubcategory', '$caseSubject', '$caseCoy', 'No')";

    $stmt = sqlsrv_query($conn, $sql);
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    if ($stmt === false) {
        echo "primer if";
        //echo $sql;
        die(print_r( sqlsrv_errors(), true));
    }

//    if ($Ok <> 'no') {
      $sql3 = "INSERT INTO AddDoc VALUES('$caseNumber', '$_SESSION[username]')";
      $stmt3 = sqlsrv_query($conn, $sql3);
      $row3 = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
      if ($stmt3 === false) {
          echo "tercer if";
          echo $sql3;
          die(print_r( sqlsrv_errors(), true));
      }
//    }

//    if ($Ok <> 'no') {
      $sql5 = "INSERT INTO Manage VALUES('$caseNumber', '$caseReceiver')";
      $stmt5 = sqlsrv_query($conn, $sql5);
      $row5 = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
      if ($stmt5 === false) {
          echo "quinto if";
          echo $sql5;
          die(print_r( sqlsrv_errors(), true));
      }
//    }

    if($documentType == 'Lawsuit'){
        $sql2 = "INSERT INTO Lawsuit VALUES ('$caseNumber', 1000)";
        $stmt2 = sqlsrv_query($conn, $sql2);
        $row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC);
        if ($stmt2 === false) {
            echo "seugndo if";
            die(print_r( sqlsrv_errors(), true));
        }
    }

    if ($caseComment <> "") {
        $sql4 = "INSERT INTO Comments VALUES('$_SESSION[username]', '$caseNumber', GETDATE(), '$caseComment')";
        $stmt4 = sqlsrv_query($conn, $sql4);
        $row4 = sqlsrv_fetch_array($stmt4, SQLSRV_FETCH_ASSOC);
        if ($stmt4 === false) {
            echo "cuarto if";
            die(print_r( sqlsrv_errors(), true));
        }
    }

    header("Location:secretaryPage.php");

    sqlsrv_close($conn);

?>
