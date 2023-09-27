<?php
	require_once "./DatabaseInterface.php";
	require_once "./permissions.php";
	$databaseObj = new DatabaseInterface();
	if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
	if(isset($_POST["accountTo"]) and isset($_POST["amount"])){
		$this_account = $_SESSION["accountID"];
		$to_account = $_POST["accountTo"];
		$amount = $_POST["amount"];
		$transfered_array = $databaseObj->Transfer($this_account,$to_account, $amount);
		if($transfered_array["success"]){
            $success_message = $transfered_array["data"];
			die(Header("Location: ./mainPage.php"));
        }
        else
        {
            $error_message = $transfered_array["data"];
        }
	}
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
				Reciever Acoount Number:<input class="form-control" type="number" min="1" value=999999999 name="accountTo" placeholder="12345678"/>
				How much money to transfer:<input class="form-control" name="amount" type="number" min="1" placeholder="99999" value="1"/>
				<button id="transfer_btn" class="btn btn-warning" type="submit" text="Tranfer">Transfer<i id="transfer_ico" class="glyphicon glyphicon-play"></i></button>
				<?php
					/* return success/error depending on action result */
					if (isset($error_message))
					{
						echo "<div class='alert alert-danger'><strong>Error:</strong>".$error_message."</div>";
					}
					else if (isset($success_message))
					{
						echo "<div class='alert alert-success'><strong>Note:</strong>".$success_message."</div>";
					}
            	?>
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