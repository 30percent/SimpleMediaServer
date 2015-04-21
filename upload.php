<?php
require_once 'logged.php';
require_once 'meekrodb.php';
require_once 'foos.php';

if(array_key_exists("upload", $_POST) && !($_POST["upload"] == "no")){


  if((!empty($_FILES['mediafile'])) && ($_FILES['mediafile']['error'] == 0)){
    $target_file = basename($_FILES['mediafile']['name']);
    $target_dir = "media/" . $_SESSION['logged'] . "/";
    $type = retFileType($_FILES['mediafile']['tmp_name']);
      $finfo = finfo_open(FILEINFO_MIME_TYPE);
      $mimetype = finfo_file($finfo, $_FILES['mediafile']['tmp_name']);
      echo "MIMETYPE: " . $mimetype;
    echo 'TYPE:  ' . $type . '\n';
    $i_name = "media/default.png";
    if($type != "ERROR"){
      $target_file = retAppendedFile($target_dir, $target_file);
      echo " " . $_FILES["thumbnail"]["tmp_name"] . " " . $target_file;
      if($type != "image" && isset($_FILES['thumbnail']) && file_exists($_FILES['thumbnail']['tmp_name'])){
        if(retFileType($_FILES['thumbnail']['tmp_name']) == "image"){
          $thumbFile = basename($_FILES['thumbnail']['name']);
          $thumbFile = retAppendedFile($target_dir, $thumbFile);
          if(move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $thumbFile)){
            chmod($thumbFile, 755);
            $i_name = $thumbFile;
          }
        }
      }
      if(move_uploaded_file($_FILES["mediafile"]["tmp_name"], $target_file)){
        chmod($target_file, 755);
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
        if(isset($_POST["tags"])){
          $tagarr = explode(" ", $_POST["tags"]);
          DB::$error_handler = false;
          DB::$throw_exception_on_error = true;
          foreach ($tagarr as $tag){
            try{
            DB::insert('mediatag', array(
              'name' => trim($tag),
              'mid' => $lastid
            ));
            }catch(MeekroDBException $e) {
              //duplicate tag
            }

          }
          DB::$error_handler = 'meekrodb_error_handler';
          DB::$throw_exception_on_error = false;
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

?>

<form action='upload.php' method='post' enctype="multipart/form-data">
  <input type='hidden' name='upload' value='yes'>
<table>
<tr>
  <td>Title:</td>
  <td>
<input type='text' name='title' required/></td>
</tr>
<tr>
  <td>Description: </td>
  <td><textarea name='description' rows=4 cols=60> </textarea></td>
  <td>Tags: <input type='text' name='tags'/></td>
</tr>
<tr>
  <td>Category: </td>
  <td><select name="category" required>
    <?php
      $results = DB::query("SELECT cid, name FROM category");
      foreach($results as $row){
        echo "<option value='" . $row['cid'] . "'>" . $row['name'] . "</option>";
      }
    ?>
  </select></td>
</tr>
<tr>
  <td>File to Upload:</td>
  <td><input type="file" name="mediafile" id="mediafile" required></td>
  <td>Add a Thumbnail?</td>
  <td><input type="file" name="thumbnail" id="thumbnail"></td>
</tr>
</table>
<input type='submit' />
</form>
