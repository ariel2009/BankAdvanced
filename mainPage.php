<?php
	require_once './permissions.php';
	require_once './DatabaseInterface.php';
	$databaseObj = new DatabaseInterface();
	$transfered_array = $databaseObj->GetTransfers();
		if(!$transfered_array["success"]){
			$error_message = $transfered_array["data"];
        }
		else{
			$transfers = $transfered_array["data"];
		}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
	<!--All the data is not real and for example only-->
	<nav class="nav navbar-default">
		<div class="container-fluid">
			<ul class="nav navbar-nav">
				<li><a href=transfer.php>Money Trnsfer</a></li>
				<li><a href=profSet.php>Update Profile</a></li>
				<li><a id="logout" href="#">Log out <i id="logout_icon" class="glyphicon glyphicon-log-out"></i></a></li>
			</ul>
		</div>
	</nav>
	<h2 align="center">Dashboard</h2>
	<br>
	<?php
		echo sprintf("<h3 align='center'><label class='label label-info'>Balance:</label> %s$</h3>", $databaseObj->GetTotal($_SESSION["accountID"]));
		echo "<h2><b>Activities</b></h2>";
		echo "<hr>";
		if(isset($error_message)){
			echo $error_message;
		}
		else{
			foreach ($transfers as $transfer){
				if($transfer["accountFromID"] == $_SESSION["accountID"]){
					echo sprintf("<h3> You <span style='color:red'>--></span> %s: <h4>%s$</h4></h3> ", $transfer["accountToID"],$transfer["amount"]);
				}
				else{
					echo sprintf("<h3> %s <span style='color:green'>--></span> You: <h4>%s$</h4></h3>", $transfer["accountFromID"], $transfer["amount"]);
				}
				echo '<br>';
			}
		}
		//<h3><label class="label label-warning">Recent Payments:</label><span style="color:red">-5.88</span>   swimming pool</h3>
	?>
	<script type="text/javascript">
		$("#logout").hover(function(){
			$("#logout_icon").animate({left:200});
		},
		function(){
			$("#logout_icon").css({left:""});
		});
	</script>
	<script src=".\assets\pages\main.js"></script>
	<script src=".\assets\pages\helper.js"></script>
</body>
</html>