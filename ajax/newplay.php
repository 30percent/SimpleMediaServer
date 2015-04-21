<?php

  require_once "../scripts/core.php";

  $myID = $_SESSION["loggedid"];

  DB::insert('playlist',array(
    'uid' => $myID,
    'title' => $_POST['listname']
  ));
  $retID = DB::insertId();
  DB::insert('playlistcontents', array(
    'pid' => $retID,
    'mid' => $_POST['video']
  ));
  echo "<script>window.close();</script>";
?>
