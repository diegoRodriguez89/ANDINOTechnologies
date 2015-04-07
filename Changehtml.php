<?php
	//This is to use the $_SESSION variables. This variables are to pass the values from page to page.
	session_start();

	//Includes the libraries to change the language of the page (english/spanish) and the navigational bar
	include_once 'common.php';
	include 'library.php';
?>

<!DOCTYPE html>
<html>
	<head>
		<!-- This is the name of the page -->
		<title> Iniciar Sesión </title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="css/ANDINOstyleSheet.css">
		<meta charset="UTF-8">
	</head>

	<body>
		<!-- This is the navbar of the system -->
		<?php
			navbar($lang['language'])
		?>

		<div class="container">
			<h1> <?php echo $lang['changeUser']; ?> </h1>
			<br></br>
			<!-- Field to enter the username and the password -->
			<form class="form-horizontal col-md-offset-1" id="changeUser" action="change.php" method="post">
				<!-- Here is the space for the username of the administrator, secretary or attorney -->
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo $lang['oldUserName']; ?>:</label>
					<div class="col-sm-5">
						<input type="text" class="form-control" id="oldName" minlength="8" maxlength="15" name="oldName" placeholder="Old Username" required>
					</div>
				</div>

				<p></p>
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo $lang['newUserName']; ?>:</label>
					<div class="col-sm-5">
						<input type="text" class="form-control" id="newName" minlength="8" maxlength="15" name="newName" placeholder="New Username" required>
					</div>
				</div>

				<p></p>
				<!-- Here is the space for the password of the user -->
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo $lang['oldPassword']; ?>:</label>
					<div class="col-sm-5">
						<input type="password" class="form-control" id="oldPassword" minlength="8" maxlength="12"  name="oldPassword" placeholder="Password" required>
					</div>
				</div>

				<p></p>
				<!-- Here is the space for the password of the user -->
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo $lang['newPassword']; ?>:</label>
					<div class="col-sm-5">
						<input type="password" class="form-control" id="newPassword" minlength="8" maxlength="12"  name="newPassword" placeholder="Password" required>
					</div>
				</div>

				<p></p>
				<!-- Here is the space for the password of the user -->
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo $lang['confirmPassword']; ?>:</label>
					<div class="col-sm-5">
						<input type="password" class="form-control" id="confirmPassword" minlength="8" maxlength="12"  name="confirmPassword" placeholder="Password" required>
					</div>
				</div>

				<p></p>
				<!-- checkbox to remember the username and the password of the user -->
				<div>
					<!-- Button to start the session -->
					<div class="row">
						<button class="btn btn-primary col-md-offset-5" type="submit" form="changeUser"><?php echo $lang['change']; ?></button>
						<a class="btn btn-primary" href="IniciarSesionhtml.php"><?php echo $lang['eCancel']; ?></a>
					</div>
				</div>
			</form>			
		</div>
				
		<script src="js/jquery-1.11.2.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<!-- this function is to corroborate that the password confirmation is identical to the password -->
		<script> var password = document.getElementById("newPassword"), confirm_password = document.getElementById("confirmPassword");
			function validatePassword(){
			  if(password.value != confirm_password.value) {
			    confirm_password.setCustomValidity("Passwords Don't Match");
			  } else {
			    confirm_password.setCustomValidity('');
			  }
			}
			password.onchange = validatePassword;
			confirm_password.onkeyup = validatePassword;
		</script>
	</body>
</html>
