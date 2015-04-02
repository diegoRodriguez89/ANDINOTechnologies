<?php
	session_start();

	$serverName = "127.0.0.1";
	$connectionInfo = array("Database"=>"PoliceTest", "UID"=>"sa", "PWD"=>"A06a30adr5d");

	$conn = sqlsrv_connect($serverName, $connectionInfo);                        
	if( !$conn ) {
  die( print_r( sqlsrv_errors(), true));
}

	if(!empty($_POST['view']) and is_array($_POST['view'])) {
  	list($Diego) = $_POST['view'];
  	//list($val1, $val2) = explode(",", $Diego);
  	$_SESSION['docID'] = $Diego;
  	//$_SESSION['EDes'] = $val2;
  	$job = "$_SESSION[job]";
  	if ($job == "secretary") {
		header("Location:secretaryViewCasehtml.php");
  }
  elseif ($job == "attorney") {
  	header("Location:attorneyViewCasehtml.php");
	}
	elseif ($job == "admin") {
		header("Location:adminViewCasehtml.php");
  }
  	
}

	include_once 'common.php';
	include 'library.php';

?>

<!DOCTYPE html>
<html>
	<head>
		<!-- This is the name of the page -->
		<title> Búsqueda de Casos</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="css/ANDINOstyleSheet.css">
	</head>

	<!-- This is to only permit the characters that we allow to input to the system -->
	<script type="text/JavaScript">
		function valid(f) {
		!(/^[A-z;0-9; ;.]*$/i).test(f.value)?f.value = f.value.replace(/[^A-z;0-9; ;.]/ig,''):null;
		} 
	</script>
	
	<body>
		<!-- Static navbar -->
		<?php 
			navbarEmployeeList($lang['language'],$lang['logout']);
		?>
		
		<div class="container">
			<!-- This is the name in the header of the page -->
			<h1>
			<?php print "$lang[searchCaseHeader]"; ?>
			</h1>
			
			<br></br>

			<form class="form-horizontal" role="form" method = "post">

				<div class="row">

					<div class="col-md-2">
						<input type="text" class="form-control" placeholder="<?php echo $lang['case_num']; ?>" onkeyup="valid(this)" onblur="valid(this)" id="caseNumber" name="caseNumber">
					</div>
 					
 					<div class="col-md-3">
 						<input type="text" class="form-control" placeholder="<?php echo $lang['eFirstName']; ?>" onkeyup="valid(this)" onblur="valid(this)" id="nameSearch" name="nameSearch">
 					</div>

					<div class="col-sm-3" id="documentType">
						<!-- This dropdown is to select the type of document the user is searching for -->
						<select class="form-control" name="documentType">
							<option value=""> <?php echo $lang['docType']; ?> </option>
							<option value="Demanda"> <?php echo $lang['doc_lawsuit']; ?> </option>
							<option value="Motion"> <?php echo $lang['doc_motion']; ?>  </option>
							<option value="Subpoena"> <?php echo $lang['doc_subpoena']; ?> </option>
							<option value="Requerimiento"> <?php echo $lang['doc_requirements']; ?> </option>
							<option value="Others"> <?php echo $lang['doc_others']; ?>  </option>
						</select>
					</div>

					<!-- This input is to select the document date -->
					<label class="col-md-2"><input type="date" class="form-control" id="documentDate" name="documentDate"></label>

					<!-- This button is for canceling everithing and returning to the lawyer page -->
					<a class="btn btn-primary pull-right" name="cancel" value=<?php echo $_SESSION[job] ?> href="caseSearch.php"><?php echo $lang['eCancel']; ?></a>
					<!-- This button is for generating the statistics -->
					<button class="btn btn-primary pull-right" style="margin-right: 4px" type="submit" name="search"><?php echo $lang['searchButton']; ?></button>

				</div>
			</form>
			<p></p>

			<br></br>
			<!-- This is the table to present all the cases searched for -->
			<form method="post">
			<table>
    		<thead>
       		<tr>
           	<th><?php echo $lang['case_num']; ?></th>
           	<th><?php echo $lang['apellant_name']; ?></th>
           	<th><?php echo $lang['docType']; ?></th>
           	<th><?php echo $lang['search_date']; ?> </th>
           	<th><?php echo $lang['status']; ?></th>
           	<th></th>
          </tr> 
      </thead>
      <tbody>
      	<?php
      		$caseNumber = $_POST['caseNumber'];
      		$nameSearch = $_POST['nameSearch'];
      		$documentType = $_POST['documentType'];
      		$documentDate = $_POST['documentDate'];
      		
      		session_start();
      		$serverName = "127.0.0.1";
      		$connectionInfo = array("Database"=>"PoliceTest", "UID"=>"sa", "PWD"=>"A06a30adr5d");
      		$conn = sqlsrv_connect($serverName, $connectionInfo);

      		if($caseNumber > 0){
      			$sql = "SELECT DocNumber, Appellant, DocType, CONVERT(VARCHAR(11),CommunicationDate,106) AS Fecha, DocStatus FROM Documents WHERE DocNumber = '$caseNumber'";
      		} 
      		elseif ($nameSearch <> '') {
      			$sql = "SELECT DocNumber, Appellant, DocType, CONVERT(VARCHAR(11),CommunicationDate,106) AS Fecha, DocStatus FROM Documents WHERE Appellant = '$nameSearch'";
      		} 
      		elseif ($documentType <> '') {
      			$sql = "SELECT DocNumber, Appellant, DocType, CONVERT(VARCHAR(11),CommunicationDate,106) AS Fecha, DocStatus FROM Documents WHERE DocType = '$documentType'";
      		}	
      		elseif ($documentDate <> '') {
      				$sql = "SELECT DocNumber, Appellant, DocType, CONVERT(VARCHAR(11),CommunicationDate,106) AS Fecha, DocStatus FROM Documents WHERE CommunicationDate = '$documentDate'";
      		}
      		
		    	$stmt = sqlsrv_query($conn, $sql);
		    	if ($stmt === false) {
				    die(print_r( sqlsrv_errors(), true));
				  }

					while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
				  	echo "<tr>";
				  	echo "<td>" . $row['DocNumber'] . "</td>";
				  	echo "<td>" . $row['Appellant'] . "</td>";
				  	echo "<td>" . $row['DocType'] . "</td>";
						if(is_null($row['Fecha'])){
					  		echo "<td> None </td>";
					  	} 
					  	else { 
					  		echo "<td>" . $row['Fecha'] . "</td>";
					  	}
				  	echo "<td>" . $row['DocStatus'] . "</td>";
				  	echo "<td><p><p><button class='btn btn-primary' type='submit' name='view[]' value='".$row['DocNumber']."'>View</button></p></p>";
					echo "</tr>";
				}
			sqlsrv_close($conn);
      	?>

    		</tbody>
			</table>
			</form>	
		</div>

		<script src="js/jquery-1.11.2.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	
	</body>
</html>
