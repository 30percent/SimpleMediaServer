<?php

  function getMediaSearchResults($type, $contents){
    $results = "";
    if(strcmp($type, "tag") == 0){
      $tagarr = explode(" ",$contents);
      $results = DB::query('SELECT * from mediauser
        inner join mediatag on mediatag.mid = mediauser.mid
        where mediatag.name in %ls ORDER BY date_created', $tagarr);

    } else if(strcmp($type, "category") == 0){
      $results = DB::query('SELECT * from mediauser
        inner join category on category.cid = mediauser.cid where category.name=%s ORDER BY date_created', $contents);
    } else if(strcmp($type, "user") == 0){
      $results = DB::query('SELECT * from mediauser
        where mediauser.username=%s ORDER BY date_created', $contents);
    } else if(strcmp($type, "subscription") == 0){
      $results = DB::query('SELECT * from mediauser
        inner join subscription on subscription.subid = mediauser.uid
        where subscription.uid=%i ORDER BY date_created', $_SESSION['loggedid']);
    } else if(strcmp($type, "recent") == 0){
      $results = DB::query('SELECT * from mediauser ORDER BY date_created LIMIT 12');
    }
    return $results;
  }
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
?>
