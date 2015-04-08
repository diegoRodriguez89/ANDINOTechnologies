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

	//Verify if the connection with the server is successful
	if( !$conn ) {
  		die(print_r( sqlsrv_errors(), true));
	}

	if($_SESSION[job] <> 'secretary'){
		die("You are not allow in this page. :P");
	}

	/*
		If the secreaty chooses the option to view a document
		$_POST['view'] contains the value of the document's number
		list($View) = keeps the value of the  document's number in the variable $View
		$_SESSION['docID'] keeps the value of the document's number to pass to the other page
		header = redirects to the page secretaryViewCasehtml.php
	*/
	if(!empty($_POST['view']) and is_array($_POST['view'])) {
  	list($Diego) = $_POST['view'];
  	//list($val1, $val2) = explode(",", $Diego);
  	$_SESSION['docID'] = $Diego;
  	//$_SESSION['EDes'] = $val2;
  	header("Location:secretaryViewCasehtml.php");
}

	//Includes the libraries to change the language of the page (english/spanish) and the navigational bar
	include_once 'common.php';
	include 'library.php';

?>
<!DOCTYPE html>
<html>
	<head>
		<!-- This is the name of the page -->
		<title> Perfil de la Secretaria </title>

		<meta charset="utf-8">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="css/ANDINOstyleSheet.css">
	</head>

	<!-- This is to only permit the characters that we allow to input to the system -->
	<script type="text/JavaScript">
		function valid(f) {
		!(/^[A-z;0-9; ;#;-]*$/i).test(f.value)?f.value = f.value.replace(/[^A-z0-9; ;#;-]/ig,''):null;
		} 
	</script>
	
	<body>

		<?php 
		/*
		This function displays the information in the navigation bar. It includes the system's header, the search button, the
		language selection dropdown and logout buttons.
		*/
			navbarAdmin($lang['searchButton'],$lang['language'],$lang['logout']);
		?>

		
		<div class="container">
			<!-- This is the name in the header of the page -->
			<h1>
			<?php print "$lang[s_profile]"; ?> 
			</h1>
			
			<p></p>
			<!-- This text box will show the name of the lawyer -->
			<h3>
				<?php session_start();
				echo $_SESSION[name] . " " . $_SESSION[initial] . " " . $_SESSION[last] . " " . $_SESSION[maiden]; ?>
			</h3>

			<!-- This button is for adding a new case and will send the user to that page-->
			<a class="btn btn-primary" href="anadirCasohtml.php"><?php echo $lang['add_case']; ?> </a>
			<!-- This button is for adding a new contract and will send the user to that page-->
			<a class="btn btn-primary col-md-offset-1" href="contratohtml.php"><?php echo $lang['addContract']; ?> </a>

			<br></br>
			
			<div style='width:1123px;'>
			<!-- A table is created with the header values of the case number, document type, deadline date and status of the document-->
			<table>
	    		<thead>
		       		<tr>
		           	<th class="col-md-2"><?php echo $lang['case_num']; ?></th>
		           	<th class="col-md-3"><?php echo $lang['docType']; ?>  </th>
		           	<th class="col-md-3"><?php echo $lang['dDate']; ?></th>
		          	<th class="col-md-2"><?php echo $lang['status']; ?></th>
		          	<th class="col-md-3"></th>
		          	</tr> 
	      		</thead>
      		</table>
      		</div>	

			<!-- This is the table to present all the cases that are closer to the deadline -->
			<form method="post">
			<div id="table-scroll">
			<div style='width:1123px;'>
			<table>
    		  <tbody>
		      	<?php
		      		session_start();
		      		$serverName = "127.0.0.1";
		      			$connectionInfo = array("Database"=>"PoliceTest", "UID"=>"sa", "PWD"=>"A06a30adr5d");

		      			$conn = sqlsrv_connect($serverName, $connectionInfo);
		      			$datetime2 = new DateTime("+5 days");

		      		$sql = "SELECT DocNumber, DocType, CONVERT(VARCHAR(11),Deadline,106) AS fecha, DocStatus FROM Documents
		      						WHERE DocStatus <> 'Procesado'
		      						AND DocNumber IN (SELECT DocId FROM AddDoc WHERE EmployeeName = '$_SESSION[username]')";
							$stmt = sqlsrv_query($conn, $sql);
							if ($stmt === false) {
		   						die(print_r( sqlsrv_errors(), true));
		  						}
							while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

								$datetime3 = new DateTime($row['fecha']);
								$interval2 = $datetime2->diff($datetime3);
								//die($row['fecha'] . " " . $limite);
								if(is_null($row['fecha']) || $interval2->format('%R%a days') > 0 || $row['DocStatus'] == 'Procesado') {
								  	echo "<tr>";
								 } else{
								  	echo "<tr class='invalid'>";
								 }
						  	echo "<td class='col-md-2'>" . $row['DocNumber'] . "</td>";
							  echo "<td class='col-md-3'>" . $row['DocType'] . "</td>";
							  if(is_null($row['fecha'])){
							  		echo "<td class='col-md-3'> None </td>";
							  	} 
							  	else { 
							  		echo "<td class='col-md-3'>" . $row['fecha'] . "</td>";
							  	}
						  	echo "<td class='col-md-2'>" . $row['DocStatus'] . "</td>";
						  	echo "<td class='col-md-3'><p><p><button class='btn btn-primary' type='submit' name='view[]' value='".$row['DocNumber']."'> $lang[viewCase]</button></p></p>";
								echo "</tr>";
							}
					sqlsrv_close($conn);
		      	?>
		    		</tbody>
			</table>
		</div>
		</div>
		</form>
		</div>

		<script src="js/jquery-1.11.2.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		
		<script type="text/JavaScript">
		$(function() {
        var on = false;
        window.setInterval(function() {
            on = !on;
            if (on) {
                $('.invalid').addClass('invalid-blink')
            } else {
                $('.invalid-blink').removeClass('invalid-blink')
            }
        }, 800);
    });
	</script>
	
	</body>
</html>
