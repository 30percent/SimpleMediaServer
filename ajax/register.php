<?php
  require_once '../scripts/core.php';
  if(array_key_exists("ac", $_POST)){
    $uname = $_POST["username"];
    $upass = $_POST["password"];
    $result = DB::query("SELECT uid FROM user WHERE username=%s", $uname);
    if(DB::count() > 0){
      echo '<script>alert("I\'m sorry, that username is already taken.");</script>';
      echo "<script>window.close();</script>";
    }
    else{
      DB::insert("user", array(
        'username' => $uname,
        'password' => $upass
      ));
      $_POST['ac'] = 'log';
        echo '<script>alert("Username successfully registered.");</script>';
      echo "<script>window.close();</script>";
    }
  }
?>
