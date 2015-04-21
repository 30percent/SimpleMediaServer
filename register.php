<?php
  require_once 'meekrodb.php';
  require_once 'logged.php';
  if(array_key_exists("ac", $_POST)){
    $uname = $_POST["username"];
    $upass = $_POST["password"];
    $result = DB::query("SELECT uid FROM user WHERE username=%s", $uname);
    if(DB::count() > 0){
      echo 'I\'m sorry, that username is already taken.';
      require 'login.php';
    }
    else{
      DB::insert("user", array(
        'username' => $uname,
        'password' => $upass
      ));
      $_POST['ac'] = 'log';
      require 'login.php';
    }
  }
?>
