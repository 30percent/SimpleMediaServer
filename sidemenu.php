<table border='0' cellspacing='0'>

<?php
require_once 'meekrodb.php';
//move to meekrodb.php eventually

$categories=DB::query("SELECT name FROM category ORDER BY name DESC");
$tags=DB::query("SELECT name,count FROM populartags ORDER BY count DESC LIMIT 6"); //make view, do by popularity
$playlists=DB::query("SELECT DISTINCT playlist.pid, title FROM playlist
  INNER JOIN user on user.uid = playlist.uid
  INNER JOIN playlistcontents on playlist.pid = playlistcontents.pid
  WHERE user.username =%s", $_SESSION['logged']);
$subscriptions=DB::query("SELECT username, subid, subscription.uid
  FROM user INNER JOIN subscription on user.uid = subscription.subid
  where subscription.uid=%i", $_SESSION['loggedid']);
echo "<tr>
<td><h3>Categories</h5></td>
</tr>
<tr><td><ul>";
foreach ($categories as $cat){
  echo "<li><a href=search.php?type=category&contents=" . trim($cat['name']) . ">"
   . $cat['name'] . "</li>";
}

echo "</ul></td></tr>";
?>

<tr>
  <td><a href="search.php?type=subscription">My Subscriptions</a></td>
</tr>
<tr>
  <td>
  <ul>
    <?php
      foreach($subscriptions as $row){
        echo "<li><a href='search.php?user=" . trim($row['username']) . "'>" . $row['username'] . "</a>";
        echo " <br /> &nbsp &nbsp<a target='_blank' href='remsub.php?channel=" . $row['subid'] . "'>Unsubscribe</a></li>";
      }
    ?>
  </ul>
</td>
</tr>
<tr>
  <td>
  <?php
    echo '<a href="search.php?type=user&contents=' . trim($_SESSION['logged']) . '">';
  ?>My Channel</a></td>
</tr>
<tr>
  <td><ul><li><a href="upload.php">Upload Media</php></li></ul></td>
</tr>

<?php
echo '<tr><td><h3>Popular Tags</h3></td></tr>';
echo '
<tr><td><ul>';
foreach ($tags as $tag){
  $name = trim($tag['name']);
  echo "<li><a href=search.php?type=tag&contents=" . $name . ">"
   . $name . "</li>";
}
echo "</ul></td></tr>";
?>

<?php
echo'<tr><td><h3>My Playlists</h3></td></tr>';
echo'
<tr><td><ul>';
foreach ($playlists as $list){
  echo "<li><a href=player.php?playlist=" . $list['pid'] . ">" . $list['title']
    . "</li>";
}
echo "</ul></td></tr>";
?>

</table>
