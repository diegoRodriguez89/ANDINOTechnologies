<?php
	//Includes the libraries to change the language of the page (english/spanish) and the navigational bar
	include_once 'common.php';
	include 'library.php';

	if($_SESSION[job] <> 'admin'){
		die("You are not allow in this page. :P");
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<!-- This is the name of the page -->
		<title> Añadir Empleado </title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="css/ANDINOstyleSheet.css">
		<meta charset="UTF-8">
		
		<!-- This is to only permit the characters that we allow to input to the system -->
		<script type="text/JavaScript">
			function valid(f) {
				!(/^[A-z&#209;&#241;0-9; ;.;,;-]*$/i).test(f.value)?f.value = f.value.replace(/[^A-z&#209;&#241;0-9; ;.;,;-]/ig,''):null;
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
			<h1><?php print "$lang[eAdd]"; ?></h1>
			
			<br></br>
			
			<form class="form-horizontal" role="form" id="employeeInfo" action="addEmployee.php" method="post">
				<div class="form-group"> 
					<label for="employee_name" class="col-sm-2 control-label"> <?php print $lang['eFirstName']; ?>:</label> 
					<div class="col-sm-5">
						<!-- This input text is for the name of the employee -->
						<input type="text" class="form-control" id="employeeName" name="employeeName" placeholder="<?php print $lang['eFirstName']; ?>" onkeyup="valid(this)" onblur="valid(this)" required> 
					</div>
				</div> 

				<div class="form-group"> 
					<label for="employee_name" class="col-sm-2 control-label"><?php print $lang['eInitial']; ?>:</label> 
					<div class="col-sm-5">
						<!-- This input text is for the name of the employee -->
						<input type="text" class="form-control" id="employeeInitial" name="employeeInitial" placeholder="<?php print $lang['eInitial']; ?>" onkeyup="valid(this)" onblur="valid(this)"> 
					</div>
				</div>

				<div class="form-group"> 
					<label for="employee_lastname" class="col-sm-2 control-label"><?php print $lang['eLastName']; ?>:</label> 
					<div class="col-sm-5">
						<!-- This input text is for the fisrt last name of the employee -->
						<input type="text" class="form-control" id="employeeLastname" name="employeeLastname" placeholder="<?php print $lang['eLastName']; ?>" onkeyup="valid(this)" onblur="valid(this)" required> 
					</div> 
				</div> 
				
				<div class="form-group"> 
					<label for="employee_lastname2" class="col-sm-2 control-label"><?php print $lang['eMaidenName']; ?>:</label> 
					<div class="col-sm-5">
						<!-- This input text is for the second last name of the employee -->
						<input type="text" class="form-control" id="employeeLastname2" name="employeeLastname2" placeholder="<?php print $lang['eMaidenName']; ?>" onkeyup="valid(this)" onblur="valid(this)"> 
					</div> 
				</div> 
					
				<div class="form-group"> 
					<label for="Type_Employee" class="col-sm-2 control-label"><?php print   $lang['eType']; ?>:</label>
					<div class="col-sm-5" id="TypeEmployee">
						<!-- This dropdown is for selecting the type of employee -->
						<select class="form-control" name="TypeEmployee" required>
							<option><?php print $lang['eType'] ;?>  </option>
							<option value="Técnicas de Sistemas de Oficina III"><?php print $lang['eType_adm_office_techs'];?> </option>
							<option value="Administradora del Sistema I"><?php print $lang['eType_adm_system'];?> </option>
							<option value="Asistente Administrativa"><?php print $lang['eType_adm_assistant'];?> </option>
							<option value="Cadete"><?php print $lang['eType_cadet'];?> </option>
							<option value="Agente"><?php print $lang['eType_agent'];?> </option>
							<option value="Sargento"><?php print $lang['eType_sargent'];?> </option>
							<option value="Teniente"><?php print $lang['eType_lieutenant'];?>  </option>
							<option value="Capitan"><?php print $lang['eType_captain'];?>  </option>
							<option value="Inspector"><?php print $lang['eType_inspector'];?>  </option>
							<option value="Comandante"><?php print $lang['eType_commander'];?>  </option>
							<option value="Teniente Coronel"><?php print $lang['eType_lieutenant_colonel'];?> </option>
							<option value="Coronel"><?php print $lang['eType_colonel'];?> </option>
							<option value="Reservista"><?php print $lang['eType_reservist'];?>  </option>
						</select>
					</div>
				</div>

				<div class="form-group"> 
					<label for="employee_lastname2" class="col-sm-2 control-label"> <?php print $lang['eTemporaryUser'];?>:</label> 
					<div class="col-sm-5">
						<!-- This input text is for the second last name of the employee -->
						<input type="text" class="form-control" id="Username" name="Username" placeholder="<?php print $lang['eTemporaryUser'];?>" onkeyup="valid(this)" onblur="valid(this)" required> 
					</div> 
				</div> 

				<div class="form-group"> 
					<label for="employee_lastname2" class="col-sm-2 control-label"><?php print $lang['eTemporaryPass'];?>:</label> 
					<div class="col-sm-5">
						<!-- This input text is for the second last name of the employee -->
						<input type="password" class="form-control" id="passWord" name="passWord" placeholder="<?php print $lang['eTemporaryPass'];?>" onkeyup="valid(this)" onblur="valid(this)" required> 
					</div> 
				</div> 

				<br></br>
						
				<div class="row">
					
					<!-- This button is for adding a employee to the system -->
					<button class="btn btn-primary col-md-offset-5" type="submit" form="employeeInfo"><?php print $lang['eSubmit'];?></button>
					<!-- This button is for canceling everithing and returns to the administrators page -->
					<a class="btn btn-primary"  href="employeeListhtml.php"> <?php print $lang['eCancel'];?></a>
				</div>
			</form>
		</div>
		<script src="js/jquery-1.11.2.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>
