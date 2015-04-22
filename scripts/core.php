<?php

if(!isset($_SESSION)){session_start();}
require_once 'meekrodb.php';

//move to meekrodb.php eventually
DB::$user = 'metube_vcgu';
DB::$password = 'h3ll0pass';
DB::$dbName = 'metube_u4an';
DB::$host = 'mysql1.cs.clemson.edu';
DB::$port = 3306;

function check_logged(){

  global $_SESSION, $USERS, $LASTPAGE, $logged;

  if(!(array_key_exists('logged', $_SESSION)) || $_SESSION['logged'] == "") {
    header("Location: login.php");
  }
  else{
    $logged = $_SESSION['logged'];
		echo '<div class="nospace"><form action="login.php" method="post" target="_top"><input type="hidden" name="ac" value="logout"> ';
		echo '<input type="submit" value="Logout" />';
		echo '</form></div>&nbsp &nbsp &nbsp &nbsp <div class="nospace">';
    echo '<a href="messages.php">Check Messages</a> &nbsp &nbsp <a href="sendmessage.php">Send Message</a></div>';
    echo "&nbsp &nbsp &nbspYou are logged in as <b>";
		echo $_SESSION['logged']; //// if user is logged show a message
		echo "</b>.";
    echo "<form action='search.php' method='get'>";
    echo "<input type='text' name='contents' placeholder='Search tags' required>";
    echo "<input type='hidden' name='type' value='tag'>";
    echo "<input type='submit' value='Search'>";
    echo "</form>";
	}

}

function simpleHeader(){
  echo "<link rel='stylesheet' type='text/css' href='style/style.css' />
  	<!-- Add jQuery library -->
  	<script type='text/javascript' src='fancybox/lib/jquery-1.10.1.min.js'></script>";
}

function fancyHeader(){
  simpleHeader();
  echo "<!-- Add fancyBox main JS and CSS files -->
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
?>
