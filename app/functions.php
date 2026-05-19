<?php
require_once 'config.php';

function loadJson($file) {
    if (!file_exists($file)) return [];
    $data = json_decode(file_get_contents($file), true);
    return $data ?: [];
}

function saveJson($file, $data) {
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
}

function sanitize($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function generateInvoiceNumber() {
    $invoices = loadJson(INVOICES_FILE);
    $last = count($invoices);
    return str_pad($last + 1, 6, '0', STR_PAD_LEFT);
}

function sendConfirmationEmail($to, $subject, $body) {
    require_once 'vendor/PHPMailer/src/PHPMailer.php';
    require_once 'vendor/PHPMailer/src/SMTP.php';
    require_once 'vendor/PHPMailer/src/Exception.php';

    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->isSMTP();
    $mail->Host = SMTP_HOST;
    $mail->SMTPAuth = true;
    $mail->Username = SMTP_USERNAME;
    $mail->Password = SMTP_PASSWORD;
    $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = SMTP_PORT;

    $mail->setFrom(FROM_EMAIL, FROM_NAME);
    $mail->addAddress($to);

    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $body;

    return $mail->send();
}
?>