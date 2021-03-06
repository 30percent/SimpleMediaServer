<?php
  //print_r($_POST);

  require_once "../scripts/core.php";


  DB::$error_handler = false; // since we're catching errors, don't need error handler
  DB::$throw_exception_on_error = true;

  try {
    if(isset($_POST) && isset($_POST["comment"]) && isset($_POST["video"])){
    $myID = $_SESSION["loggedid"];
    $comment = $_POST["comment"];
    $video = $_POST["video"];
      DB::insert('mediacomment', array(
        'mid' => $video,
        'uid' => $myID,
        'message' => $comment
      ));
      echo "Comment Posted Successfully!";
    }
  } catch(MeekroDBException $e) {
    echo "Message failed to send. Ensure you got here from video comment section.";
  }

  // restore default error handling behavior
  // don't throw any more exceptions, and die on errors
  DB::$error_handler = 'meekrodb_error_handler';
  DB::$throw_exception_on_error = false;


?>
