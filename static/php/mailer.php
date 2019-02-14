<?php

// you need to replace your SMTP login details here
// this script is working for sending mail but not making a proper js call back yet

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

  //$mail->SMTPDebug  = 2;

  // this should catch a lot of spam bots
  $honeypot = trim($_POST["email"]);

  if(!empty($honeypot)) {
    echo "BAD ROBOT!";
    exit;
  }

  $msg = '';
  //Don't run this unless we're handling a form submission
  if (array_key_exists('email', $_POST)) {
    date_default_timezone_set('Etc/UTC');
    $mail = new PHPMailer;
    //Tell PHPMailer to use SMTP - requires a local mail server
    //Faster and safer than using mail()
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';                      // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'pb.nullzone@gmail.com';                // SMTP username
    $mail->Password = 'SSRR2019!!!!';                   // SMTP password
    $mail->SMTPSecure = 'TLS';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                     // TCP port to connect to
    //Use a fixed address in your own domain as the from address
    //**DO NOT** use the submitter's address here as it will be forgery
    //and will cause your messages to fail SPF checks
    $mail->setFrom('pb.nullzone@gmail.com', 'himu');
    //Send the message to yourself, or whoever should receive contact for submissions

    $mail->addAddress('pb.nullzone2@gmail.com','ki');
    //Put the submitter's address in a reply-to header
    //This will fail if the address provided is invalid,
    //in which case we should ignore the whole request
    if ($mail->addReplyTo($_POST['email_real'], $_POST['name'])) {
        $mail->Subject = 'PHPMailer contact form';
        //Keep it simple - don't use HTML
        $mail->isHTML(false);
        //Build a simple message body
        $mail->Body = <<<EOT
Email: {$_POST['email_real']}
Name: {$_POST['name']}
Message: {$_POST['message']}
EOT;
        //Send the message, check for errors
        if (!$mail->send()) {
            //The reason for failing to send will be in $mail->ErrorInfo
            //but you shouldn't display errors to users - process the error, log it on your server.
            $msg = 'Sorry, something went wrong. Please try again later.';
        } else {
            $msg = 'sent';
        }
    } else {
        $msg = 'Invalid email address, message ignored.';
    }

  echo $msg;
  return $msg;
  //exit;
  }




?>
