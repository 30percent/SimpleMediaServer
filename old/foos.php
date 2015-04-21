<?php
function createSearchTable($results){
  $maxcol = 4;
  $incol = 0;
  echo '<table class="space">';
  foreach($results as $res){
    if($incol == $maxcol){
      echo '</tr><tr>';
      $incol=0;
    }
    echo '<td valign="top" class="space">';
    echo '<h3 class="center">' . $res['title'] .'</h3><h4>Upload by:
    <a href="search.php?type=user&contents=' . $res['username'] .'">' . $res['username'] . '</a></h4><hr>';
    echo '<a class="fancybox fancybox.iframe fit" href="player.php?id=' . $res['mid'] . '">';
    echo '<img class="fit" src="' . $res['imagepath'] . '" alt=Preview for ' . $res['title'] . '></img>';
    echo '</a>';
    echo '</td>';
    $incol++;
  }
}

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
  echo "MIMETYPE: " . $mimetype;
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

function headerIncludeFancy(){
  echo "<link rel='stylesheet' type='text/css' href='style/style.css' />
  	<!-- Add jQuery library -->
  	<script type='text/javascript' src='fancybox/lib/jquery-1.10.1.min.js'></script>

  	<!-- Add mousewheel plugin (this is optional) -->
  	<script type='text/javascript' src='fancybox/lib/jquery.mousewheel-3.0.6.pack.js'></script>

  	<!-- Add fancyBox main JS and CSS files -->
  	<script type='text/javascript' src='fancybox/source/jquery.fancybox.js?v=2.1.5'></script>
  	<link rel='stylesheet' type='text/css' href='fancybox/source/jquery.fancybox.css?v=2.1.5' media='screen' />

  	<!-- Add Button helper (this is optional) -->
  	<link rel='stylesheet' type='text/css' href='fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5' />
  	<script type='text/javascript' src='fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5'></script>

  	<!-- Add Thumbnail helper (this is optional) -->
  	<link rel='stylesheet' type='text/css' href='fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7' />
  	<script type='text/javascript' src='fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7'></script>

  	<!-- Add Media helper (this is optional) -->
  	<script type='text/javascript' src='fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6'></script>

  <script type='text/javascript'>
    $(document).ready(function() {
      /*
       *  Simple image gallery. Uses default settings
       */

      $('.fancybox').fancybox();

      /*
       *  Button helper. Disable animations, hide close button, change title type and content
       */

      $('.fancybox-buttons').fancybox({
        openEffect  : 'none',
        closeEffect : 'none',

        prevEffect : 'none',
        nextEffect : 'none',

        closeBtn  : false,

        helpers : {
          title : {
            type : 'inside'
          },
          buttons	: {}
        },

        afterLoad : function() {
          this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
        }
      });


      /*
       *  Thumbnail helper. Disable animations, hide close button, arrows and slide to next gallery item if clicked
       */

      $('.fancybox-thumbs').fancybox({
        prevEffect : 'none',
        nextEffect : 'none',

        closeBtn  : false,
        arrows    : false,
        nextClick : true,

        helpers : {
          thumbs : {
            width  : 50,
            height : 50
          }
        }
      });

      /*
       *  Media helper. Group items, disable animations, hide arrows, enable media and button helpers.
      */
      $('.fancybox-media')
        .attr('rel', 'media-gallery')
        .fancybox({
          openEffect : 'none',
          closeEffect : 'none',
          prevEffect : 'none',
          nextEffect : 'none',

          arrows : false,
          helpers : {
            media : {},
            buttons : {}
          }
        });


    });

  </script>
  <style type='text/css'>
    .fancybox-custom .fancybox-skin {
      box-shadow: 0 0 50px #222;
    }
  </style>";
}

function getPlaylists($userid){
  $results = DB::query("SELECT title, pid from playlist
  inner join user on user.uid = playlist.uid
  where user.uid=%i", $userid);
  return $results;

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
  require_once 'meekrodb.php';
  require_once 'logged.php';
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
  echo "<td><form id='myForm' action='subscribe.php' target='_blank' method='post'>
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
?>
