<?php
    session_start();

	$serverName = "127.0.0.1";
	$connectionInfo = array("Database"=>"PoliceTest", "UID"=>"sa", "PWD"=>"A06a30adr5d");

	$conn = sqlsrv_connect($serverName, $connectionInfo);
    
    if(!$conn) {
        die( print_r( sqlsrv_errors(), true));
    }


    $documentType = $_POST['documentType'];
    $documentSubcategory = $_POST['documentSubcategory'];
    $documentAmount = $_POST['documentAmount'];
    $initialDate = $_POST['initialDate'];
    $endDate = $_POST['endDate'];   

    if($documentType == 'Lawsuit'){
           $id = 'LawsuitID';  
    }
        else {
            $id = 'otherId';
        }

    $sql = "SELECT COUNT(DocNumber) AS num FROM Documents, $documentType WHERE DocNumber = LawsuitID AND Amount >= '100' AND EntryDate  >= '$initialDate' AND EntryDate <= '$endDate'";

    $stmt = sqlsrv_query($conn, $sql);
        if ($stmt === false) {
            die(print_r( sqlsrv_errors(), true));
    }

    while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
     echo $row['num'];
}

    sqlsrv_close($conn);

?>
