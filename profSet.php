<?php
	require_once './DatabaseInterface.php';
	require_once "./permissions.php";
	$databaseObj = new DatabaseInterface();
	if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
	if(isset($_POST['currentPass']) && isset($_POST['newPass']))
    {
		$username = $_SESSION['user'];
        $oldpassword   = $_POST['currentPass'];
        $newpassword   = $_POST['newPass'];
        $return_array = $databaseObj->UpdateProfile($username, $oldpassword,$newpassword);
        if($return_array["success"]){
            $success_message = $return_array["data"];
			die(Header("Location: ./index.php"));
        }
        else
        {
			$error_message = $return_array["data"];
        }
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Profile Updating</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	</head>
	<body>
		<nav class="nav navbar-default">
			<div class="container-fluid">
				<ul class="nav navbar-nav">
					<li><a href=transfer.html>Money Trnsfer</a></li>
					<li><a href=mainPage.php>Dashboard</a></li>
					<li><a id="logout" href="#">Log out <i id="logout_icon" class="glyphicon glyphicon-log-out"></i></a></li>
				</ul>
			</div>
		</nav>
		<h1 class="">Profile Updating</h1>
		<br>
		<hr>
		<form action="#" method="post">
			<div class="form-group col-md-4">
				Current Password:<input name="currentPass" id="currentPass" class="form-control" type="password"/>
				New Password:<input name="newPass" id="newPass" class="form-control" type="password"/>
				<button class="btn btn-success" type="submit">Update <i class="glyphicon glyphicon-upload"></i></button>
			</div>
			<?php
				if (isset($error_message))
				{
					echo "<div class='alert alert-danger'><strong>Error:</strong>".$error_message."</div>";
				}
				else if (isset($success_message))
				{
					echo "<div class='alert alert-success'><strong>Note:</strong>".$success_message."</div>";
				}
            ?>
		</form>
	<script type="text/javascript">
		$("input").focus(function(){
			$(this).animate({width:"1000px"})
		})
	</script>
	<script type="text/javascript">
		$("#logout").hover(function(){
			$("#logout_icon").animate({left:200});
		},
		function(){
			$("#logout_icon").css({left:""});
		});
	</script>
	<script src=".\assets\pages\helper.js"></script>
	<script src=".\assets\pages\main.js"></script>
	</body>
</html>