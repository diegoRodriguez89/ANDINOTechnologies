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
  	header("Location:attorneyViewCasehtml.php");
}

	include_once 'common.php';
	include 'library.php';

?>

<!DOCTYPE html>
<html>
	<head>
		<!-- This is the name of the page -->
		<title> Perfil del Abogado </title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="css/ANDINOstyleSheet.css">
	</head>

	<!-- This is to only permit the characters that we allow to input to the system -->
	<script type="text/JavaScript">
		function valid(f) {
		!(/^[A-z&#209;&#241;0-9; ;.;,]*$/i).test(f.value)?f.value = f.value.replace(/[^A-z&#209;&#241;0-9; ;.;,]/ig,''):null;
		} 
	</script>
	
	<body>
		<!-- Static navbar -->
		<?php 
			navbarAdmin($lang['searchButton'],$lang['language'],$lang['logout']);
		?>

		
		<div class="container">
			<!-- This is the name in the header of the page -->
			<h1> 
			<?php print "$lang[l_profile]"; ?>
			</h1>
			
			<br></br>
			<!-- This text box will show the name of the lawyer -->
			<h3>
				<?php session_start();
				echo $_SESSION[name] . " " . $_SESSION[initial] . " " . $_SESSION[last] . " " . $_SESSION[maiden]; ?>
			</h3>
<!--			<div class="row">
				<div class="col-md-4"><input type="text" class="form-control" placeholder="Lic. Nombre" disable></div>
			</div>
			<div class="row">
				<div class="col-md-2"><input type="text" class="form-control" placeholder="Id" disable></div>
			</div>
-->
			<p></p>
			<!-- This button is generated statistics and will send the user to that page -->
			<a class="btn btn-primary" href="GenerarEstadisticashtml.php">  <?php echo $lang['genStats']; ?> </a>

			<br></br>
			
			<form method = "post">
				<div class="btn-group btn-group-xs" role="group" aria-label="..." name="selectDoc" id="selectDoc">					
					<button type="button" class="btn btn-default" value="1"><?php echo $lang['l_docs']; ?></button>
  				<button type="button" class="btn btn-default" value="2"><?php echo $lang['allDocs']; ?></button>
				</div>
			<!-- This is the table to present all the cases that are closer to the deadline -->
			<table>
    		<thead>
       		<tr>
           	<th><?php echo $lang['case_num']; ?></th>
           	<th><?php echo $lang['docType']; ?></th>
           	<th><?php echo $lang['dDate']; ?></th>
           	<th><?php echo $lang['status']; ?></th>
           	<th></th>
       		</tr>
   			</thead>
		    <tbody>
		    	<?php
		    	  session_start();
		    	  $serverName = "127.0.0.1";
  					$connectionInfo = array("Database"=>"PoliceTest", "UID"=>"sa", "PWD"=>"A06a30adr5d");

  					$conn = sqlsrv_connect($serverName, $connectionInfo);
  					$d=strtotime("+5 days");
  					$h=strtotime("now");
  					$limite =  date("j M Y", $d);
  					$hoy = date("Y-m-d", $h);
			    	  $sql = "SELECT DocNumber, DocType, CONVERT(VARCHAR(11),Deadline,106) AS fecha, DocStatus FROM Documents
			    	  				WHERE DocStatus <> 'Procesado'
			    	  				AND DocNumber IN (SELECT DocId FROM Manage WHERE EmployeeName = '$_SESSION[username]')";
			    	  
						  $stmt = sqlsrv_query($conn, $sql);
						  if ($stmt === false) {
   							die(print_r( sqlsrv_errors(), true));
  						}
						  while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
						  	//die($row['fecha'] < $limite);
						  	if(is_null($row['fecha']) || $row['fecha'] < $limite || $row['DocStatus'] == 'Procesado') {
						  		echo "<tr>";
						  	} else {
						  		echo "<tr class='invalid'>";
						  	}
						  	echo "<td>" . $row['DocNumber'] . "</td>";
						  	echo "<td>" . $row['DocType'] . "</td>";
						  	
						  	if(is_null($row['fecha'])){
						  		echo "<td> None </td>";
						  	} else { 
						  		echo "<td>" . $row['fecha'] . "</td>";
						  	}
						  	echo "<td>" . $row['DocStatus'] . "</td>";
						  	echo "<td><p><p><button class='btn btn-primary' type='submit' name='view[]' value='".$row['DocNumber']."'>$lang[viewCase]</button></p></p>";
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
