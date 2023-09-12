<?php
session_start();
    
  include("connection.php");
  include("functions.php");
  include("inc/query.inc.php");

  $user_data = check_login($con);
  if(isset($user_data))
  {
    $fromname ="Contact Team - ANILLO Worldwide";
    $fromemail = 'contact@anilloworldwide.org';
    $separator = md5(time());
    $eol = "\r\n";
    // main header (multipart mandatory)
    $headers = "From: ".$fromname." <".$fromemail.">" . $eol;
    $headers .= "MIME-Version: 1.0" . $eol;
    $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
    $headers .= "Content-Transfer-Encoding: 7bit" . $eol;
    $headers .= "This is a MIME encoded message." . $eol;

    $mailto = $user_data['email'];
    $message = "Hello ". $user_name .", \r\n We are sorry to hear that you have deleted your account permanently. However, you can come back anytime!\r\n \r\n - TEAM ANILLO WORLDWIDE.";
    $body2 = "--" . $separator . $eol;
    $body2 .= "Content-Type: text/plain; charset=\"iso-8859-1\"" . $eol;
    $body2 .= "Content-Transfer-Encoding: 8bit" . $eol;
    $body2 .= $message . $eol;
    $subject = "ACCOUNT PERMANENTLY DELETED";

    if(mail($mailto, $subject, $body2, $headers)) {
      $username = $user_data['user_name'];
      $usertutor = $user_data['tid'];
      $query = "delete from users where user_id='". $user_data['user_id'] ."'";
      $result = $con->query($query);
      if($result) {
        $query2 = "delete from tutors where id='$usertutor'";
        $result2 = $con->query($query2);
        header("Location: ../");
        die;
      }
    } else {
      echo "COULD NOT COMPLETE ACCOUNT DELETION - SYSTEM ERROR, CONTACT OUR TEAM AT support.team@anilloworldwide.org";
      die;
    }
  } else if(!isset($user_data)) {
    http_response_code(404);
    die;
  }