<?php
// Include PHPMailer classes
require 'vendor/PHPMailer-master/src/PHPMailer.php';
require 'vendor/PHPMailer-master/src/SMTP.php';
require 'vendor/PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve email from POST data
    $email = $_POST['email'];

    // Validate email (you might want to use more advanced validation methods)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit;
    }

    // Generate a random token
    $token = bin2hex(random_bytes(32));

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.mailtrap.io';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'ee2e74a93f13a7'; // Mailtrap SMTP username
        $mail->Password   = '98fc0e5001879c'; // Mailtrap SMTP password
        $mail->Port       = 2525;

        //Recipients
        $mail->setFrom('from@example.com', 'Your Name'); // Replace with sender email and name
        $mail->addAddress($email); // Add a recipient

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Password Reset';
        $mail->Body    = "Click the following link to reset your password: http://homepage.test/userdashboard/change_password.html";

        $mail->send();
        echo "Password reset link sent to your email.";
    } catch (Exception $e) {
        echo "Failed to send password reset link. Error: {$mail->ErrorInfo}";
    }
}
?>
