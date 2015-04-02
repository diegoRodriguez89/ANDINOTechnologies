<?php
	session_start();
	session_unset();

	if(isset($_GET['lang']) && $_GET['lang'] == 'en'){
	
			include_once 'lang.en.php';
		
		
	}else{
			include_once 'lang.es.php';
	}

	
	//include_once 'common.php';
	//include_once 'lang.es.php';
	//include_once 'lang.en.php';
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
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand">ANDINO Legal Solution</a>
				</div>

		      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

		      <form class="navbar-form navbar-right	">
                <!--<li><a class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
                  <?php 
                  //  echo $lang['language']; 
                  ?>
                  <span class="caret"></span>
                </a>
                <div class="dropdown-menu" id="lang-menu" style="center"> 
                  <li><a href="IniciarSesionhtml.php?lang=en" >English</a></li>
                  <li><a href="IniciarSesionhtml.php?lang=es" >Español</a></li>
                </div></li> -->

               <div class="btn-group">
  					 <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
      				    <?php 
                  		  echo $lang['language']; 
                  		?>
      				 <span class="caret"></span>
   					</button>
   					<ul class="dropdown-menu" role="menu">
      				<li><a href="IniciarSesionhtml.php?lang=en">English</a></li>
    			    <li><a href="IniciarSesionhtml.php?lang=es">Español</a></li>
   					</ul>
				</div>

		      </form>

			</div>
		</nav>

		<div class="container">
			<h1> 
				<?php
				echo $lang['signIn']; 
				?> </h1>
			<br></br>
			<!-- Field to enter the username and the password -->
			<form class="form-inline col-md-offset-1" id="form-user" action="login.php" method="post">
				<!-- Here is the space for the username of the administrator, secretary or attorney -->
				<div class="row">
					<label> <?php echo $lang['userName']; ?>:</label>
					<input type="text" class="form-control" id="userName" minlength="8" maxlength="15" name="userName" placeholder="<?php echo $lang['userName']; ?>" required>
				</div>

				<p></p>
				<!-- Here is the space for the password of the user -->
				<div class="row">
					<label><?php echo $lang['userPassword']; ?>:</label>
					<input type="password" class="form-control" id="userPassword" minlength="8" maxlength="12"  name="userPassword" placeholder="<?php echo $lang['userPassword']; ?>" required>
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
						<button class="btn btn-primary col-md-offset-1" type="submit" form="form-user" > <?php echo $lang['enter']; ?> </button>
						<a class="btn btn-primary" href="changehtml.php"> <?php echo  $lang['userChange']; ?> </a>
					</div>
				</div>
			</form>

		</div>
		<?php
		if($lang)		print_r($lang);
		else print "Variable $lang no se encuentra.";
		?>		
		<script src="js/jquery-1.11.2.min.js"></script>
		<script src="js/bootstrap.min.js"></script>

	</body>
</html>
