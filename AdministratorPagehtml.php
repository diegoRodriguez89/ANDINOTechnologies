<?php
session_start();
$serverName = "127.0.0.1";
$connectionInfo = array("Database"=>"PoliceTest", "UID"=>"sa", "PWD"=>"A06a30adr5d");

$conn = sqlsrv_connect($serverName, $connectionInfo);                        
if( !$conn ) {
  die( print_r( sqlsrv_errors(), true));
}

if(!empty($_POST['view']) and is_array($_POST['view'])) {
  list($Diego) = $_POST['view'];
  //list($val1, $val2) = explode(",", $Diego);
  $_SESSION['docID'] = $Diego;
  //$_SESSION['EDes'] = $val2;
  header("Location:adminViewCasehtml.php");
}
	include_once 'common.php';
	include 'library.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<!-- This is the name of the page -->
		<title> Pagina del Administrador </title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="css/ANDINOstyleSheet.css">
		<meta charset="UTF-8">

		<!-- This is to only permit the characters that we allow to input to the system -->
	<script type="text/JavaScript">
		function valid(f) {
		!(/^[A-z;0-9; ;#]*$/i).test(f.value)?f.value = f.value.replace(/[^A-z;0-9; ;#]/ig,''):null;
		} 
	</script>

	</head>

	
	
	<body>
		<!-- Static navbar -->
		<?php 
			navbarAdmin($lang['searchButton'],$lang['language'],$lang['logout']);
		?>



		
		<div class="container">
			<!-- This is the name in the header of the page -->
			<h1>			
			<?php 
			print "$lang[adminPage]"; 
			?> </h1>

			<br></br>

			<h3>
				<?php session_start();
				echo $_SESSION[name] . " " . $_SESSION[initial] . " " . $_SESSION[last] . " " . $_SESSION[maiden]; ?>
			</h3>

			<!-- This button is to show the list of employee and will send the user to that page -->
			<form id="employees" action="employeeListhtml.php">
				<button class="btn btn-primary" type="submit" form="employees"> <?php echo $lang['eList']; ?> </button>
			

			<!-- This button is generated statistics and will send the user to that page -->
			
				<a class="btn btn-primary col-md-offset-1" href="GenerarEstadisticashtml.php">  <?php echo $lang['genStats']; ?> </a>
			</form>

			<br></br>

			<!-- This is the table to present all the cases that are closer to the deadline -->
			<form method="post">
			<table>
    		<thead>
       		<tr>
           	<th> <?php echo $lang['case_num']; ?></th>
<!--          	<th>Nombre</th> -->
           	<th><?php echo $lang['docType']; ?> </th>
           	<th><?php echo $lang['dDate']; ?></th>
           	<th><?php echo $lang['status']; ?></th>
       		</tr>
   			</thead>
		    <tbody>
		    	<?php
		    	  session_start();
		    	  $serverName = "127.0.0.1";
  					$connectionInfo = array("Database"=>"PoliceTest", "UID"=>"sa", "PWD"=>"A06a30adr5d");

  					$conn = sqlsrv_connect($serverName, $connectionInfo);

  					$d=strtotime("+5 days");
  					$limite =  date("Y-m-d", $d);
		    	    $sql = "SELECT DocNumber, DocType, CONVERT(VARCHAR(11),Deadline,106) AS fecha, DocStatus FROM Documents WHERE Deadline < '$limite'";
		    	
					  $stmt = sqlsrv_query($conn, $sql);
					  while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
					  	echo "<tr class='invalid'>";
					  	echo "<td>" . $row['DocNumber'] . "</td>";
					  	echo "<td>" . $row['DocType'] . "</td>";
					  	
					  	if(is_null($row['fecha'])){
					  		echo "<td> None </td>";
					  	} else { 
					  		echo "<td>" . $row['fecha'] . "</td>";
					  	}
					  	echo "<td>" . $row['DocStatus'] . "</td>";
					  	echo "<td><p><p><button class='btn btn-primary' type='submit' name='view[]' value='".$row['DocNumber']."'>$lang[viewCase] </button></p></p></td>";
					  	echo "</tr>";
					  }				
					  sqlsrv_close($conn);
		    	?>
    		</tbody>
			</table>
			</form>	
		</div>

		<script src="js/jquery-1.11.2.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script type="text/JavaScript">
		$(function() {
        var on = false;
        window.setInterval(function() {
            on = !on;
            if (on) {
                $('.invalid').addClass('invalid-blink')
            } else {
                $('.invalid-blink').removeClass('invalid-blink')
            }
        }, 800);
    });
	</script>
	
	</body>
</html>
