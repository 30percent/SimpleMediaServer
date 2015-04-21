<html>
<head>
<link rel="stylesheet" type="type/css" href="style/style.css" />
  <base target="interiorframe">
</head>
<body>
  <div id="container">
    <!--container-->
      <div id="nav-menu">
        <!--top menu-->
        <?php
          require_once "logged.php";
          check_logged();
        ?>
      </div>

      <div id="content">
          <!--content-->
          <div id="sidebar">
            <?php
              require "sidemenu.php";
            ?>
          </div>
          <div id="main">
            <iframe name="interiorframe" src="search.php?type=recent" id="listframe" frameborder="0"
              marginwidth="0" marginheight="0" scrolling="yes" onload="" >
            </iframe>

          </div>
      </div>

  </div>
</body>
</html>
