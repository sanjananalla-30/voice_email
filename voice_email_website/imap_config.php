 <?php
$hostname = '{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX';
$username = 'thanshithagurrala@gmail.com';
$password = 'jupoovygpnyyxkiu';

$inbox = imap_open($hostname, $username, $password) or die("IMAP failed");
?>
