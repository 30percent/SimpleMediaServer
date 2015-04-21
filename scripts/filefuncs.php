<?php
  function retAppendedFile($target_dir, $target_file){
    $orig = pathinfo($target_dir . $target_file, PATHINFO_FILENAME);
    $ext = pathinfo($target_dir . $target_file, PATHINFO_EXTENSION);
    $retfile = $target_dir . $orig . "." . $ext;
    $iter = 0;
    while(file_exists($retfile)){
      $retfile = $orig . strval($iter) . "." . $ext;
      $iter++;
    }
    return $retfile;
  }

  function retFileType($file){
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimetype = finfo_file($finfo, $file);
    $type = "ERROR";
    if(strpos($mimetype, "image") !== false){
      $type = "image";
    } else if(strpos($mimetype, "audio") !== false){
      $type = "audio";
    } else if(strpos($mimetype, "video") !== false){
      $type = "video";
    } else {
      $type = "ERROR";
    }
    return $type;
  }
?>
