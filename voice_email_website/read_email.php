<?php
include 'imap_config.php';

$id = $_GET['id'];
$body = imap_fetchbody($inbox, $id, 2); // plain text part
echo "<h2>Email Content</h2>";
echo "<p>" . nl2br($body) . "</p>";

imap_close($inbox);
?>
