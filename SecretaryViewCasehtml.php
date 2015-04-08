<?php

	//Includes the libraries to change the language of the page (english/spanish) and the navigational bar
	include_once 'common.php';
	include 'library.php';

	//If the logged in user is not a secretary the user will not be able to continue
	if($_SESSION[job] <> 'secretary'){
		die("You are not allow in this page. :P");
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<!-- This is the name of the page -->
		<title> Ver Caso Secretaria </title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="css/ANDINOstyleSheet.css">
	</head>

	<!-- This is to only permit the characters that we allow to input to the system -->
	<script type="text/JavaScript">
		function valid(f) {
		!(/^[A-z;0-9; ;.;,;#;&;-]*$/i).test(f.value)?f.value = f.value.replace(/[^A-z0-9; ;.;,;#;&;-]/ig,''):null;
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
			<?php print "$lang[case]"; ?>
			</h1>
			
			<br></br>
			<form id="form_secretaryViewCaseUpdate" action="secretaryViewCaseUpdate.php" method="post">
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

	  			/*
				$sql - query to fetch the information of a document in the database.
	    		$stmt = sqlsrv_query() = prepares and executes the query
	    		$row = sqlsrv_fetch_array() = returns the row as an array
	  			*/
			    $sql = "SELECT DocNumber, CONVERT(VARCHAR(11),EntryDate,21) AS fechaEntrada, CONVERT(VARCHAR(11),CommunicationDate,21) AS fechaComu, CONVERT(VARCHAR(11),Deadline,21) AS fechaLimite, Precedence, DocDescription, Appellant, Sender, DocType, DocSubcategory, Copy FROM Documents WHERE DocNumber = $_SESSION[docID]";
					$stmt = sqlsrv_query($conn, $sql);
					if ($stmt === false) {
				    die(print_r( sqlsrv_errors(), true));
				  }
					while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
						$id = $row['DocNumber'];
						$eDate = $row['fechaEntrada'];
						$cDate = $row['fechaComu'];
						$deadline = $row['fechaLimite'];
						$Precedence = $row['Precedence'];
						$description = $row['DocDescription'];
						$appellant = $row['Appellant'];
						//$destinatario = $row['Destinatario'];
						$titulo = $row['DocType'];
						$subcategory = $row['DocSubcategory'];
						$sender = $row['Sender'];
						$copia = $row['Copy'];
					}

				?>
			
				<div class="row">
				<!-- This input is to select the document date -->
				<label class="col-md-2"> <?php echo $lang['date_issued']; ?> <input type="date" class="form-control" name="fechaComu" id="fechaComu" value=<?php echo $cDate ?>></label>
				<!-- This input is to select the date that the document was received -->
				<label class="col-md-2 col-md-offset-1"><?php echo $lang['date_received']; ?><input type="date" class="form-control" name=" fechaEntrada" id="fechaEntrada" value=<?php echo $eDate ?>></label>
				<!-- This input is to select the document deadline date -->
				<label class="col-md-2 col-md-offset-1"><?php echo $lang['date_due']; ?><input type="date" class="form-control" name="fechaLimite" id="fechaLimite" value=<?php echo $deadline ?>></label>
	
			</div>
			<p></p>
			<div class="row">
				<!-- This input box is to insert the case number -->
				<div class="col-md-2">
					<input type="text" class="form-control" placeholder="<?php echo $lang['case_num']; ?>" onkeyup="valid(this)" onblur="valid(this)" value='<?php echo $id ?>'>
				</div>
				<!-- This input box is to insert the name of the appellant -->
				<div class="col-md-5 col-md-offset-1">
					<input type="text" class="form-control" placeholder="<?php echo $lang['case_apellant']; ?>" onkeyup="valid(this)" onblur="valid(this)" name="Appellant" id="Appellant" value='<?php echo $appellant ?>'>
				</div>
			</div>
			
			<p></p>
			<div class="row">
				<div class="col-md-3">
					<!-- This dropdown is to select the type of document -->
					<select class="form-control" name="DocType" id="DocType">
						<?php echo "<option>" . $titulo . "</option>"; ?>
						<option> <?php echo $lang['doc_lawsuit']; ?>  </option>
						<option> <?php echo $lang['doc_motion']; ?> </option>
						<option> <?php echo $lang['doc_subpoena']; ?> </option>
						<option> <?php echo $lang['doc_requirements']; ?> </option>
						<option> <?php echo $lang['doc_others']; ?> </option>
					</select>
				</div>
				<!-- This input box is for inserting the subcategory of the document -->
				<div class="col-md-5"><input type="text" class="form-control" placeholder="<?php echo $lang['genSubcategory']; ?>" onkeyup="valid(this)" onblur="valid(this)" name="DocSubcategory" id="DocSubcategory" value='<?php echo $subcategory ?>'></div>


			</div>

			<p></p>
			<?php
			  session_start();
			  $serverName = "127.0.0.1";
	  		$connectionInfo = array("Database"=>"PoliceTest", "UID"=>"sa", "PWD"=>"A06a30adr5d");
	  			
	  		$conn = sqlsrv_connect($serverName, $connectionInfo);

	  			/*
				$sql - query to fetch the information of the employee managing the document from the database.
	    		$stmt = sqlsrv_query() = prepares and executes the query
	    		$row = sqlsrv_fetch_array() = returns the row as an array
	  			*/
			  $sql = "SELECT Name, MiddleName, LastName, MaidenName, Office FROM Employee, Manage WHERE Username = EmployeeName and DocId = $_SESSION[docID]";
				$stmt = sqlsrv_query($conn, $sql);
				if ($stmt === false) {
				  die(print_r( sqlsrv_errors(), true));
				}
				$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

				/* Variables
				$nombre  - employee name
				$inicial - employee initial 
				$apellido - employee last name
				$segundo - employee maiden name
				$oficina - office			
				*/
				$nombre = $row['Name'];
				$inicial = $row['MiddleName'];
				$apellido = $row['LastName'];
				$segundo = $row['MaidenName'];
				$oficina = $row['Office'];
			?>
			<div class="row">
				<!-- This input box is to insert name of the addressee -->
				<div class="col-md-3 ">
					<input type="text" class="form-control" placeholder="<?php echo $lang['case_receiver']; ?>" onkeyup="valid(this)" onblur="valid(this)" name="Sender" id="Sender" value='<?php echo $nombre . " " . $inicial . " " . $apellido . " " . $segundo ?>'>
				</div>
				<!-- This input box is to insert name of the addressee region -->
				<div class="col-md-4 ">
					<input type="text" class="form-control" placeholder="<?php echo $lang['case_region']; ?>" onkeyup="valid(this)" onblur="valid(this)"  value='<?php echo $oficina ?>'>
				</div>
				
			</div>
			<p></p>
			<div class="row">
				<!-- This input box is to insert name of the lawyer that sends the document -->
				<div class="col-md-3"><input type="text" class="form-control" placeholder="<?php echo $lang['case_sender']; ?>" onkeyup="valid(this)" onblur="valid(this)" value='<?php echo $sender ?>'></div>
				<div class="col-md-4">
					<!-- This dropdown is to select the name of the senders office -->
					<select class="form-control" name="Precedence" id="Precedence">
						<?php echo "<option>" . $Precedence . "</option>" ?>
						<option> Comisión Apelativa del Servicio Publico(CASP) </option>
						<option> Comisión de Investigacion, Procesamientos y Apelaciones(CIPA) </option>
						<option> Tribunal de Primera Instancia(TPI) </option>
						<option> Tribunal de Apelaciones(TA) </option>
						<option> Equal Employement Opportunity Comission(EEOC) </option>
						<option> Otros Asuntos </option>
						<option> Requerimientos </option>
					</select>
				</div>				
			</div>
				
			<p></p>
			<!-- This input box is to write some issue of the contract -->
			<textarea class="form-control .input-lg" rows="5" name="DocDescription" id="DocDescription" onkeyup="valid(this)" onblur="valid(this)" placeholder="<?php echo $lang['case_subject']; ?>"><?php echo $description ?></textarea>
			
			<p></p>
			<?php
			  session_start();
			  	$serverName = "127.0.0.1";
	  			$connectionInfo = array("Database"=>"PoliceTest", "UID"=>"sa", "PWD"=>"A06a30adr5d");
	  			$conn = sqlsrv_connect($serverName, $connectionInfo);
			  	
	  			/*
				$sql - query to fetch the comments made to the document from the database.
	    		$stmt = sqlsrv_query() = prepares and executes the query
	    		$row = sqlsrv_fetch_array() = returns the row as an array
	  			*/
			  	$sql = "SELECT Notes FROM Comments WHERE DocId = $_SESSION[docID]";
				$stmt = sqlsrv_query($conn, $sql);
				if ($stmt === false) {
				  die(print_r( sqlsrv_errors(), true));
				}
				while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
					//$comments = $row['Notes'];
					echo "<textarea class='form-control' .input-lg row='5' onkeyup='valid(this)' onblur='valid(this)' placeholder='$lang[case_comment]'>" . $row['Notes'] . "</textarea>";
				}

			?>
			<p></p>
			<!-- This input box is to write some comments of the contract -->
			<textarea class="form-control .input-lg" rows="5" onkeyup="valid(this)" onblur="valid(this)" placeholder="<?php echo $lang['case_comment']; ?>" name="caseCommentEdit" id="caseCommentEdit"></textarea>
		
			<p></p>
			
			<div class="footer">
			<div class="row">
				<!-- This button is for canceling everithing and returns to the secretary page -->
				<a class="btn btn-primary pull-right" href="secretaryPagehtml.php"><?php echo $lang['eCancel']; ?></a>
				<!-- This button is for adding a case to the system after editing and returns to the secretary page -->
				<button class="btn btn-primary pull-right" type="submit" style="margin-right: 4px" form="form_secretaryViewCaseUpdate"><?php echo $lang['enter']; ?></button>
				<!-- This button is for printing a case -->
				<a class="btn btn-primary pull-right" style="margin-right: 4px" href="javascript:window.print()"> <?php echo $lang['doc_print']; ?> </a>
				<!-- This button is for see the document of the case -->
				<?php

			if($copia <> ""){
				echo "<a class='btn btn-primary pull-right' style='margin-right: 4px' href='$copia' target='_blank'>$lang[doc_view]</a>";
			}
			 else{
			 	echo "<a class='btn btn-primary pull-right' style='margin-right: 4px' href='$copia' target='_blank' disabled>$lang[doc_view]</a>";
			 }
			?>
			</div>
			</div>

		</div>

	</form>
		
		<script src="js/jquery-1.11.2.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	
	</body>
</html>
