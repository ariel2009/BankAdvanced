<?php
    /* Import a class responsible foor Database managing */
    require_once './DatabaseInterface.php';
    
    $databaseObj = new DatabaseInterface();

    /* Start session if none */
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    /* Check if the user already logged in */
    if(isset($_SESSION["user"]))
    {
        Header("Location: ./mainPage.php");
    }

    $error_message = null;
    $success_message = null;
    /* If user loged in, call Register function and validate, authenticate and register or return error */
    if(isset($_POST['PassReg']) && isset($_POST['UserReg']))
    {
        $password   = $_POST['PassReg'];
        $username   = $_POST['UserReg'];
        $return_array = $databaseObj->Register($username, $password);
        if($return_array["success"]){
            $success_message = $return_array["data"];
        }
        else
        {
            $error_message = $return_array["data"];
        }

    }
    /* If user loged in, call Login function and validate, authenticate and log in or return error */
    else if(isset($_POST['PassLogin']) && isset($_POST['UserLogin']))
    {
        $password   = $_POST['PassLogin'];
        $username   = $_POST['UserLogin'];

        $return_array = $databaseObj->Login($username, $password);

        if ($return_array["success"] == false)
        {
            $error_message = $return_array["data"];
        }
        else
        {
            /* set session */
            $_SESSION["user"]    = $return_array["data"]["username"];
            $_SESSION["userid"]  = $return_array["data"]["id"];

            /* set cookie */
            die(Header("Location: ./mainPage.php"));
        }
    }

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
	<title>Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <div id="login-panel">
        <form action='#' method="post" class="col-md-4">
            <!-- Login form -->
            <div class="form-group">
                <label for="InputUser1">Username</label>
                <input type="text" class="form-control" id="UserLogin" placeholder="Enter username" name="UserLogin">
            </div>
            <div class="form-group">
                <label for="InputPassword1">Password</label>
                <input type="password" class="form-control" id="PassLogin" placeholder="Password" name="PassLogin">
                <small id="passwordHelp" class="form-text text-muted">Use Capital and small letters, numbers, and special signs</small>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            <span>Don't have an acoount? <a href="#" id="register">Sign Up</a></span>
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
        </form>
    </div>
    <div action='#' id="register-panel" hidden>
        <!-- Register form(hidden by default) -->
        <form action='#' method="post" class="col-md-4">
            <div class="form-group">
                <label for="InputUser2">Username</label>
                <input type="text" class="form-control" id="UserReg" placeholder="Enter username" name="UserReg">
            </div>
            <div class="form-group">
                <label for="InputPassword2">Password</label>
                <input type="password" class="form-control" id="PassReg" placeholder="Password" name="PassReg">
                <small id="passwordHelp" class="form-text text-muted">Use Capital and small letters, numbers, and special signs</small>
            </div>
            <div class="form-group">
                <label for="InputPasswordAccpt">Confirm Password</label>
                <input type="password" class="form-control" id="PassRegAccpt" placeholder="Password" name="PassRegAccpt">
            </div>
            <button id="RegBtn" type="submit" class="btn btn-primary" disabled="true">Register</button>
            <span>Already have an account? <a href="#" id="login">Login</a></span>
        </form>
    </div>
	<script type="text/javascript">
        // Set all buttons design
		$("button").hover(function(){
			$(this).css("background-color","green")
		},
		function(){
			$(this).css("background-color","")
		});
        // Set all input design
		$("input").focus(function(){
			$(this).animate({width:"1000px"})
		});
        // Login button set to disabled until password equals to "Confirm Password"
        $("#PassRegAccpt").keyup( function() {
            if($(this).val()==$("#PassReg").val()){
                $("#RegBtn").prop('disabled',false)
            }
            else{
                $("#RegBtn").prop('disabled',true)
            }
        })
	</script>
    <script src=".\assets\pages\index.js"></script>
	<script src=".\assets\pages\helper.js"></script>
</body>
</html>