<?php

function getPlaylists($userid){
  $results = DB::query("SELECT title, pid from playlist
  inner join user on user.uid = playlist.uid
  where user.uid=%i", $userid);
  return $results;

}

function getMediaResults($type, $value){
  if($type === 'id'){
    $results = DB::queryFullColumns('SELECT mid, path, title, description, type,
      date_created, imagepath, user.uid, user.username from media
      inner join user on media.uid = user.uid
      where mid=%i', $value);
  } else if($type === 'playlist'){
    $results = DB::queryFullColumns('SELECT media.mid, media.path, media.title,
      media.description, media.type, media.date_created, media.imagepath,
      playlist.title FROM media
      inner join playlistcontents on media.mid = playlistcontents.mid
      inner join playlist on playlistcontents.pid = playlist.pid
      where playlist.pid = %i', $value);
  }
  return $results;
}
function generateEvents(){
  echo '
  player.onReady(function (event) {
    var a = player.getPlaylistItem(event.index);
    setvideoid(a.myID);
    editPage(a);
  });
  player.onPlaylistItem(function (event){
    var a = player.getPlaylistItem(event.index);
    setvideoid(a.myID);
    editPage(a);
  });';
}

function getcomments($media){
  require_once 'scripts/core.php';
  $mid = $media['media.mid'];
  $results = DB::query("SELECT message, username, date_sent FROM mediacomment
  INNER JOIN user on mediacomment.uid = user.uid where mediacomment.mid=%s
  ORDER BY date_sent DESC", $mid);
  return $results;
}

function displayMedia($result){
  echo '<h2>' . $result['media.title']. '</h2>';
  echo '<table><tr>';
  echo '<td><h4>by: <a target=_parent href="search.php?type=user&contents=' . $result['user.username'] .'"> ' . $result['user.username'] . '</a></h4></td>';
  echo "<td><form id='myForm' action='ajax/subscribe.php' target='_blank' method='post'>
    <input type='submit' value='Subscribe!' />
    <input type='hidden' name='channel' value='" . $result['user.uid'] . "'>
  </form></td>
  ";
  echo "</tr></table>";
  if($result['media.type'] == "image"){
    $thispath = $result['media.imagepath'];
    echo "<img src='" . $thispath . "' alt='" .
      $result['media.title'] . "'></img>";
    echo "<div style='display: none;'>";
  } else{
    echo "<div>";
    $thispath=$result['media.path'];
  }
    echo '<div id="myElement"></div>';

    echo '<script type="text/javascript">
        var player = jwplayer("myElement").setup({
        playlist: [';
    echo '{';
    echo 'image: "' . $result['media.imagepath'] . '",';
    echo 'file: "' . $result['media.path'] . '",';
    echo 'title: "' . $result['media.title'] . '",';
    echo 'description: "' . $result['media.description'] . '",';
    echo 'myID: "' . $result['media.mid'] . '",';
    echo 'myDate: "' . $result['media.date_created'] . '",';
    echo 'myType: "' . $result['media.type'] . '",';
    echo 'myComments: [
      ';
      $comments=getComments($result);
      $it = 0;
      foreach($comments as $row){
        if($it>0){
          echo ',';
        }
        echo '{';
        echo 'user: "' . $row['username'] . '",';
        echo 'date: "' . $row['date_sent'] . '",';
        echo 'message: "' . $row['message'] . '"}';
        $it++;
      }
    echo ']';
    echo '}], height: 400, width: 740});';
    generateEvents();
    echo 'setvideoid(' . $result['media.mid'] . ');';
    echo '</script>';
    echo '</div>';

}

function displayPlaylist($results){
  echo '<h2>Playlist: ' . $results[0]['playlist.title'] . '</h2>';
  echo '<div id="myElement"></div>';
  echo '<script>
      var player = jwplayer("myElement").setup({
      playlist: [
  ';
  $iter = 0;
  foreach($results as $res){
    if($iter > 0){
      echo ',';
    }
    echo '{';
    echo 'image: "' . $res['media.imagepath'] . '",';
    echo 'file: "' . $res['media.path'] . '",';
    echo 'title: "' . $res['media.title'] . '",';
    echo 'description: "' . $res['media.description'] . '",';
    echo 'myID: "' . $res['media.mid'] . '",';
    echo 'myDate: "' . $res['media.date_created'] . '",';
    echo 'myComments: [
      ';
      $comments=getComments($res);
      $it = 0;
      foreach($comments as $row){
        if($it>0){
          echo ',';
        }
        echo '{';
        echo 'user: "' . $row['username'] . '",';
        echo 'date: "' . $row['date_sent'] . '",';
        echo 'message: "' . $row['message'] . '"}';
        $it++;
      }
    echo ']';
    echo '}';
    $iter = $iter + 1;
  }

  echo '],
  height: 400,
  width: 740';
  echo ', listbar: {
      position: "right",
      size: 260
    }';
  echo '});';
  generateEvents();
  echo '</script>';
}

?>
