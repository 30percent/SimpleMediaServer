<?php

require_once 'scripts/core.php';

$unread = DB::query("SELECT meid, mailbox.uid, suid, user.username, title, date_sent, message, unread
FROM mailbox
inner join user on mailbox.suid = user.uid where mailbox.uid=%i and unread=1", $_SESSION["loggedid"]);
$read = DB::query("SELECT meid, mailbox.uid, suid, user.username, title, date_sent, message, unread
FROM mailbox
inner join user on mailbox.suid = user.uid where mailbox.uid=%i and unread=0", $_SESSION["loggedid"]);
echo '<h2>Unread Messages</h2>';
echo '<table><tr><th>Title</th><th>Sender</th></tr>';
foreach($unread as $message){
  echo '<tr><td><a href="readmess.php?meid=' . $message['meid'] .'">' . $message['title'] . '</a></td>
  <td>' . $message['username'] . '</td></tr>';
}
echo '</table><h2>Read Messages</h2>';
echo '<table><tr><th>Title</th><th>Sender</th></tr>';
foreach($read as $message){
  echo '<tr><td><a href="readmess.php?meid=' . $message['meid'] .'">' . $message['title'] . '</a></td>
  <td>' . $message['username'] . '</td.</tr>';
}
?>
