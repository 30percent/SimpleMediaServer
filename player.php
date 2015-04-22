<html>
<head>
  <?php
    require_once 'scripts/core.php';
    require_once 'scripts/playerfunc.php';
    ?>
    <link rel='stylesheet' type='text/css' href='style/style.css' />
    <script type='text/javascript' src='fancybox/lib/jquery-1.10.1.min.js'></script>
  <script src='http://jwpsrv.com/library/asH1yObUEeS51xJtO5t17w.js'></script>
  <script>
  function settopid(id){
    document.getElementById("mainid").value = id;
  }
  function settotop(){
    var t = document.getElementById("mainid").value;
    setvideoid(t);
  }
  function setvideoid(id){
    if(document.getElementById("hiddenvideofield") != null){
      document.getElementById("hiddenvideofield").value = id;
    }
    if(document.getElementById("hiddenvideofield2") != null){
      document.getElementById("hiddenvideofield2").value = id;
    }
    if(document.getElementById("hiddenvideofield3") != null){
      document.getElementById("hiddenvideofield3").value = id;
    }
    if(document.getElementById("formvideoid") != null){
      document.getElementById("formvideoid").value = id;
    }
  }
  function editPage(item){
    var title = document.getElementById("divtit");
    var dateE = document.getElementById("divdate");
    var descE = document.getElementById("divdesc");
    var dlE = document.getElementById("divdl");
    var com = document.getElementById("divcom1");
    console.log(dateE);
    dateE.innerHTML  = item.myDate;
    if(item.myType == "image"){
      dlE.href = item.image;
    } else{
      dlE.href = item.file;
    }
    title.innerHTML = item.title;
    descE.innerHTML  = item.description;
    var string = "";
    item.myComments.forEach(function(entry) {
      string += "<tr><td><h4><b>" + entry.user + "</b> on " + entry.date + "</h4>";
      string += "<p>" + entry.message + "</p></td></tr>";
    });
    com.innerHTML = string;
  }
  /*$(function() {
    $("table.invert").each(function () {
        var $this = $(this);
        var newrows = [];
        $this.find("tr").each(function () {
            var i = 0;
            $(this).find("td,th").each(function () {
                i++;
                if (newrows[i] === undefined) {
                    newrows[i] = $("<tr></tr>");
                }
                newrows[i].append($(this));
            });
        });
        $this.find("tr").remove();
        $.each(newrows, function () {
            $this.append(this);
        });
    });

    return false;
  });*/
  $(function() {
      $(".button#myForm").click(function() {
        // validate and process form here
        $('.error').hide();

        var video = $("input#formvideoid").val();
    		if (video == "") {
          return false;
        }
        var comment = $("textarea#comment").val();
    		if (comment == "") {
          $("label#comment_error").show();
          $("textarea#comment").focus();
          return false;
        }
        var dataString = 'comment=' + comment + '&video=' + video;
        //alert (dataString);return false;
        $.ajax({
          type: "POST",
          url: "ajax/sentcomm.php",
          data: dataString,
          success: function(html) {
            alert(html);
            $("comment#message").val("");
          }
        });
        return false;
      });
    });
  </script>
</head>
<body>
  <input type="hidden" id="mainid" value=-1>
<?php

if(isset($_GET['id'])){
  $id = $_GET['id'];
  $results = getMediaResults('id', $id);
  $count = DB::count();
  $title = $results[0]['media.title'];
}
if(isset($_GET['playlist'])){
  $playlist = $_GET['playlist'];
  $results = getMediaResults('playlist', $playlist);
  $title=$results[0]['playlist.title'];
}
if(isset($_SESSION["loggedid"])){
  $myPlaylists = getPlaylists($_SESSION["loggedid"]);
}
echo "<table><tr><td>";
if(isset($playlist)){
  displayPlaylist($results);
} else{
  displayMedia($results[0]);
}
echo "</td></tr><tr><td>";
if(isset($myPlaylists)){
  echo "<table><tr><td class='border'><form id='addPlay' action='ajax/addplay.php' target='_blank' method='post'>
    <select name='playlist' required>";
      foreach($myPlaylists as $row){
        echo "<option value='" . $row['pid'] . "'>" . $row['title'] . "</option>";
      }
  echo '</select>
  <input type="hidden" name="video" id="hiddenvideofield" value=1000>
  <input type="submit" value="Add to Playlist" /> </form></td>';
} else{
  echo '<input type="hidden" name="video" id="hiddenvideofield" value=1000>';
}
if(isset($playlist)){
    echo '<td class="border"><form id="remPlay" action="ajax/remplay.php" target="_blank" method ="post">
    <input type="hidden" name="video" id="hiddenvideofield3" value=1000>
    <input type="hidden" name="playlist" value=' . $playlist .'>
    <input type="submit" value="Remove From: ' . $title . '" /></form></td>';
}
?>

<td class='border'><form id='newPlay' action='ajax/newplay.php' target='_blank' method='post'>
  <b>Create New Playlist: </b><br /><input type='text' name='listname' required/>
  <input type="hidden" name="video" id="hiddenvideofield2" value=1000>
  <input type="submit" value="Add to New Playlist" />
</form></td></tr></table>
</td></td></table>
<div id="playerhider" >
  <div id="myElement"></div>
</div>
<h3><div class="nospace" id="divtit"></div></h4>
<p>
  <div class="nospace"><b>uploaded on:</b></div> <div class="nospace" id='divdate'> </div>
  &nbsp &nbsp &nbspDownload Link: <a id='divdl' href="#">Click Here</a>
</p>
<p>
  <b>Description: </b> <div class="nospace" id="divdesc"> </div>
</p>
<p>
  <b>Comments: </b>
    <div id="commentform">
    <table class="invert">
      <thead>
      <form name="comment" action='' method='post'>
          <tr><td> <input type='hidden' name='video' value=1000 id='formvideoid'>
            <textarea id='comment' name='comment' rows=6 cols=60 placehold="Leave a comment!"></textarea>
            <label class="error" for="name" id="comment_error" style="display: none;">Please include a message</label>
          </td></tr>
          <tr><td><button id="myForm" class="button" type="submit">Confirm</button>
          </td></tr>
        </form> </thead>
          <tbody id="divcom1"></tbody>
    </div>
</table>


</p>
<script>
  settotop();
</script>

</body>
</html>
