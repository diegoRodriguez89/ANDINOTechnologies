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
    
    //Verify if the connection with the server is successful
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

    /*
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

    while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
        echo "<h2>La Cantidad de Documentos es:  $row[num]<h2>";
}

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
            navbarEmployeeList($lang['language'],$lang['logout']);
        ?>


        <div class="container">
            <!-- This is the name in the header of the page -->
            <h1>
            <?php print "$lang[genStats]"; ?>
            </h1>
            
            <br></br>

            <form class="form-horizontal" role="form" id="generateStatistics" action="generarEstadisticas.php" method = "post">
                <div class="form-group" > 
                    <label for="documentType" class="col-sm-1 control-label"><?php echo $lang['genBy']; ?>:</label> 
                    <div class="col-sm-5" id="document_type">
                        <!-- This dropdown is to select the type of document for which the user wants the statistics -->
                        <select class="form-control" name="documentType" required>
                            <option> <?php echo $lang['docType']; ?></option>
                            <option value="Lawsuit"> <?php echo $lang['doc_lawsuit']; ?> </option>
                            <option value="Motion"> <?php echo $lang['doc_motion']; ?> </option>
                            <option value="Subpeona"> <?php echo $lang['doc_subpoena']; ?> </option>
                            <option value="Requirements"> <?php echo $lang['doc_requirements']; ?> </option>
                            <option value="Others"> <?php echo $lang['doc_others']; ?> </option>
                        </select>
                    </div>
                </div> 

                <div class="form-group" > 
                    <label for="documentSubcategory" class="col-sm-1 control-label"><?php echo $lang['genSubcategory']; ?>:</label> 
                    <div class="col-sm-5">
                        <!-- This input text box is to write the document subcategory or type of service for which the the user want the statistics -->
                        <input type="text" class="form-control" name = "documentSubcategory" id="documentSubcategory" placeholder="<?php echo $lang['genSubcategory']; ?>" onkeyup="valid(this)" onblur="valid(this)"> 
                    </div> 
                </div>

                <div class="form-group" > 
                    <label for="documentAmount" class="col-sm-1 control-label"><?php echo $lang['genQuantity']; ?>:</label> 
                    <div class="col-sm-5">
                        <!-- This input text box is to write the amount of the contracts that the user wants the statistics -->
                        <input type="text" class="form-control" name = "documentAmount" id="documentAmount" placeholder="<?php echo $lang['genQuantity']; ?>" onkeyup="valid(this)" onblur="valid(this)"> 
                    </div> 
                </div> 
                
                <div class="form-group" > 
                    <label for="initialDate" class="col-sm-1 control-label"><?php echo $lang['sDate']; ?>:</label> 
                    <p></p>
                    <div class="col-sm-5">
                        <!-- This input text box is to select the starting date that the user wants the statistics -->
                        <input type="Date" class="form-control" name = "initialDate" id="initialDate" required> 
                    </div> 
                </div> 
                
                <div class="form-group" > 
                    <label for="endDate" class="col-sm-1 control-label"><?php echo $lang['eDate']; ?>:</label>
                    <p></p>
                    <div class="col-sm-5">
                        <!-- This input text box is to select the deadline date that the user wants the statistics --> 
                        <input type="Date" class="form-control" name = "endDate" id="endDate" required> 
                    </div> 
                </div>
            </form>
            
            <p></p>
            
            <div class="row">
                <!-- This button is for canceling everything and returning to the lawyer page -->
                <a class="btn btn-primary pull-right" href="caseSearch.php"><?php echo $lang['eCancel']; ?></a>
                <!-- This button is for generating the statistics -->
                <button class="btn btn-primary pull-right" style="margin-right: 4px" type = "submit" form ="generateStatistics"><?php echo $lang['generate']; ?></button>
            </div>
        </div>

        <script src="js/jquery-1.11.2.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        
    </body>
</html>
