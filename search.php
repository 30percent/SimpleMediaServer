<html>
<head>
  <!-- Add jQuery library -->
  <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
  <link rel='stylesheet' type='text/css' href='style/style.css' />
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
</style>
</head>
<body>
<?php
require_once 'logged.php';
require_once 'meekrodb.php';
require_once 'foos.php';

if(isset($_GET['type']))
  $type = $_GET['type'];
if(isset($_GET['contents']))
  $contents = $_GET['contents'];


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
} else {
  $results = DB::query('SELECT * from mediauser ORDER BY date_created LIMIT 12');
}
createSearchTable($results);
?>
</body>
</html>
