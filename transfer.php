<?php
	require_once "./DatabaseInterface.php";
	require_once "./permissions.php";
	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Transfers</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	</head>
	<body>
		<h1 align="center">Money Transfering</h1>
		<br>
		<hr>
		<form action="#" method="post">
			<div class="form-group col-md-4">
				Reciever Acoount Number:<input class="form-control" type="number" placeholder="12345678"/>
				How much money to transfer:<input class="form-control" type="number" min="1" placeholder="99999" value="1"/>
				<button id="transfer_btn" class="btn btn-warning" type="submit" onclick="alert('Transfer has done succesfully!');" text="Tranfer">Transfer<i id="transfer_ico" class="glyphicon glyphicon-play"></i></button>
			</div>
		</form>
		<script type="text/javascript">
		$("#transfer_btn").hover(function(){
			$("#transfer_ico").animate({left:200});
		},
		function(){
			$("#transfer_ico").css({left:""});
		});
	</script>
	</body>
</html>