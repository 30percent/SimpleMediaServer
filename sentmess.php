<?php
  //print_r($_POST);

  require_once "meekrodb.php";
  require_once "logged.php";


  DB::$error_handler = false; // since we're catching errors, don't need error handler
  DB::$throw_exception_on_error = true;

  try {
    if(isset($_POST) && isset($_POST["message"]) && isset($_POST["user"])){
    $myID = $_SESSION["loggedid"];
    $message = $_POST["message"];
    $user = $_POST["user"];
    $result = DB::query("SELECT uid FROM user where username=%s", $user);
    $uid = $result[0]['uid'];
    $title = $_POST["title"];
      DB::insert('mailbox', array(
        'uid' => $uid,
        'suid' => $myID,
        'title' => $title,
        'message' => $message
      ));
      echo "Message Sent Successfully!";
    }
  } catch(MeekroDBException $e) {
    echo "Message failed to send. Ensure the user actually exists.";
  }

  // restore default error handling behavior
  // don't throw any more exceptions, and die on errors
  DB::$error_handler = 'meekrodb_error_handler';
  DB::$throw_exception_on_error = false;


?>
