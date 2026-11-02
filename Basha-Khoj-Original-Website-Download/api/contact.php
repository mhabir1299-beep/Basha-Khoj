<?php
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); echo json_encode(['ok'=>false,'error'=>'Method not allowed']); exit; }
$name=trim($_POST['name']??''); $email=trim($_POST['email']??''); $phone=trim($_POST['phone']??''); $message=trim($_POST['message']??''); $honeypot=trim($_POST['website']??'');
if ($honeypot!=='') { echo json_encode(['ok'=>true]); exit; }
if ($name==='' || !filter_var($email,FILTER_VALIDATE_EMAIL) || $message==='') { http_response_code(422); echo json_encode(['ok'=>false,'error'=>'Please provide a valid name, email and message.']); exit; }
/*
Configure SMTP separately. Recommended production approach:
1) Install PHPMailer on the server if your Hostinger plan supports Composer, OR upload the PHPMailer library manually.
2) Keep SMTP credentials OUT of this file. Store them in a server-side config/env file not committed to the public web root.
3) Set HOSTINGER_SMTP_HOST, HOSTINGER_SMTP_PORT, HOSTINGER_SMTP_USER and HOSTINGER_SMTP_PASS in that private config.
4) Send the sanitized message to your Basha Khoj support mailbox.
*/
$to='YOUR_SUPPORT_EMAIL@example.com'; // Replace with your business mailbox after deployment.
$subject='New Basha Khoj enquiry';
$body="Name: $name\nEmail: $email\nPhone: $phone\n\n$message";
$headers="From: $email\r\nReply-To: $email\r\nContent-Type: text/plain; charset=UTF-8";
$sent=@mail($to,$subject,$body,$headers);
if(!$sent){http_response_code(500);echo json_encode(['ok'=>false,'error'=>'Message could not be sent. Configure SMTP/mail transport on the server.']);exit;}
echo json_encode(['ok'=>true]);
?>