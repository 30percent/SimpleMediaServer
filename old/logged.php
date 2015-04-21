<?php

if(!isset($_SESSION)){session_start();}
require_once 'meekrodb.php';

//move to meekrodb.php eventually
DB::$user = 'metube_vcgu';
DB::$password = 'iH4tey0u';
DB::$dbName = 'metube_u4an';
DB::$host = 'mysql1.cs.clemson.edu';
DB::$port = 3306;

function check_logged(){

  global $_SESSION, $USERS, $LASTPAGE, $logged;

  if(!(array_key_exists('logged', $_SESSION)) || $_SESSION['logged'] == "") {
    header("Location: login.php");
  }
  else{
    $logged = $_SESSION['logged'];
		echo '<div class="nospace"><form action="login.php" method="post" target="_top"><input type="hidden" name="ac" value="logout"> ';
		echo '<input type="submit" value="Logout" />';
		echo '</form></div>&nbsp &nbsp &nbsp &nbsp <div class="nospace">';
    echo '<a href="messages.php">Check Messages</a> &nbsp &nbsp <a href="sendmessage.php">Send Message</a></div>';
    echo "&nbsp &nbsp &nbspYou are logged in as <b>";
		echo $_SESSION['logged']; //// if user is logged show a message
		echo "</b>.";
    echo "<form action='search.php' method='get'>";
    echo "<input type='text' name='contents' placeholder='Search tags' required>";
    echo "<input type='hidden' name='type' value='tag'>";
    echo "<input type='submit' value='Search'>";
    echo "</form>";
	}

};

?>
