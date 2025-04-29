<?php



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once __DIR__.'/vendor/autoload.php';


$datas = [];
$errors = [];


if($_SERVER['REQUEST_METHOD'] === 'POST')
{

  $fname             = $_POST['fname'] ?? '';
  $lname             = $_POST['lname'] ?? '';
  $loc               = $_POST['location'] ?? '';

  $jobs              = $_POST['job'] ?? '';

  $email           = $_POST['email'] ?? '';
  $contact           = $_POST['contact'] ?? '';
  $delivery          = $_POST['delivery'] ?? '';
  $description       = $_POST['job_description'] ?? '';


  if(empty($fname) && empty($lname) && empty($loc) && empty($contact) && empty($delivery) && empty($description))
  {

    $errors[] = 'Please Fill the Form.'; 
    //exit;   
    //return false;
  }
  else{
      
    $datas = [
      "First name"            => $fname,
      "Last name"             => $lname,
      "Location"              => $loc,
      "Contact"               => $contact,
      "Email"                 => $email,
      "Date to be Delivered"  => $delivery,
      "Job Description"       => $description
      ];
      
      if(empty($jobs))
      {
        $errors[] = 'Please Select a Job';
        //return false;
          
      }
      elseif(!empty($jobs)){
        $job = implode(", " , $jobs);
        $datas['Jobs'] = $job;            
    }
    
    $datas = json_encode($datas);
    
    
    $mailheader   =  $email;
    $to           = "somotechconsult@gmail.com";
    $subject      = "Somotech";
    $message      = $datas;
    
    
  
    
    try{
    $mail = new PHPMailer(true);
      
    $mail->SMTPDebug = 2;
    $mail->isSMTP();

    $mail->Host = 'smtp-relay.brevo.com';
    $mail->Hostname = 'smtp-relay.brevo.com';

    $mail->Port = 587;
    $mail->Username ='tiossdav@gmail.com';
    $mail->Password = 'h0WFRsCmtBDL4wzy';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';


    
    $mail->setFrom($mailheader);
    $mail->addAddress($to);
    
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->AltBody = $mailheader;
    $mail->Body    = $message;
    $mail->send();
    echo "Mail has been sent successfully";
    header('Location: contact.html');


    }catch(Exception $e){
        echo "Message could not be sent. Mailer Error: ($mail->ErrorInfo)";
    }

  }

  

}

?>