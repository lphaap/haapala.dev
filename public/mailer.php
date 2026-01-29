<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require __DIR__ . "/config.php";
require "vendor/autoload.php";

// Gmail SMTP Configuration
$smtp_username = SMTP_USERNAME; // Your Gmail address
$smtp_password = SMTP_PASSWORD; // Gmail App Password (16 characters)
$recipient = "lassi@haapala.dev"; // Where to receive emails

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $name = str_replace(["\r", "\n"], [" ", " "], $name);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = trim($_POST["subject"]);
    $message = trim($_POST["message"]);
    $phone = trim($_POST["phone"]);

    if (
        empty($name) ||
        empty($message) ||
        !filter_var($email, FILTER_VALIDATE_EMAIL)
    ) {
        http_response_code(400);
        echo "Please complete all required fields with valid information.";
        exit();
    }

    if (empty($subject)) {
        $subject = "Contact Form Submission";
    }

    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = $smtp_username;
        $mail->Password = $smtp_password;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email content
        $mail->setFrom($smtp_username, "haapala.dev");
        $mail->addAddress($recipient);
        $mail->addReplyTo($email, $name);

        $mail->isHTML(false);
        $mail->Subject = "New contact from $name: $subject";
        $mail->Body =
            "Name: $name\n" .
            "Email: $email\n" .
            "Phone: $phone\n" .
            "Subject: $subject\n\n" .
            "Message:\n$message\n";

        $mail->send();
        http_response_code(200);
        echo "Thank you! Your message has been sent.";
    } catch (Exception $e) {
        http_response_code(500);
        echo "Sorry, something went wrong. Please try again later.";
        // Uncomment for debugging: 
    }
} else {
    http_response_code(403);
    echo "Invalid request method.";
}
?>
