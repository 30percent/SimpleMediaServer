<html>
  <head>
    <?php
    require_once 'scripts/core.php';
    ?>
  </head>
  <body>
    <form action='ajax/addmedia.php' method='post' target='_blank' enctype="multipart/form-data">
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
  </body>
</html>
