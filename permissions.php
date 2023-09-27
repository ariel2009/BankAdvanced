<?php
    /* Start session if none */
    if (session_status() == PHP_SESSION_NONE) 
	{	
				
        if (isset($_GET["PHPSESSID"]))
		{
			session_id($_GET["PHPSESSID"]);	
		}
		
		session_start();								
    }

    /* Check if the user logged in */
    if(!$_SESSION["user"] or !$_SESSION["accountID"])
    {
        die(Header("Location: ./index.php"));
    }
?>