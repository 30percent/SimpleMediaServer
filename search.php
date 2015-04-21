<html>
<head>
  <?php
    require_once 'scripts/core.php';
    fancyHeader();
    require_once 'scripts/searchfunc.php';
  ?>

</head>
<body>
<?php
  if(isset($_GET['type']))
    $type = $_GET['type'];
  if(isset($_GET['contents']))
    $contents = $_GET['contents'];
  else
    $contents = "";
  $results = getMediaSearchResults($type, $contents);

  if($results === ""){
    echo "<p>There was an error in the search. Please go back to previous page and
      try again.</p>";
  } else{
    createSearchTable($results);
  }
?>
</body>
</html>
