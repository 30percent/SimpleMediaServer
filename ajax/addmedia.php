<?php

  require_once '../scripts/core.php';
  require_once '../scripts/filefuncs.php';

  if(array_key_exists("upload", $_POST) && !($_POST["upload"] == "no")){

    if((!empty($_FILES['mediafile'])) && ($_FILES['mediafile']['error'] == 0)){
      $target_file = basename($_FILES['mediafile']['name']);
      $target_dir = "media/" . $_SESSION['logged'] . "/";
      if(!file_exists($target_dir)){
        mkdir($target_dir, 0755);
        chmod($target_dir, 0755);
      }
      $type = retFileType($_FILES['mediafile']['tmp_name']);
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimetype = finfo_file($finfo, $_FILES['mediafile']['tmp_name']);
      $i_name = "media/default.png";
      if($type != "ERROR"){
        $target_file = retAppendedFile($target_dir, $target_file);
        if($type != "image" && isset($_FILES['thumbnail']) && file_exists($_FILES['thumbnail']['tmp_name'])){
          if(retFileType($_FILES['thumbnail']['tmp_name']) == "image"){
            $thumbFile = basename($_FILES['thumbnail']['name']);
            $thumbFile = retAppendedFile($target_dir, $thumbFile);
            if(move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $thumbFile)){
              chmod($thumbFile, 0654);

              $i_name = $thumbFile;
            }
          }
        }
        if(move_uploaded_file($_FILES["mediafile"]["tmp_name"], $target_file)){
          chmod($target_file, 0654);
          if($type == "image"){
            $i_name = $target_file;
            $target_file = "media/default.mp3";
          }
          DB::insert('media', array(
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'uid' => $_SESSION["loggedid"],
            'type' => $type,
            'cid' => $_POST["category"],
            'path' => $target_file,
            'imagepath' => $i_name
          ));
          $lastid = DB::insertId();
          if(isset($_POST["tags")){
            $tags = $_POST['tags'];
              $tagarr = explode(" ", $_POST["tags"]);
              DB::$error_handler = false;
              DB::$throw_exception_on_error = true;
              foreach ($tagarr as $tag){
                if(!ctype_space($tag) && $tag != ""){
                  try{
                  DB::insert('mediatag', array(
                    'name' => trim($tag),
                    'mid' => $lastid
                  ));
                  }catch(MeekroDBException $e) {
                    //duplicate tag
                  }
                }
              }
              DB::$error_handler = 'meekrodb_error_handler';
              DB::$throw_exception_on_error = false;
              echo "File uploaded successfully.";
          }
        } else{
          echo 'file upload error: ' . $_FILES["mediafile"]["tmp_name"] . " " . $target_file;
        }
      }
    }
    /*
    */
    $_POST["upload"] = "no";
  }

  echo "<script>window.close();</script>";

?>
