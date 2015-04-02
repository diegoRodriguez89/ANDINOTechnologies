<?php
session_start();
$serverName = "127.0.0.1";
$connectionInfo = array("Database"=>"PoliceTest", "UID"=>"sa", "PWD"=>"A06a30adr5d");

$conn = sqlsrv_connect($serverName, $connectionInfo);
if( !$conn ) {
  die( print_r( sqlsrv_errors(), true));
}

if(!empty($_POST['edit']) and is_array($_POST['edit'])) {
  list($Diego) = $_POST['edit'];
  //list($val1, $val2) = explode(",", $Diego);
  $_SESSION['username'] = $Diego;
  //$_SESSION['EDes'] = $val2;
  header("Location:editEmployeehtml.php");
}

if(!empty($_POST['borrar']) and is_array($_POST['borrar'])) {
  list($Diego) = $_POST['borrar'];
  //list($val1, $val2) = explode(",", $Diego);
	$target = $Diego;
	$sql = "UPDATE Employee SET Job = 'ExEmployee' WHERE Username = '$target'";
	$stmt = sqlsrv_query($conn, $sql);
  //$_SESSION['EDes'] = $val2;
  header("Location:employeeListhtml.php");
}

	include_once 'common.php';
	include 'library.php';

?>
<!DOCTYPE html>
<html>
	<head>
		<!-- This is the name of the page -->
		<title> Lista de Empleados </title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="css/ANDINOstyleSheet.css">
	</head>

	<body>
		<!-- Static navbar -->
		<?php 
			navbarEmployeeList($lang['language'],$lang['logout']);
		?>

		<div class="container">	
			<!-- This is the name in the header of the page -->
			<h1>
			<?php print "$lang[eListHeader]"; ?>
			 </h1>

			<br></br>
			<form id="addEmployee" action="addEmployeehtml.php">
				<button class="btn btn-primary" type="submit" form="addEmployee"> <?php echo $lang['eAdd']; ?></button>
			</form>

			<p></p>

			<!-- This is the table to present all the employees on the system  -->
			<form method="post">
  			<div id="table-scroll">
			<table>
    		<thead>
       		<tr>
           	<th><?php echo $lang['eName']; ?></th>
           	<th colspan="2"><?php echo $lang['eLastNames']; ?></th>
           	<th><?php echo $lang['ePosition']; ?></th>
           	<th></th>
       		</tr>
   			</thead>
		    <tbody>
		    	<?php
		    	  session_start();
		    	  $serverName = "127.0.0.1";
  					$connectionInfo = array("Database"=>"PoliceTest", "UID"=>"sa", "PWD"=>"A06a30adr5d");

  					$conn = sqlsrv_connect($serverName, $connectionInfo);
		    	  $sql = "SELECT Username, Name, LastName, MaidenName, Job FROM Employee WHERE Job <> 'admin' AND Job <> 'ExEmployee'";
					  $stmt = sqlsrv_query($conn, $sql);
					  while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
					  	echo "<tr>";
					  	echo "<td>" . $row['Name'] . "</td>";
					  	echo "<td>" . $row['LastName'] . "</td>";
					  	echo "<td>" . $row['MaidenName'] . "</td>";
					  	echo "<td>" . $row['Job'] . "</td>";
					  	echo "<td><p><p><button class='btn btn-primary' type='submit' name='edit[]' value='".$row['Username']."'>$lang[eEdit] </button>
					  	<button class='btn btn-primary' type='submit' name='borrar[]' value='".$row['Username']."'>$lang[eDelete] </button></p></p></td>";
					  	echo "</tr>";
					  }				
					  sqlsrv_close($conn);
		    	?>
    		</tbody>
			</table>
		</div>
		
		</form>
			<br></br>
			<!-- This button is for canceling everithing and returns to the administrators page -->
			<a class="btn btn-primary pull-right" href="adminPagehtml.php"><?php echo $lang['eCancel']; ?></a>
		</div>	

		<script src="js/jquery-1.11.2.min.js"></script>
		<script src="js/bootstrap.min.js"></script>

	</body>
</html>
