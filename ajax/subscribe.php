<?php
  print_r($_POST);

    require_once "../scripts/core.php";

    $myID = $_SESSION["loggedid"];
    DB::$error_handler = false; // since we're catching errors, don't need error handler
    DB::$throw_exception_on_error = true;

    try {
      if(isset($_POST) && isset($_POST["channel"])){
        DB::insert('subscription', array(
          'subid' => $_POST["channel"],
          'uid' => $myID
        ));
        echo "You've now subscribed.";
      }
    } catch(MeekroDBException $e) {
      echo "You remain subscribed.";
    }

    // restore default error handling behavior
    // don't throw any more exceptions, and die on errors
    DB::$error_handler = 'meekrodb_error_handler';
    DB::$throw_exception_on_error = false;
    echo "<script>window.close();</script>";
?>
