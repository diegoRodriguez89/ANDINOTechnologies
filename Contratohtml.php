<?php

	include_once 'common.php';
	include 'library.php';
	?>
	

<!DOCTYPE html>
<html>
	<head>
		<!-- This is the name of the page -->
		<title> Contratos </title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="css/ANDINOstyleSheet.css">
	</head>

	<!-- This is to only permit the characters that we allow to input to the system -->
	<script type="text/JavaScript">
		function valid(f) {
		!(/^[A-z0-9; ;.;,;#]*$/i).test(f.value)?f.value = f.value.replace(/[^A-z;0-9; ;.;,;&;#]/ig,''):null;
		} 
	</script>
	
	<body>
		<!-- Static navbar -->
		<?php 
			navbarEmployeeList($lang['language'],$lang['logout']);
		?>
		
		<div class="container">
			<!-- This is the name in the header of the page -->
			<h1> Contratos </h1>
			
			<br></br>
			
			<div class="row">
				<!-- This input is to select the document date -->
				<label class="col-md-2"> <?php echo $lang['date_issued']; ?> <input type="date" class="form-control"></label>
				<!-- This input is to select the date that the document was received -->
				<label class="col-md-2 col-md-offset-1"><?php echo $lang['date_received']; ?><input type="date" class="form-control"></label>
				<!-- This input is to select the document deadline date -->
				<label class="col-md-2 col-md-offset-1"><?php echo $lang['date_due']; ?> <input type="date" class="form-control"></label>
	
			</div>
			<p></p>
			<div class="row">
				<!-- This input box is to insert the contract number -->
				<div class="col-md-2"><input type="text" class="form-control" placeholder="<?php echo $lang['contract_num']; ?> " onkeyup="valid(this)" onblur="valid(this)"></div>
				<!-- This input box is to insert the name of contractor the  -->
				<div class="col-md-5 col-md-offset-1"><input type="text" class="form-control" placeholder="<?php echo $lang['eName']; ?>" onkeyup="valid(this)" onblur="valid(this)"></div>
			</div>
			
			<p></p>
			<div class="row">
				<div class="col-md-3">
					<!-- This dropdown is to select the type of contract -->
					<select class="form-control">
						<option> <?php echo $lang['contType']; ?> </option>
						<option> Compra, Venta y Alquiler de Equipo, Vehiculos y Otros </option>
						<option> Compra, Venta y/0 alquiler de inmuebles </option>
						<option> Compra de Materiales, Suministros y Efectos </option>
						<option> Adquisicíon de Seguros </option>
						<option> Construcción y Reparación de Vías Públicas </option>
						<option> Construcción y Reparación de Estructuras </option>
						<option> Préstamos </option>
						<option> Rescisión de Contratos </option>
						<option> Servicios de Adiestramineto e Orientación </option>
						<option> Servicios de Consultoría </option>
						<option> Servicios de Publicidad de representación o artísticos </option>
						<option> Servicios misceláneos no personales </option>
						<option> Servicios personales no profesionales </option>
						<option> Servicios Relacionados con la Salud </option>
						<option> Servicios Técnicos </option>
						<option> Transferencia de Fondos </option>
						<option> Acuerdos no Financieros </option>
						<option> Compra y Venta de Obras de Artes y Tesoros Históricos </option>
						<option> Energia Renovable y Gas Natural </option>
						<option> Servicios Profesionales </option>
						<option> Servicios Relacionados a los Sistemas de Información </option>
						<option> Recogido de Desperdicios y Reciclaje </option>
						<option> Interagenciales </option>
					</select>
				</div>

				<!-- This input box is to insert the type of service of the contract -->
				<div class="col-md-5"><input type="text" class="form-control" placeholder="<?php echo $lang['serviceType']; ?>" onkeyup="valid(this)" onblur="valid(this)"></div>


			</div>

			<p></p>
			<div class="row">
				<!-- This input box is for the name of the destinatary -->
				<div class="col-md-3 "><input type="text" class="form-control" placeholder="<?php echo $lang['case_receiver']; ?>" onkeyup="valid(this)" onblur="valid(this)"></div>
				<!-- This input box is for the name of the region of the destinatary -->
				<div class="col-md-4 "><input type="text" class="form-control" placeholder="<?php echo $lang['case_region']; ?>" onkeyup="valid(this)" onblur="valid(this)"></div>
			</div>

			<p></p>
			<!-- This input box is to write some issue of the contract -->
			<textarea class="form-control .input-lg" rows="5" placeholder="<?php echo $lang['case_subject']; ?>" onkeyup="valid(this)" onblur="valid(this)"></textarea>
			
			<p></p>
			<!-- This input box is to write some comments of the contract -->
			<textarea class="form-control .input-lg" rows="5" placeholder="<?php echo $lang['case_comment']; ?>" onkeyup="valid(this)" onblur="valid(this)"></textarea>
			
			<br></br>
			
			<div class="footer">
			<div class="row">
				<!-- This button is for canceling everithing and returns to the secretary page -->
				<a class="btn btn-primary pull-right" href="secretaryPagehtml.php"><?php echo $lang['eCancel']; ?></a>
				<!-- This button is for adding a contract to the system and returns to the secretary page -->
				<a class="btn btn-primary pull-right" style="margin-right: 4px" href="secretaryPagehtml.php"><?php echo $lang['enter']; ?></a>
				<!-- This button is for printing a contract -->
				<a class="btn btn-primary pull-right" style="margin-right: 4px" href="javascript:window.print()"> <?php echo $lang['doc_print']; ?> </a>
				<!-- This button is for uploading a contract document to the system -->
				<input type="file" name="upload" class="btn btn-primary pull-right" style="margin-right: 4px">
			</div>
			</div>
		
		</div>

		<script src="js/jquery-1.11.2.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	
	</body>
</html>
