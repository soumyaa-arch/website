<?php
// Basic PHP mail handler. On many shared hosts mail() works; on local dev you may need mail server or use SMTP library (PHPMailer).
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));

    if (!$name || !$email || !$message) {
        header('Location: contact.html?status=error');
        exit;
    }

    $to = 'your-email@example.com'; // CHANGE to your email
    $subject = "New contact from website: $name";
    $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
    $headers = "From: webmaster@" . ($_SERVER['HTTP_HOST'] ?? 'localhost') . "\r\nReply-To: $email";

    if (mail($to, $subject, $body, $headers)) {
        header('Location: contact.html?status=ok');
    } else {
        header('Location: contact.html?status=fail');
    }
    exit;
}
?>
