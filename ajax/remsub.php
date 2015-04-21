<?php
  require_once "../script/core.php";
  //print_r($_GET);
  DB::$error_handler = false; // since we're catching errors, don't need error handler
  DB::$throw_exception_on_error = true;

  try {
    DB::delete('subscription', 'subid=%i and uid=%i', $_GET['channel'], $_SESSION['loggedid']);
  } catch(MeekroDBException $e) {
    echo "Error: " . $e->getMessage() . "<br>\n"; // something about duplicate keys
    echo "SQL Query: " . $e->getQuery() . "<br>\n"; // INSERT INTO accounts...
  }
  echo "<script>window.close();</script>";
?>
