<html>
  <head>
    <?php
      require_once 'scripts/core.php';
      simpleHeader();
    ?>
    <script>
    $(function() {
        $(".button").click(function() {
          // validate and process form here
          $('.error').hide();
      	  var title = $("input#title").val();
      		if (title == "") {
            $("label#title_error").show();
            $("input#title").focus();
            return false;
          }
      		var user = $("input#user").val();
      		if (user == "") {
            $("label#user_error").show();
            $("input#user").focus();
            return false;
          }
      		var message = $("textarea#message").val();
      		if (message == "") {
            $("label#message_error").show();
            $("textarea#message").focus();
            return false;
          }
          var dataString = 'title='+ title + '&user=' + user + '&message=' + message;
          //alert (dataString);return false;
          $.ajax({
            type: "POST",
            url: "ajax/sentmess.php",
            data: dataString,
            success: function(html) {
              alert(html);
              $("input#title").val("");
              $("input#user").val("");
              $("textarea#message").val("");
            }
          });
          return false;
        });
      });
    </script>
  </head>
  <body>
    <div id="messageform">
      <form name="message" action='' method='post'>
        <table>
              <tr><td><b>Title:</b></td><td>
              <input type="text" placeholder="Title" id="title" required>
              <label class="error" for="name" id="title_error" style="display: none;">This field is required.</label></td>
              <td><b>User:</b></td>
              <td><input type="text" placeholder="User" id="user" required>
              <label class="error" for="name" id="user_error" style="display: none;">This field is required.</label></td></tr>
              <tr><td><b>Message:</b></td><td colspan=3>
              <textarea id='message' name='message' rows=12 cols=60> </textarea>
              <label class="error" for="name" id="message_error" style="display: none;">This field is required.</label></td>
            </tr>
            <tr><td></td><td>
              <button id="myForm" class="button" type="submit">Confirm</button></td></tr>
        </table>
      </form>
    </div>
  </body>
</html>
