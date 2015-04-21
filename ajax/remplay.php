<?php
  require_once "../scripts/core.php";
  print_r($_POST);

  DB::delete('playlistcontents', 'pid=%i and mid=%i', $_POST['playlist'], $_POST['video']);

  echo "<script>window.close();</script>";
?>
