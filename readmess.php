<?php

require_once 'logged.php';
require_once 'meekrodb.php';

$results = DB::query("SELECT user.username, title, date_sent, message from
mailbox inner join user on mailbox.suid = user.uid where meid=%i", $_GET['meid']);
$result = $results[0];
echo "<h2>" . $result["title"] . "</h2>";
echo "<h4>Sent by: " . $result["username"] . " on " . $result["date_sent"]. ".</h4>";
echo "<p>" . $result["message"];

DB::update('mailbox', array(
  'unread' => 0
), 'meid=%i', $_GET['meid']);
?>
