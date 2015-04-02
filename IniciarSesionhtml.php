<?php
	session_start();
	session_unset();

	include_once 'common.php';
	include 'library.php';
?>

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
		<?php 
			navbar($lang['language']);
		?>

		<div class="container">
			<h1> 
			<?php 
			print "$lang[signIn]"; 
			?> 
			</h1>
			<br></br>
			<!-- Field to enter the username and the password -->
			<form class="form-inline col-md-offset-1" id="form-user" action="login.php" method="post">
				<!-- Here is the space for the username of the administrator, secretary or attorney -->
				<div class="row">
					<label> <?php 
					print $lang['userName'];
					 ?>:
					</label>
					<input type="text" class="form-control" id="userName" minlength="8" maxlength="15" name="userName" placeholder="<?php print $lang['userName']; ?>" required>
				</div>

				<p></p>
				<!-- Here is the space for the password of the user -->
				<div class="row">
					<label>
					<?php
					print $lang['userPassword']; 
					?>:
					</label>
					<input type="password" class="form-control" id="userPassword" minlength="8" maxlength="12"  name="userPassword" placeholder="<?php print $lang['userPassword'];	?>" required>
				</div>

				<p></p>
				<!-- checkbox to remember the username and the password of the user -->
				<div>
					<label class="checkbox-inline"> 
						<input type="checkbox" name="optionsRadiosinline" id="optionsRadios3" value="option1">  <?php echo $lang['remember']; ?>
					</label> 

					<br></br>
					<!-- Button to start the session -->
					<div class="row">
						<button class="btn btn-primary col-md-offset-1" type="submit" form="form-user" > <?php echo $lang['signup']; ?></button>
						<a class="btn btn-primary" href="changehtml.php"><?php echo $lang['userChange']; ?></a>
					</div>
				</div>
			</form>

		</div>
		<?php
		//print_r($lang);
		?>

		<script src="js/jquery-1.11.2.min.js"></script>
		<script src="js/bootstrap.min.js"></script>

	</body>
</html>
