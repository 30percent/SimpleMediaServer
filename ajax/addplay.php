<?php
  require_once "../scripts/core.php";

  $myID = $_SESSION["loggedid"];
  DB::$error_handler = false; // since we're catching errors, don't need error handler
  DB::$throw_exception_on_error = true;

  try {
    if(isset($_POST) && isset($_POST["playlist"]) && isset($_POST["video"])){
      DB::insert('playlistcontents', array(
        'pid' => $_POST["playlist"],
        'mid' => $_POST["video"]
      ));
    }
  } catch(MeekroDBException $e) {
    //already added to list
  }

  // restore default error handling behavior
  // don't throw any more exceptions, and die on errors
  DB::$error_handler = 'meekrodb_error_handler';
  DB::$throw_exception_on_error = false;
  echo "<script>window.close();</script>";
?>
