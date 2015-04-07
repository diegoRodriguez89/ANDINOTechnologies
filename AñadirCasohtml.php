<?php
	//This is to use the $_SESSION variables. This variables are to pass the values from page to page.
  session_start();
  //to includes the library to change the language of the page
	include_once 'common.php';
	include 'library.php';
?>

<!DOCTYPE html>
<html>
	<head>
		<!-- This is the name of the page -->
		<title> Añadir Caso </title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="css/ANDINOstyleSheet.css">
		<!-- This is to only permit the characters that we allow to input to the system -->
		<script type="text/JavaScript">
			function valid(f) {
			!(/^[A-z;0-9; ;.;,;#;&;-]*$/i).test(f.value)?f.value = f.value.replace(/[^A-z;0-9; ;.;,;#;&;-]/ig,''):null;
			} 
		</script>
	</head>

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
			<h1><?php print "$lang[add_case]"; ?></h1>

			<br></br>
			<form id="form_anadirCaso" action="anadirCaso.php" method="post">
				<div class="row">
					<!-- This input is to select the document date -->
					<label class="col-md-2"> <?php echo $lang['date_issued']; ?> <input type="date" class="form-control" id="dateDocument" name="dateDocument"></label>
					<!-- This input is to select the date that the document was received -->
					<label class="col-md-2 col-md-offset-1"><?php echo $lang['date_received']; ?> <input type="date" class="form-control" id="dateReceived" name="dateReceived" required></label>
					<!-- This input is to select the document deadline date -->
					<label class="col-md-2 col-md-offset-1"><?php echo $lang['date_due']; ?> <input type="date" class="form-control" id="dateDue" name="dateDue"></label>
				</div>

				<p></p>
				<div class="row">
					<!-- This input box is to insert the case number -->
					<div class="col-md-2">
						<input type="text" class="form-control" placeholder="<?php echo $lang['case_num']; ?>" onkeyup="valid(this)" onblur="valid(this)" id="caseNumber" name="caseNumber" required>
					</div>
					<!-- This input box is to insert the name of the appellant -->
					<div class="col-md-5 col-md-offset-1">
						<input type="text" class="form-control" placeholder="<?php echo $lang['case_apellant']; ?>" onkeyup="valid(this)" onblur="valid(this)" id="caseAppellant" name="caseAppellant" required>
					</div>
				</div>

				<p></p>
				<div class="row">
					<div class="col-md-3"> 
						<!-- This dropdown is to select the type of document -->
						<select class="form-control" id="documentType" name="documentType" required>
							<option value=""> <?php echo $lang['docType']; ?> </option>
							<option value="Lawsuit"> <?php echo $lang['doc_lawsuit']; ?>  </option>
							<option value="Motion"> <?php echo $lang['doc_motion']; ?>  </option>
							<option value="Subpoena"> <?php echo $lang['doc_subpoena']; ?>  </option>
							<option value="Requirements"> <?php echo $lang['doc_requirements']; ?>  </option>
							<option value="Other"> <?php echo $lang['doc_others']; ?>  </option>
						</select>
					</div>
					
					<!-- This input box is for inserting the subcategory of the document -->
					<div class="col-md-5">
						<input type="text" class="form-control" placeholder="<?php echo $lang['genSubcategory']; ?>" onkeyup="valid(this)" onblur="valid(this)" name="documentSubcategory" id="documentSubcategory">
					</div>

					<!-- Amount in lawsuit -->
					<div class="col-md-2">
						<input type="text" class="form-control" placeholder="Cantidad">
					</div>
				</div>

				<p></p>
				<div class="row">
					<!-- This input box is to insert name of the addressee region -->
					<div class="col-md-3 ">
<!--						<input type="text" class="form-control" placeholder="<?php// echo $lang['case_region']; ?>" onkeyup="valid(this)" onblur="valid(this)" name="caseRegion" id="caseRegion">-->
						<select class="form-control" name="caseRegion" id="caseRegion" onchange="myFunction()" required>
							<option value="">Seleccione la region</option>
							<option value="Aibonito">Aibonito</option>
							<option value="Aguadilla">Aguadilla</option>
							<option value="Arecibo">Arecibo</option>
							<option value="Bayamon">Bayamón</option>
							<option value="Caguas">Caguas</option>
							<option value="Carolina">Carolina</option>
							<option value="Fajardo">Fajardo</option>
							<option value="Guayama">Guayama</option>
							<option value="Hato Rey">Hato Rey</option>
							<option value="Humacao">Humacao</option>
							<option value="Mayaguez">Mayagüez</option>
							<option value="Ponce">Ponce</option>
							<option value="San Juan">San Juan</option>
							<option value="Utuado">Utuado</option>
						</select>
					</div>

					<!-- This input box is to insert name of the addressee -->
					<div class="col-md-4" id="caseReceiver">
						<!--<input type="text" class="form-control" placeholder="Destinatario" onkeyup="valid(this)" onblur="valid(this)" id="caseReceiver" name="caseReceiver">-->
						<?php session_start();
							$serverName = "127.0.0.1";
							$connectionInfo = array("Database"=>"PoliceTest", "UID"=>"sa", "PWD"=>"A06a30adr5d");
									  			
							$conn = sqlsrv_connect($serverName, $connectionInfo);
							$sql = "SELECT Username, Name, MiddleName, LastName, MaidenName FROM Employee WHERE Job = 'attorney'";
							$stmt = sqlsrv_query($conn, $sql);
							if ($stmt === false) {
							  die(print_r( sqlsrv_errors(), true));
							}
							echo "<select class='form-control' name='caseReceiver' required>";
							echo "<option value=''> $lang[case_receiver] </option>";
							while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
								echo "<option value='" . $row['Username'] . "'>" . $row['Name'] . " " . $row['MiddleName'] . " " . $row['LastName'] . " " . $row['MaidenName'] . "</option>";
							} 
							echo "</select>";
						?>
					</div>
				</div>

				<p></p>
				<div class="row">
					<!-- This input box is to insert name of the lawyer that sends the document -->
					<div class="col-md-3">
						<input type="text" class="form-control" placeholder="<?php echo $lang['case_sender']; ?>" onkeyup="valid(this)" onblur="valid(this)" name="caseSender" id="caseSender">
					</div>
					<div class="col-md-4" id="department">
						<!-- This dropdown is to select the name of the senders office -->
						<select class="form-control" name="department">
							<option> <?php echo $lang['department']; ?> </option>
							<option value="CASP"> Comisión Apelativa del Servicio Publico(CASP) </option>
							<option value="CIPA"> Comisión de Investigacion, Procesamientos y Apelaciones(CIPA) </option>
							<option value="TPI"> Tribunal de Primera Instancia(TPI) </option>
							<option value="TA"> Tribunal de Apelaciones(TA) </option>
							<option value="EEOC"> Equal Employement Opportunity Comission(EEOC) </option>
							<option value="Other"> Otros Asuntos </option>
							<option value="Requeriment"> Requerimientos </option>
						</select>
					</div>
				</div>

				<p></p>
				<!-- This input box is to write some issue of the contract -->
				<textarea class="form-control .input-lg" rows="5" placeholder="<?php echo $lang['case_subject']; ?>" name="caseSubject" id="caseSubject"></textarea>
				
				<p></p>
				<!-- This input box is to write some comments of the contract -->
				<textarea class="form-control .input-lg" rows="5" placeholder="<?php echo $lang['case_comment']; ?>" name="caseComment" id="caseComment"></textarea>
				
				<br></br>
				<div class="footer">
					<div class="row">
						<!-- This button is for canceling everithing and returns to the secretary page -->
						<a class="btn btn-primary pull-right" href="secretaryPagehtml.php"><?php echo $lang['eCancel']; ?></a>
						<!-- This button is for adding a case to the system and returns to the secretary page -->
						<button class="btn btn-primary pull-right" style="margin-right: 4px" type="submit" form="form_anadirCaso"><?php echo $lang['enter']; ?></button>
						<!-- This button is for printing a case -->
						<a class="btn btn-primary pull-right" style="margin-right: 4px" href="javascript:window.print()"> <?php echo $lang['doc_print']; ?> </a>
						<!-- This button is for uploading a case document to the system -->
						<input type="file" name="upload" class="btn btn-primary pull-right" style="margin-right: 4px" name="caseCopy" id="caseCopy">
					</div>
				</div>
			</form>
		</div>

		<script src="js/jquery-1.11.2.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script>
			function myFunction() {
			  var mylist = document.getElementById("caseRegion");
			  //document.getElementById("demo").value = mylist.options[mylist.selectedIndex].text;
			  <?php $city ='document.getElementById("demo").value = mylist.options[mylist.selectedIndex].text;';?>
			}
		</script>
	</body>
</html>
