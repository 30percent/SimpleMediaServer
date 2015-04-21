<?php

require_once 'logged.php';
require_once 'meekrodb.php';

//DB::$port = '12345';


if (array_key_exists("ac", $_POST)) { /// do after login form is submitted
	if(($_POST["ac"]=="log")){
		$uname = $_POST["username"];
		$upass = $_POST["password"];
    $result = DB::query("SELECT uid FROM user WHERE username=%s
      AND password=%s", $uname, $upass);
		if(DB::count() == 0) {
			echo'Incorrect username/password. Please, try again.';//die("Incorrect Password");
		}
		else {
			$_SESSION["logged"] = $_POST["username"];
			$_SESSION["loggedid"] = $result[0]['uid'];
		}
	}
	else if(($_POST["ac"]=="logout")){
		$_SESSION["logged"] = "";
	}
};

if (array_key_exists("logged", $_SESSION) && !($_SESSION['logged'] == "") ) { //// check if user is logged or not
	if(!isset($_SESSION['lastpage'])){
		$_SESSION['lastpage']="index.php";
	}
	if($_SESSION['lastpage'] != "login.php"){
		header("Location: " . $_SESSION['lastpage']);
	}else{
		header("Location: index.php");
	}
} else { //// if not logged show login form
	if(!isset($_SESSION['lastpage'])){
		$_SESSION['lastpage']="index.php";
	}
	//echo 'You came from ' . $_SESSION['lastpage'] . '.';
	echo '<html><head></head><body>';
	echo '<table><tr><th>LOGIN FORM</th><th>REGISTRATION FORM</th></tr>';
     echo '<tr><td>
		<table>
			<tr>
			<form action="login.php" method="post"><input type="hidden" name="ac" value="log"> ';

     echo '<td>Username: </td><td><input type="text" name="username"/></td></tr>';

     echo '<tr><td>Password:  </td><td><input type="password" name="password" /></td></tr>';

     echo '<tr><td><input type="submit" value="Login"/></td></tr>';

     echo '</form></table></td>';

		echo '<td><table><form action="register.php" method="post"><input type="hidden" name="ac" value="regi">';

		echo '<tr><td>Username:  </td><td><input type="text" name="username" /></td></tr>';

		echo '<tr><td>Password:  </td><td><input type="password" id="password" name="password" /></td></tr>';

		echo '<tr><td>Repeat Password:  </td><td><input type="password" id="validate"/></td></tr>';

		echo '<tr><td><input type="submit" value="Login" style="text-align: right"/></td></tr>';

		echo '</form></table></td></tr></table>';

		echo "
				<script type='text/javascript' src='fancybox/lib/jquery-1.10.1.min.js'></script>
				<script>
				var pass = document.getElementById('password')
				var validate = document.getElementById('validate');

				function checkPass(){
					if(pass.value != validate.value){
						validate.setCustomValidity('Please check to ensure identical password.');
					} else {
						validate.setCustomValidity('');
					}
				}
				pass.onchange = checkPass;
				validate.onkeyup = checkPass;
				</script>
		";
		echo '</body></html>';

};


?>
