<?php
    session_start();

    //Includes the libraries to change the language of the page (english/spanish) and the navigational bar
    include_once 'common.php';
    include 'library.php';

    /* Server
    $serverName = the name of the server to connect
    $connectionInfo = creates an array with the database name, the user id of the database and the user's password of the database
    $conn = sqlsrv_connect() = is the function to connect with the server
    */
	$serverName = "127.0.0.1";
	$connectionInfo = array("Database"=>"PoliceTest", "UID"=>"sa", "PWD"=>"A06a30adr5d");
	$conn = sqlsrv_connect($serverName, $connectionInfo);
    
    if(!$conn) {
        die( print_r( sqlsrv_errors(), true));
    }

    /* Variables
    $documentType - the document type
    $documentSubcategory - the document subcategory
    $documentAmount - amount or financial quantity
    $initialDate - initial date (from when)
    $endDate - end date (until when)
    */
    $documentType = $_POST['documentType'];
    $documentSubcategory = $_POST['documentSubcategory'];
    $documentAmount = $_POST['documentAmount'];
    $initialDate = $_POST['initialDate'];
    $endDate = $_POST['endDate'];   

    //The function mysql_real_escape_string will clear the special characters from the variable.
    $documentType = mysql_real_escape_string($documentType);
    $initialDate = mysql_real_escape_string($initialDate);
    $endDate = mysql_real_escape_string($endDate);


    /*SQL
    $sql - query to fetch the quantity of such document in the database.
    $stmt = sqlsrv_query() = prepares and executes the query
    $row = sqlsrv_fetch_array() = returns the row as an array
    */
    $sql = "SELECT COUNT(DocNumber) AS num FROM Documents WHERE DocType = '$documentType' AND EntryDate  >= '$initialDate' AND EntryDate <= '$endDate'";

    $stmt = sqlsrv_query($conn, $sql);
        if ($stmt === false) {
            echo $sql;
            die(print_r( sqlsrv_errors(), true));
    }

    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    $cantidad = $row['num'];

    //while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
       // echo "<h2>La Cantidad de Documentos es:  $row[num]<h2>";
    //}

    sqlsrv_close($conn);

?>

<!DOCTYPE html>
<html>
    <head>
        <!-- This is the name of the page -->
        <title> Generar Estadísticas Abogado</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/ANDINOstyleSheet.css">


    </head>

    <!-- This is to only permit the characters that we allow to input to the system -->
    <script type="text/JavaScript">
        function valid(f) {
        !(/^[A-z;0-9; ;.;-]*$/i).test(f.value)?f.value = f.value.replace(/[^A-z;0-9; ;.;-]/ig,''):null;
        } 
    </script>
    
    <body>

        <?php 
        /*
        This function displays the information in the navigation bar. It includes the system's header, the
        language selection dropdown and logout buttons.
        */
            navbarLogout($lang['logout']);
        ?>


        <div class="container">
            <!-- This is the name in the header of the page -->
            <h1>
            <?php print "$lang[stats]"; ?>
            </h1>
            
            <br></br>

            <?php
                echo "<h2>$lang[documentAmount] : $cantidad</h2>";
            ?>

            <br></br>

            
                <table>
                    <thead>
                            <tr>
                                <th class="col-md-3"> <?php echo $lang['case_num']; ?></th>
                                <th class="col-md-4"><?php echo $lang['docType']; ?> </th>
                                <th class="col-md-3"><?php echo $lang['date_received']; ?></th>
                            </tr>
                    </thead>
                </table>
           

            <!-- This is the table to present all the cases that are closer to the deadline -->
            <form method="post">
                   
                    <table>
                    <tbody>
                        <?php
                                session_start();

                            $serverName = "127.0.0.1";
                            $connectionInfo = array("Database"=>"PoliceTest", "UID"=>"sa", "PWD"=>"A06a30adr5d");
                            $conn = sqlsrv_connect($serverName, $connectionInfo);

                            $d=strtotime("+5 days");
                            $limite =  date("Y M j", $d);
                            $datetime2 = new DateTime("+5 days");

                            $sql = "SELECT DocNumber, DocType, CONVERT(VARCHAR(11),EntryDate,106) AS fecha, DocStatus FROM Documents WHERE DocType = '$documentType' AND EntryDate  >= '$initialDate' AND EntryDate <= '$endDate' ";
                              $stmt = sqlsrv_query($conn, $sql);

                              while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                  $datetime3 = new DateTime($row['fecha']);
                                    $interval2 = $datetime2->diff($datetime3);

                                  echo "<td class='col-md-3'>" . $row['DocNumber'] . "</td>";
                                  echo "<td class='col-md-4'>" . $row['DocType'] . "</td>";
                                    
                                  if(is_null($row['fecha'])){
                                    echo "<td class='col-md-3'> None </td>";
                                  } else { 
                                    echo "<td class='col-md-3'>" . $row['fecha'] . "</td>";
                                  }
                                  
                                  echo "</tr>";
                              }
                              sqlsrv_close($conn);
                        ?>
                    </tbody>
                    </table>
                </form>
                

            <p></p>
            
            <div class="footer">
            <div class="row">
                <!-- This button is for canceling everithing and returning to the lawyer page -->
                <a class="btn btn-primary pull-right" href="caseSearch.php"><?php echo $lang['eCancel']; ?></a>
                <!-- This button is for printing a the case -->
                <a class="btn btn-primary pull-right" style="margin-right: 4px" href="javascript:window.print()"> <?php echo $lang['doc_print']; ?> </a>
            </div>
        </div>
        </div>

        <script src="js/jquery-1.11.2.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        
    </body>
</html>
