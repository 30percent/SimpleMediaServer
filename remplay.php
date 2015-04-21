<?php
  require_once "meekrodb.php";
  require_once "logged.php";
  print_r($_POST);

  DB::delete('playlistcontents', 'pid=%i and mid=%i', $_POST['playlist'], $_POST['video']);

  echo "<script>window.close();</script>";
?>
