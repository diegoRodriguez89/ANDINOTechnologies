<!DOCTYPE html>
<html>
	<head>
		<title> Iniciar Sesión </title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="css/ANDINOstyleSheet.css">
		<meta charset="UTF-8">
	</head>

	<body>
		<!-- This is the navbar of the system -->
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand">ANDINO Legal Solution</a>
				</div>
			</div>
		</nav>

		<div class="container">
			<h1> Change User </h1>
			<br></br>
			<!-- Field to enter the username and the password -->
			<form class="form-horizontal col-md-offset-1" id="changeUser" action="change.php" method="post">
				<!-- Here is the space for the username of the administrator, secretary or attorney -->
				<div class="form-group">
					<label class="col-sm-2 control-label">Old Username :</label>
					<div class="col-sm-5">
						<input type="text" class="form-control" id="oldName" minlength="8" maxlength="15" name="oldName" placeholder="Old Username" required>
					</div>
				</div>

				<p></p>
				<div class="form-group">
					<label class="col-sm-2 control-label">New Username :</label>
					<div class="col-sm-5">
						<input type="text" class="form-control" id="newName" minlength="8" maxlength="15" name="newName" placeholder="New Username" required>
					</div>
				</div>

				<p></p>
				<!-- Here is the space for the password of the user -->
				<div class="form-group">
					<label class="col-sm-2 control-label">Old Password :</label>
					<div class="col-sm-5">
						<input type="password" class="form-control" id="oldPassword" minlength="8" maxlength="12"  name="oldPassword" placeholder="Password" required>
					</div>
				</div>

				<p></p>
				<!-- Here is the space for the password of the user -->
				<div class="form-group">
					<label class="col-sm-2 control-label">New Password :</label>
					<div class="col-sm-5">
						<input type="password" class="form-control" id="newPassword" minlength="8" maxlength="12"  name="newPassword" placeholder="Password" required>
					</div>
				</div>

				<p></p>
				<!-- Here is the space for the password of the user -->
				<div class="form-group">
					<label class="col-sm-2 control-label">Confirm Password :</label>
					<div class="col-sm-5">
						<input type="password" class="form-control" id="confirmPassword" minlength="8" maxlength="12"  name="confirmPassword" placeholder="Password" required>
					</div>
				</div>

				<p></p>
				<!-- checkbox to remember the username and the password of the user -->
				<div>
					<!-- Button to start the session -->
					<div class="row">
						<button class="btn btn-primary col-md-offset-1" type="submit" form="changeUser">Change</button>
						<a class="btn btn-primary" href="IniciarSesionhtml.php">Cancel</a>
					</div>
				</div>
			</form>

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
		</div>
				
		<script src="js/jquery-1.11.2.min.js"></script>
		<script src="js/bootstrap.min.js"></script>

	</body>
</html>
