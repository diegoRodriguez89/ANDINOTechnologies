<?php
	session_start();

    //Includes the libraries to change the language of the page (english/spanish) and the navigational bar
	include_once 'common.php';
	include 'library.php';
?>


<!DOCTYPE html>
<html>
	<head>
		<!-- This is the name of the page -->
		<title> Generar Estadísticas </title>
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

			<form class="form-horizontal" role="form" id="generateOutputStatisticshtml" action="generarOutputEstadisticashtml.php" method = "post">
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
			
			<br></br>
			
			<div class="row">
				<!-- This button is for generating the statistics -->
				<button class="btn btn-primary col-md-offset-4" type = "submit" form ="generateOutputStatisticshtml"><?php echo $lang['generate']; ?></button>
				<!-- This button is for canceling everything and returning to the lawyer page -->
				<a class="btn btn-primary" href="caseSearch.php"><?php echo $lang['eCancel']; ?></a>
			</div>
		</div>

		<script src="js/jquery-1.11.2.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		
	</body>
</html>
