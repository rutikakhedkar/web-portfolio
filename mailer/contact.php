<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST['name'])    &&
	isset($_POST['email'])    &&
    isset($_POST['message'])) {
	
	$name = $_POST['name'];
	$email = $_POST['email'];
	$message = $_POST['message'];
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    	$em = "Invalid email format";
    	header("Location: ../index.php?error=$em");
    }

    if (empty($name) || empty($message) ) {
    	$em = "Fill out all required entry fields";
    	header("Location: ../index.php?error=$em");
    }

	//Create an instance; passing `true` enables exceptions
	$mail = new PHPMailer(true);

	try {
	    $mail->isSMTP();                               
	    $mail->Host = 'smtp.gmail.com'; 
	    $mail->SMTPAuth   = true;
	    //Your Email
	    $mail->Username= 'rutikakhadekar@gmail.com';
	    //App password
	    $mail->Password = 'kawk xglt nfse qotq'; 
	    $mail->SMTPSecure = "ssl";          
	    $mail->Port       = 465;                                  
	    //Recipients
	    $mail->setFrom($email, $name);   
	    // your Email
	    $mail->addAddress('rutikakhadekar@gmail.com'); 

	    //Content
	    $mail->isHTML(true);                             
	    $mail->Subject = $name;
	    $mail->Body    = "
	           <h3>Contact Form</h3>
			   <p><strong>Name</strong>: $name</p>
			   <p><strong>Email</strong>: $email</p>
			   <p><strong>Message</strong>: $message</p>
	                     ";
	    $mail->send();
	    $sm= 'Message has been sent';
    	header("Location: ../index.php?success=$sm");
	} catch (Exception $e) {
	    $em = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    	header("Location: ../index.php?error=$em");
	}

}