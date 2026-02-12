<?php
include 'imap_config.php';

$id = $_GET['id'];
imap_delete($inbox, $id);
imap_expunge($inbox);

echo "Email deleted.";
imap_close($inbox);
?>
