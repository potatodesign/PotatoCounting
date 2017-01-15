<?php
  include("PHPMailer/PHPMailerAutoload.php"); // inclusione della classe PHPMailer
  // controllo che sia stato cliccato il submit
  if(isset($_POST['submit'])) {
    $boundary = uniqid('np');
    // setto il mittente della mail
    $from = $_POST['email'];
    $name = $_POST['name'];
    $message = $_POST['message'];
    // setto il destinatario
    $to = 'noreply@potatodesign.it';
    // l'oggetto
    $subject = 'Email signup '. $from;
    $subjectConf = 'Welcome to Potato Design';
    
    // ed il corpo
    $body = file_get_contents("email_template/response.html");
    
    // Set content-type header for sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";

    // Additional headers
    $headers .= 'From: ' . $from . "\r\n";
    $headers .= 'Reply-To: ' . $from . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    
    // controllo se nn è stato inserito un valore per la email
    if(!$_POST['email'] || !$_POST['name']) {
      // setto il messaggio errore
      $emailError = '<script> toastMessage("<i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\"></i> &nbsp;Please enter a valid email address and Full name", "error"); </script>';
    }
    
    // se invece nn ci sono errori
    if (!$emailError) {
      $email_content = "Name: $name\n";
      $email_content .= "Email: $from\n\n";
      $email_content .= "Message:\n$message\n";
      // se va a buon fine l'invio email
      if(mail ($to, $subject, $email_content, $headers)) {
        // do messaggio di successo
        $result = '<script> toastMessage("<i class=\"fa fa-check\" aria-hidden=\"true\"></i> &nbsp;thank you we\'ll keep you updated", "success"); </script>';
        
        $mail = new PHPMailer;
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'prohosting4.netsons.net';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $to;                 // SMTP username
        $mail->Password = 'POTATO2016sp';                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to

        $mail->setFrom($to, 'Potato Design');
        $mail->addAddress($from, $name);     // Add a recipient
        //$mail->addAddress('ellen@example.com');               // Name is optional
        $mail->addReplyTo($to, 'Potato Design');
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = $subjectConf;
        $mail->Body    = $body;
        $mail->AltBody = "HELLO!\nWelcome in our kitchen...\nOur chef is cooking new tasty dishes...\nLet us introduce you who POTATO is...\nOur recipe is made by simple and genuine ingredients:\na fullstack developer and designer,\nwe ensure a wide range of design services focused on web development and graphic design.\nPotato cannot wait to\n sprout new ideas!\nKeep following us for new flavoured recipes...\n";

        if(!$mail->send()) {
            $emailError = '<script> toastMessage("<i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\"></i> &nbsp;There is an error on the confirmation email", "error"); </script>';
        } else {
            $result = '<script> toastMessage("<i class=\"fa fa-check\" aria-hidden=\"true\"></i> &nbsp;check you email address or the spam, we have sent you a confirmation email", "success"); </script>';
        }
      /*  
       $message = "This is a MIME encoded message."; 
 
       $message .= "\r\n\r\n--" . $boundary . "\r\n";
       $message .= "Content-type: text/plain;charset=utf-8\r\n\r\n";
       $message .= "HELLO!\nWelcome in our kitchen...\nOur chef is cooking new tasty dishes...\nLet us introduce you who POTATO is...\nOur recipe is made by simple and genuine ingredients:\na fullstack developer and designer,\nwe ensure a wide range of design services focused on web development and graphic design.\nPotato cannot wait to\n sprout new ideas!\nKeep following us for new flavoured recipes...\n";

       $message .= "\r\n\r\n--" . $boundary . "\r\n";
       $message .= "Content-type: text/html;charset=utf-8\r\n\r\n";
       $message .= $body;

       $message .= "\r\n\r\n--" . $boundary . "--";
        
        // Set content-type header for sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type: multipart/alternative;boundary=" . $boundary . "\r\n";
        $headers .= 'From: ' . $to . "\r\n";
        $headers .= 'Subject: ' . $subjectConf . "\r\n";
        $headers .= 'Reply-To: ' . $to . "\r\n";
        mail ($from, $subjectConf, $message, $headers);
        */
      // se invece qualcosa nell'invio mail nn va a buon fine
      } else {
        // do il messaggio di errore
        $result = '<script> toastMessage("<i class=\"fa fa-exclamation-triangle\" aria-hidden=\"true\"></i> &nbsp;sorry there is been an error, please try again", "error"); </script>';
      }
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <link rel="apple-touch-icon" sizes="180x180" href="img/favincons/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="img/favicons/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="img/favicons/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="img/favicons/manifest.json">
    <link rel="mask-icon" href="img/favicons/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="img/favicons/favicon.ico">
    <meta name="msapplication-config" content="img/favicons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <title>Potato Design</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400" rel="stylesheet">
    <link rel="stylesheet" href="css/circles.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
  </head>
  <body>
    
    <!-- CIRCLES BACKGROUND -->
    <!-- x-small -->
    <svg class="circles circle1" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back1" attributeName="r" from="1" to="1" dur="1s" begin="0.4s" repeatCount="indefinite" fill="freeze" id="circ-anim" />
     <animate xlink:href="#back1" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0.4s" repeatCount="indefinite" fill="freeze" id="circ-anim"/>
     <circle id="back1" cx="7.2" cy="7" r="1" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="1"/>
    </svg>
    <svg class="circles circle4" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back4" attributeName="r" from="1" to="1" dur="1s" begin="0.4s" repeatCount="indefinite" fill="freeze" id="circ-anim" />
     <animate xlink:href="#back4" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0.4s" repeatCount="indefinite" fill="freeze" id="circ-anim"/>
     <circle id="back4" cx="7.2" cy="7" r="1" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="1"/>
    </svg>
    <svg class="circles circle5" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back5" attributeName="r" from="1" to="1" dur="1s" begin="0.4s" repeatCount="indefinite" fill="freeze" id="circ-anim" />
     <animate xlink:href="#back5" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0.4s" repeatCount="indefinite" fill="freeze" id="circ-anim"/>
     <circle id="back5" cx="7.2" cy="7" r="1" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="1"/>
    </svg>
    <svg class="circles circle6" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back6" attributeName="r" from="1" to="1" dur="1s" begin="0.4s" repeatCount="indefinite" fill="freeze" id="circ-anim" />
     <animate xlink:href="#back6" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0.4s" repeatCount="indefinite" fill="freeze" id="circ-anim"/>
     <circle id="back6" cx="7.2" cy="7" r="1" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="1"/>
    </svg>
    <svg class="circles circle7" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back7" attributeName="r" from="1" to="1" dur="1s" begin="0.4s" repeatCount="indefinite" fill="freeze" id="circ-anim" />
     <animate xlink:href="#back7" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0.4s" repeatCount="indefinite" fill="freeze" id="circ-anim"/>
     <circle id="back7" cx="7.2" cy="7" r="1" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="1"/>
    </svg>
    
    <!-- large -->
    <svg class="circles circle2" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back2" attributeName="r" from="4" to="4" dur="1s" begin="0s" repeatCount="indefinite" fill="freeze" id="circ-anim"/>
     <animate xlink:href="#back2" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0s" repeatCount="indefinite" fill="freeze" id="circ-anim"/>
     <circle id="back2" cx="7.2" cy="7" r="4" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="4"/>
    </svg>    
    <svg class="circles circle8" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back8" attributeName="r" from="4" to="4" dur="1s" begin="0s" repeatCount="indefinite" fill="freeze" id="circ-anim"/>
     <animate xlink:href="#back8" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0s" repeatCount="indefinite" fill="freeze" id="circ-anim"/>
     <circle id="back8" cx="7.2" cy="7" r="4" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="4"/>
    </svg>    
    <svg class="circles circle9" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back9" attributeName="r" from="4" to="4" dur="1s" begin="0s" repeatCount="indefinite" fill="freeze" id="circ-anim"/>
     <animate xlink:href="#back9" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0s" repeatCount="indefinite" fill="freeze" id="circ-anim"/>
     <circle id="back9" cx="7.2" cy="7" r="4" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="4"/>
    </svg>    
    <svg class="circles circle10" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back10" attributeName="r" from="4" to="4" dur="1s" begin="0s" repeatCount="indefinite" fill="freeze" id="circ-anim"/>
     <animate xlink:href="#back10" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0s" repeatCount="indefinite" fill="freeze" id="circ-anim"/>
     <circle id="back10" cx="7.2" cy="7" r="4" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="4"/>
    </svg>    
    <svg class="circles circle11" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back11" attributeName="r" from="4" to="4" dur="1s" begin="0s" repeatCount="indefinite" fill="freeze" id="circ-anim"/>
     <animate xlink:href="#back11" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0s" repeatCount="indefinite" fill="freeze" id="circ-anim"/>
     <circle id="back11" cx="7.2" cy="7" r="4" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="4"/>
    </svg>    
    
    <!-- small -->
    <svg class="circles circle3" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back3" attributeName="r" from="2" to="2" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze" id="circ-anim" />
     <animate xlink:href="#back3" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze"  id="circ-anim" />
     <circle id="back3" cx="7.2" cy="7" r="2" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="2"/>
    </svg>

    <svg class="circles circle12" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back12" attributeName="r" from="2" to="2" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze" id="circ-anim" />
     <animate xlink:href="#back12" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze"  id="circ-anim" />
     <circle id="back12" cx="7.2" cy="7" r="2" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="2"/>
    </svg>

    <svg class="circles circle13" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back13" attributeName="r" from="2" to="2" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze" id="circ-anim" />
     <animate xlink:href="#back13" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze"  id="circ-anim" />
     <circle id="back13" cx="7.2" cy="7" r="2" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="2"/>
    </svg>

    <svg class="circles circle14" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back14" attributeName="r" from="2" to="2" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze" id="circ-anim" />
     <animate xlink:href="#back14" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze"  id="circ-anim" />
     <circle id="back14" cx="7.2" cy="7" r="2" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="2"/>
    </svg>

    <svg class="circles circle15" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back15" attributeName="r" from="2" to="2" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze" id="circ-anim" />
     <animate xlink:href="#back15" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze"  id="circ-anim" />
     <circle id="back15" cx="7.2" cy="7" r="2" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="2"/>
    </svg>

    <svg class="circles circle16" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back16" attributeName="r" from="2" to="2" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze" id="circ-anim" />
     <animate xlink:href="#back16" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze"  id="circ-anim" />
     <circle id="back16" cx="7.2" cy="7" r="2" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="2"/>
    </svg>

    <svg class="circles circle17" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back17" attributeName="r" from="2" to="2" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze" id="circ-anim" />
     <animate xlink:href="#back17" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze"  id="circ-anim" />
     <circle id="back17" cx="7.2" cy="7" r="2" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="2"/>
    </svg>

    <svg class="circles circle18" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back18" attributeName="r" from="2" to="2" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze" id="circ-anim" />
     <animate xlink:href="#back18" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze"  id="circ-anim" />
     <circle id="back18" cx="7.2" cy="7" r="2" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="2"/>
    </svg>

    <svg class="circles circle19" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back19" attributeName="r" from="2" to="2" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze" id="circ-anim" />
     <animate xlink:href="#back19" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze"  id="circ-anim" />
     <circle id="back19" cx="7.2" cy="7" r="2" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="2"/>
    </svg>

    <!-- medium -->
    <svg class="circles circle20" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back20" attributeName="r" from="3" to="3" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze" id="circ-anim" />
     <animate xlink:href="#back20" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze"  id="circ-anim" />
     <circle id="back20" cx="7.2" cy="7" r="3" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="3"/>
    </svg>

    <svg class="circles circle21" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back21" attributeName="r" from="3" to="3" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze" id="circ-anim" />
     <animate xlink:href="#back21" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze"  id="circ-anim" />
     <circle id="back21" cx="7.2" cy="7" r="3" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="3"/>
    </svg>

    <svg class="circles circle22" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back22" attributeName="r" from="3" to="3" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze" id="circ-anim" />
     <animate xlink:href="#back22" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze"  id="circ-anim" />
     <circle id="back22" cx="7.2" cy="7" r="3" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="3"/>
    </svg>

    <svg class="circles circle23" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back23" attributeName="r" from="3" to="3" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze" id="circ-anim" />
     <animate xlink:href="#back23" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze"  id="circ-anim" />
     <circle id="back23" cx="7.2" cy="7" r="3" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="3"/>
    </svg>

    <svg class="circles circle24" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back24" attributeName="r" from="3" to="3" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze" id="circ-anim" />
     <animate xlink:href="#back24" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze"  id="circ-anim" />
     <circle id="back24" cx="7.2" cy="7" r="3" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="3"/>
    </svg>

    <svg class="circles circle25" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back25" attributeName="r" from="3" to="3" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze" id="circ-anim" />
     <animate xlink:href="#back25" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze"  id="circ-anim" />
     <circle id="back25" cx="7.2" cy="7" r="3" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="3"/>
    </svg>

    <svg class="circles circle26" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back26" attributeName="r" from="3" to="3" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze" id="circ-anim" />
     <animate xlink:href="#back26" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze"  id="circ-anim" />
     <circle id="back26" cx="7.2" cy="7" r="3" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="3"/>
    </svg>

    <svg class="circles circle27" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back27" attributeName="r" from="3" to="3" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze" id="circ-anim" />
     <animate xlink:href="#back27" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze"  id="circ-anim" />
     <circle id="back27" cx="7.2" cy="7" r="3" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="3"/>
    </svg>

    <svg class="circles circle28" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back28" attributeName="r" from="3" to="3" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze" id="circ-anim" />
     <animate xlink:href="#back28" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze"  id="circ-anim" />
     <circle id="back28" cx="7.2" cy="7" r="3" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="3"/>
    </svg>
    <svg class="circles circle29" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back29" attributeName="r" from="3" to="3" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze" id="circ-anim" />
     <animate xlink:href="#back29" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze"  id="circ-anim" />
     <circle id="back29" cx="7.2" cy="7" r="3" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="3"/>
    </svg>

    <svg class="circles circle30" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back30" attributeName="r" from="3" to="3" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze" id="circ-anim" />
     <animate xlink:href="#back30" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze"  id="circ-anim" />
     <circle id="back30" cx="7.2" cy="7" r="3" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="3"/>
    </svg>

    <svg class="circles circle31" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back31" attributeName="r" from="3" to="3" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze" id="circ-anim" />
     <animate xlink:href="#back31" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze"  id="circ-anim" />
     <circle id="back31" cx="7.2" cy="7" r="3" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="3"/>
    </svg>

    <svg class="circles circle32" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back32" attributeName="r" from="3" to="3" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze" id="circ-anim" />
     <animate xlink:href="#back32" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze"  id="circ-anim" />
     <circle id="back32" cx="7.2" cy="7" r="3" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="3"/>
    </svg>

    <svg class="circles circle33" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back33" attributeName="r" from="3" to="3" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze" id="circ-anim" />
     <animate xlink:href="#back33" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze"  id="circ-anim" />
     <circle id="back33" cx="7.2" cy="7" r="3" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="3"/>
    </svg>

    <svg class="circles circle34" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back34" attributeName="r" from="3" to="3" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze" id="circ-anim" />
     <animate xlink:href="#back34" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze"  id="circ-anim" />
     <circle id="back34" cx="7.2" cy="7" r="3" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="3"/>
    </svg>

    <svg class="circles circle35" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back35" attributeName="r" from="3" to="3" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze" id="circ-anim" />
     <animate xlink:href="#back35" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze"  id="circ-anim" />
     <circle id="back35" cx="7.2" cy="7" r="3" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="3"/>
    </svg>

    <svg class="circles circle36" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
     <animate xlink:href="#back36" attributeName="r" from="3" to="3" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze" id="circ-anim" />
     <animate xlink:href="#back36" attributeType="CSS" attributeName="opacity" from="1" to="0" dur="1s" begin="0.2s" repeatCount="indefinite" fill="freeze"  id="circ-anim" />
     <circle id="back36" cx="7.2" cy="7" r="3" stroke-width="1.5"/>
     <circle class="front" cx="7.2" cy="7" r="3"/>
    </svg>
    
    <!-- HEADER -->
    <header id="intro">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1>Potato is coming</h1>
            <h3>Are you ready for new delicious tastes?</h3>
          </div>
        </div>
      </div>
    </header>
    <!-- END HEADER -->
    
    <!-- LOGO -->
    <section id="logo">
      <div class="container text-xs-center">
        <div class="row">
          <div class="col-md-12">
            <img src="img/potato_logo.png" class="img-fluid" alt="Logo Image">
          </div>
        </div>
      </div>
    </section>
    <!-- END LOGO -->
    
    <!-- MESSAGE -->
    <section id="message">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <p>
              We are cooking hard, we'll be ready to serve in...
            </p>
          </div>
        </div>
      </div>
    </section>
    <!-- END MESSAGE -->
    
    <!-- COUNTER -->
    <section id="counter">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <span class="countdown"></span>
            <hr class="line">
          </div>
        </div>
      </div>
    </section>
    <!-- END COUNTER -->
    
    <!-- FORM -->
    <section id="form">
      <div class="container">
        <form  role="form" method="post" action="#form">
          <div class="row">
            <div class="col-md-12">
              <div class="col-md-3 offset-md-3">
                <fieldset class="form-group">
                  <input type="fullname" class="form-control form-control-md form-item" id="fullname" name="name" placeholder="Full name">
                </fieldset>
                <fieldset class="form-group">
                  <input type="email" class="form-control form-control-md form-item" id="email" name="email" placeholder="Mail address">
                </fieldset>
              </div>
              <div class="col-md-3">
                <fieldset class="form-group">
                  <textarea class="form-control form-control-md form-item" name="message" id="messageForm" placeholder="Say something" rows="3"></textarea>
                </fieldset>
              </div>
            </div>
          </div>
          <div class="row submit">
            <div class="col-md-12">
              <div class="col-md-2 offset-md-5">
                <button type="submit" class="btn btn-sm btn-submit" name="submit">SUBMIT</button>
              </div>
            </div>
          </div>        
        </form>
      </div>
    </section>
    <!-- END FORM -->
    
    <!-- SOCIAL -->
    <section id="social">
      <div class="container text-sm-center">
        <div class="row">
          <div class="col-md-12">
            <p>follow all our recipes...</p>
            <ul class="list-inline">
              <a href="https://www.facebook.com/potatodesign3/" target="_blank">
                <li class="list-inline-item"><i class="fa fa-facebook facebook" aria-hidden="true"></i></li>
              </a>
              <a href="https://www.instagram.com/potatodesign3/" target="_blank">
                <li class="list-inline-item"><i class="fa fa-instagram instagram" aria-hidden="true"></i></li>
              </a>
              <a href="https://github.com/potatodesign" target="_blank">
                <li class="list-inline-item"><i class="fa fa-github-alt github" aria-hidden="true"></i></li>
              </a>
              <a href="https://it.pinterest.com/potatodesign/" target="_blank">
                <li class="list-inline-item"><i class="fa fa-pinterest-p pinterest" aria-hidden="true"></i></li>
              </a>
              <a href="https://twitter.com/design_potato" target="_blank">
                <li class="list-inline-item"><i class="fa fa-twitter twitter" aria-hidden="true"></i></li>
              </a>              
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- END SOCIAL -->
    
    <div id="snackbar">Some text some message..</div>

    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js" integrity="sha384-XTs3FgkjiBgo8qjEjBk0tGmf3wPrWtA6coPfQDfFEY8AnYJwjalXCiosYRBIBZX8" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.countdown.min.js"></script>
    <script type="text/javascript" src="js/mycount.js"></script>
    <script type="text/javascript" src="js/toastMessage.js"></script>
    <?php echo $emailError;?>
    <?php echo $result;?>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-89867239-1', 'auto');
      ga('send', 'pageview');

    </script>
  </body>
</html>