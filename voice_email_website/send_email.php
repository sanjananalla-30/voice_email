<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; // Use smtp-mail.outlook.com for Outlook
    $mail->SMTPAuth   = true;
    $mail->Username   = 'sanjananalla2008@gmail.com'; // Your Gmail
    $mail->Password   = 'jupoovygpnyyxkiu';    // Use an App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Recipients
    $mail->setFrom('your-email@gmail.com', 'Voice Mailer');
    $mail->addAddress($_POST['to']);

    // Content
    $mail->isHTML(false);
    $mail->Subject = $_POST['subject'];
    $mail->Body    = $_POST['message'];

    $mail->send();
    echo "Email sent successfully.";

    // Redirect to menu page after short delay
    echo "<script>
        setTimeout(() => {
            window.location.href = 'index.html';
        }, 3000);
    </script>";

} catch (Exception $e) {
    echo "Failed to send email. Error: {$mail->ErrorInfo}";
}
?>
