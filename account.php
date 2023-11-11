<?php
error_reporting(0);
session_start();
  include("php/connection.php");
  include("php/functions.php");

    $email = '';
    $user_name = '';
    $password = '';
    $pattern_email = "/^\w{2,20}(?:[.-]\w+)?@\w+\.\w+(?:\.?\w+)*/";
    $pattern_name = "/^[\wÀ-ü!-\/]{1,30}/";
    $pattern_password = "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/";
    $pattern_phone = "/\(?\+[0-9]{1,3}\)? ?-?[0-9]{1,3} ?-?[0-9]{3,5} ?-?[0-9]{4}( ?-?[0-9]{3})?/";
    $create = true;
    $acc = false;
    $acc2 = false;
    $acc3 = false;
    $acc4 = false;

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      if(isset($_POST['firstname'])) {
        $user_name = $_POST['firstname'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $type = "learner";
        $refresh = false;
  
        if(!empty($user_name) && !empty($password) && !empty($email) && !is_numeric($user_name))
        {
          if(preg_match($pattern_email, $email)) {
            $str = "SELECT * FROM users WHERE email = '". $email ."'";
            $select = mysqli_query($con, $str);
            if(mysqli_num_rows($select)){
              $refresh = true;
              $acc = true;
              $create = false;
              $msg_error = "Email already in use! In case it wasn't registered, contact our support team";
            } else if (!mysqli_num_rows($select)){
              if(preg_match($pattern_name, $user_name)){
                if(strlen($user_name) <= 30){
                  if($password !== $_POST['cpassword']) {
                    $refresh = true;
                    $acc = true;
                    $create = false;
                    $msg_error = "The password has to be the same in both fields!";
                  } else if ($password === $_POST['cpassword']) {
                    if(preg_match($pattern_password, $password)){
                      if(preg_match($pattern_phone, $_POST['number'])) {
                        $user_id = random_num(20);
                        $imageid = random_num(20);
                        $psw_length = strlen($password);
                        $hashed_pwd = password_hash($password, PASSWORD_DEFAULT);
                        $phone = $_POST['number'];
                        $gender = $_POST['gender'];

                        $profileimg = $_FILES['myprofile']['name'];
				                $extension = pathinfo( $_FILES["myprofile"]["name"], PATHINFO_EXTENSION );
				                $newname = 'I' . $imageid . 'U' . $user_id . "." . $extension;
				                $file_tmp_name = $_FILES['myprofile']['tmp_name'];
				                $img_url = "tmp/tutors/".$newname;

                        $fromname ="ANILLOWorldwide";
                        $fromemail = 'apply@anilloworldwide.org';
                        $separator = md5(time());
                        $eol = "\r\n";
                        // main header (multipart mandatory)
                        $headers = "From: ".$fromname." <".$fromemail.">" . $eol;
                        $headers .= "MIME-Version: 1.0" . $eol;
                        $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
                        // $headers .= "Content-Transfer-Encoding: 7bit" . $eol;
                        // $headers .= "This is a MIME encoded message." . $eol;

                        $mailto = $email;
                        $message = "Hello ". $user_name .", \r\n Welcome to ANILLO Worldwide. We are happy to have you here! Your student account was successfully created. \r\n \r\n TEAM ANILLO WORLDWIDE.";
                        $body2 = "--" . $separator . $eol;
                        // $body2 .= "Content-Type: text/plain; charset=\"iso-8859-1\"" . $eol;
                        // $body2 .= "Content-Transfer-Encoding: 8bit" . $eol;
                        $body2 .= $message . $eol;
                        $subject = "ACCOUNT CREATED - ANILLO Worldwide";

                        if(mail($mailto, $subject, $body2, $headers)) {
                          if(move_uploaded_file($file_tmp_name,$img_url)) {
                            // save to database
                            $query = "insert into users (user_id,user_name,email,password,user_psw_length,phone,gender,type,availability) values('$user_id','$user_name','$email','$hashed_pwd','$psw_length', '$phone', '$gender','$type', '$availability')";
                            mysqli_query($con, $query);

                            $query3 = "insert into images (img_id,user,url,userfor) values('$imageid','$user_id','$img_url','profile')";
                            mysqli_query($con, $query3);

                            $_SESSION['user_id'] = $user_id;
                            header("Location: /");
                            die;
                          } else {
                            $refresh = true;
                            $acc2 = true;
                            $create = false;
                            $msg_error = "Could not send email, possible reasons: unexisting email, system FAIL. ACCOUNT NOT CREATED";
                          }
                        } else {
                          $refresh = true;
                          $acc2 = true;
                          $create = false;
                          $msg_error = "Could not send email, possible reasons: unexisting email, system FAIL";
                        }
                      } else {
                        $refresh = true;
                        $acc = true;
                        $create = false;
                        $msg_error = "This is an invalid phone number format, please input following one of these formats: (+XX/XXX) XX XXXXX-XXXX, (+XX/XXX)-XX-XXXXX-XXXX or (+XX/XXX)XXXXXXXXX";
                      }
                    } else if(!preg_match($pattern_password, $password)) {
                      $refresh = true;
                      $acc = true;
                      $create = false;
                      $msg_error = "The password needs to contain at least a capital letter, 8 characters, one special character, and a number!";
                    }
                  }
                } else if (strlen($user_name) > 10) {
                  $refresh = true;
                  $acc = true;
                  $create = false;
                  $msg_error = "Username is too long (max-chars: 30).";
                }
              } else if (!preg_match($pattern_name, $user_name)) {
                $msg_error = "Invalid username!";
                $refresh = true;
                $create = false;
                $acc = true;
              }
            }
          } else if(!preg_match($pattern_email, $email)) {
            $refresh = true;
            $acc = true;
            $create = false;
            $msg_error = "Please, type a valid email!";
          }
        }else
        {
          $msg_error = "Please, type valid information!";
        }
      }
      else if(isset($_POST['firstnametwo'])) {
        $user_name = $_POST['firstnametwo'];
        $password = $_POST['passwordtwo'];
        $email = $_POST['emailtwo'];
        $type = "tutor";
        $refresh = false;
  
        if(!empty($user_name) && !empty($password) && !empty($email) && !is_numeric($user_name))
        {
          if(preg_match($pattern_email, $email)) {
            $str = "SELECT * FROM users WHERE email = '". $email ."'";
            $select = mysqli_query($con, $str);
            if(mysqli_num_rows($select)){
              $refresh = true;
              $acc2 = true;
              $create = false;
              $msg_error = "Email already in use! In case it wasn't registered, contact our support team";
            } else if (!mysqli_num_rows($select)){
              if(preg_match($pattern_name, $user_name)){
                if(strlen($user_name) <= 30){
                  if($password !== $_POST['cpasswordtwo']) {
                    $refresh = true;
                    $acc2 = true;
                    $create = false;
                    $msg_error = "The password has to be the same in both fields!";
                  } else if ($password === $_POST['cpasswordtwo']) {
                    if(preg_match($pattern_password, $password)){
                      if(preg_match($pattern_phone, $_POST['numbertwo'])) {
                        $user_id = random_num(20);
                        $tid = random_num(20);
                        $imageid = random_num(20);
                        $psw_length = strlen($password);
                        $hashed_pwd = password_hash($password, PASSWORD_DEFAULT);
                        $phone = $_POST['numbertwo'];
                        $gender = $_POST['gendertwo'];
                        $availability = $_POST['availability'];

                        $profileimg = $_FILES['myprofiletwo']['name'];
                        $extension = pathinfo( $_FILES["myprofiletwo"]["name"], PATHINFO_EXTENSION );
                        $newname = 'I' . $imageid . 'U' . $user_id . "." . $extension;
                        $file_tmp_name = $_FILES['myprofiletwo']['tmp_name'];
                        $img_url = "tmp/tutors/".$newname;

                        $filenameee =  $_FILES['filename']['name'];
                        $fileName = $_FILES['filename']['tmp_name'];
                        $skills = $_POST['skills'];
      
                        $message ="Name = ". $user_name . "\r\n  Email: " . $email . "\r\n Message: Applying for position as Tutor \r\n SKILLS:" . $skills; 
      
                        $subject ="CV RECEIVER";
                        $fromname ="ANILLOWorldwide";
                        $fromemail = 'apply@anilloworldwide.org';
                        $mailto = 'contact@anilloworldwide.org';
                        $content = file_get_contents($fileName);
                        $content = chunk_split(base64_encode($content));
                        $separator = md5(time());
                        $eol = "\r\n";
                        // main header (multipart mandatory)
                        $headers = "From: ".$fromname." <".$fromemail.">" . $eol;
                        $headers .= "MIME-Version: 1.0" . $eol;
                        $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
                        $headers .= "Content-Transfer-Encoding: 7bit" . $eol;
                        $headers .= "This is a MIME encoded message." . $eol;
                        // message
                        $body = "--" . $separator . $eol;
                        $body .= "Content-Type: text/plain; charset=\"iso-8859-1\"" . $eol;
                        $body .= "Content-Transfer-Encoding: 8bit" . $eol;
                        $body .= $message . $eol;
                        // attachment
                        $body .= "--" . $separator . $eol;
                        $body .= "Content-Type: application/octet-stream; name=\"" . $filenameee . "\"" . $eol;
                        $body .= "Content-Transfer-Encoding: base64" . $eol;
                        $body .= "Content-Disposition: attachment" . $eol;
                        $body .= $content . $eol;
                        $body .= "--" . $separator . "--";
                        //SEND Mail
                        if (mail($mailto, $subject, $body, $headers)) {
                          $mailto = $email;
                          $message = "<html><body><h1>Hello ". $user_name .",</h1> \r\n <p>Welcome to ANILLO Worldwide. We are happy to have you here! Your tutor account was successfully created, but it is still inactive. Await our team to review your credentials and we'll get back to you shortly.</p> \r\n <p>In the meanwhile, fill out this form with your information:</p> \r\n \r\n <h1>TEAM ANILLO WORLDWIDE.</h1></body></html>";
                          $body2 = "--" . $separator . $eol;
                          $body2 .= "Content-Type: text/html; charset=\"utf-8\"" . $eol;
                          $body2 .= "Content-Transfer-Encoding: 8bit" . $eol;
                          $body2 .= $message . $eol;
                          $subject = "ACCOUNT APPROVAL - ANILLO Worldwide";

                          if(mail($mailto, $subject, $body2, $headers)) {
                            if(move_uploaded_file($file_tmp_name,$img_url)) {
                              // save to database
                              $query = "insert into users (user_id,user_name,email,password,user_psw_length,phone,gender,type,availability,tid) values('$user_id','$user_name','$email','$hashed_pwd','$psw_length', '$phone', '$gender','$type', '$availability','$tid')";
                              mysqli_query($con, $query);

                              $query2 = "insert into tutors (name,id,status) values('$user_name','$tid','inactive')";
                              mysqli_query($con, $query2);

                              $query3 = "insert into images (img_id,user,url,userfor) values('$imageid','$user_id','$img_url','profile')";
                              mysqli_query($con, $query3);

                              $_SESSION['user_id'] = $user_id;
                              header("Location: /");
                              die;
                            } else {
                              $refresh = true;
                              $acc2 = true;
                              $create = false;
                              $msg_error = "Could not send email, possible reasons: unexisting email, system FAIL. ACCOUNT NOT CREATED";
                            }
                          } else {
                            $refresh = true;
                            $acc2 = true;
                            $create = false;
                            $msg_error = "Could not send email, possible reasons: unexisting email, system FAIL. ACCOUNT NOT CREATED";
                          }
                        } else {
                          $refresh = true;
                          $acc2 = true;
                          $create = false;
                          $msg_error = "Could not send email, server ERROR, TUTOR ACCOUNT CREATED STATUS: INACTIVE. ACCOUNT NOT CREATED";
                        }
                      } else {
                        $refresh = true;
                        $acc2 = true;
                        $create = false;
                        $msg_error = "This is an invalid phone number format, please input following one of these formats: (+XX/XXX) XX XXXXX-XXXX, (+XX/XXX)-XX-XXXXX-XXXX or (+XX/XXX)XXXXXXXXX";
                      }
                    } else if(!preg_match($pattern_password, $password)) {
                      $refresh = true;
                      $acc2 = true;
                      $create = false;
                      $msg_error = "The password needs to contain at least a capital letter, 8 characters, one special character, and a number!!";
                    }
                  }
                } else if (strlen($user_name) > 10) {
                  $refresh = true;
                  $acc2 = true;
                  $create = false;
                  $msg_error = "Username is too long (max-chars: 30).";
                }
              } else if (!preg_match($pattern_name, $user_name)) {
                $msg_error = "Invalid username!";
                $refresh = true;
                $create = false;
                $acc2 = true;
              }
            }
          } else if(!preg_match($pattern_email, $email)) {
            $refresh = true;
            $acc2 = true;
            $create = false;
            $msg_error = "Please, type a valid email!";
          }
        }else
        {
          $msg_error = "Please, type valid information!";
        }
      } 
      else if(isset($_POST['firstnamethree'])) {
        $user_name = $_POST['firstnamethree'];
        $password = $_POST['passwordthree'];
        $email = $_POST['emailthree'];
        $type = "contentcreator";
        $refresh = false;
  
        if(!empty($user_name) && !empty($password) && !empty($email) && !is_numeric($user_name))
        {
          if(preg_match($pattern_email, $email)) {
            $str = "SELECT * FROM users WHERE email = '". $email ."'";
            $select = mysqli_query($con, $str);
            if(mysqli_num_rows($select)){
              $refresh = true;
              $acc3 = true;
              $create = false;
              $msg_error = "Email already in use! In case it wasn't registered, contact our support team";
            } else if (!mysqli_num_rows($select)){
              if(preg_match($pattern_name, $user_name)){
                if(strlen($user_name) <= 30){
                  if($password !== $_POST['cpasswordthree']) {
                    $refresh = true;
                    $acc3 = true;
                    $create = false;
                    $msg_error = "The password has to be the same in both fields!";
                  } else if ($password === $_POST['cpasswordthree']) {
                    if(preg_match($pattern_password, $password)){
                      if(!preg_match($pattern_phone, $_POST['numberthree'])) {
                        $refresh = true;
                        $acc3 = true;
                        $create = false;
                        $msg_error = "This is an invalid phone number format, please input following one of these formats: (+XX/XXX) XX XXXXX-XXXX, (+XX/XXX)-XX-XXXXX-XXXX or (+XX/XXX)XXXXXXXXX";
                      }
                      $user_id = random_num(20);
                      $psw_length = strlen($password);
                      $hashed_pwd = password_hash($password, PASSWORD_DEFAULT);
                      $phone = $_POST['numberthree'];
                      $gender = $_POST['genderthree'];
                      $availability = $_POST['availabilitytwo'];

                      $filenameee =  $_FILES['filename']['name'];
                      $fileName = $_FILES['filename']['tmp_name'];
                      $socialmedia = $_POST['socialmedia'];
    
                      $message ="Name = ". $user_name . "\r\n  Email: " . $email . "\r\n Message: Applying for position as Tutor \r\n Social Media:" . $socialmedia; 
    
                      $subject ="CV RECEIVER";
                      $fromname ="ANILLOWorldwide";
                      $fromemail = 'apply@anilloworldwide.org';
                      $mailto = 'computer.richard0923@gmail.com';
                      $content = file_get_contents($fileName);
                      $content = chunk_split(base64_encode($content));
                      $separator = md5(time());
                      $eol = "\r\n";
                      // main header (multipart mandatory)
                      $headers = "From: ".$fromname." <".$fromemail.">" . $eol;
                      $headers .= "MIME-Version: 1.0" . $eol;
                      $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
                      $headers .= "Content-Transfer-Encoding: 7bit" . $eol;
                      $headers .= "This is a MIME encoded message." . $eol;
                      // message
                      $body = "--" . $separator . $eol;
                      $body .= "Content-Type: text/plain; charset=\"iso-8859-1\"" . $eol;
                      $body .= "Content-Transfer-Encoding: 8bit" . $eol;
                      $body .= $message . $eol;
                      // attachment
                      $body .= "--" . $separator . $eol;
                      $body .= "Content-Type: application/octet-stream; name=\"" . $filenameee . "\"" . $eol;
                      $body .= "Content-Transfer-Encoding: base64" . $eol;
                      $body .= "Content-Disposition: attachment" . $eol;
                      $body .= $content . $eol;
                      $body .= "--" . $separator . "--";
                      //SEND Mail
                      if (mail($mailto, $subject, $body, $headers)) {
                        $mailto = $email;
                        $message = "Hello ". $user_name .", \r\n Welcome to ANILLO Worldwide. We are happy to have you here! Your content creator account was successfully created, but it is still inactive. Wait for our team to review your credentials and we'll get back to you shortly. \r\n \r\n TEAM ANILLO WORLDWIDE.";
                        $body2 = "--" . $separator . $eol;
                        $body2 .= "Content-Type: text/plain; charset=\"iso-8859-1\"" . $eol;
                        $body2 .= "Content-Transfer-Encoding: 8bit" . $eol;
                        $body2 .= $message . $eol;
                        $subject = "ACCOUNT APPROVAL - ANILLO Worldwide";

                        if(mail($mailto, $subject, $body2, $headers)) {
                          // save to database
                          $query = "insert into users (user_id,user_name,email,password,user_psw_length,phone,gender,type,availability) values('$user_id','$user_name','$email','$hashed_pwd','$psw_length', '$phone', '$gender','$type', '$availability')";
                          mysqli_query($con, $query);

                          $_SESSION['user_id'] = $user_id;
                          header("Location: /");
                          die;
                        } else {
                          $refresh = true;
                          $acc2 = true;
                          $create = false;
                          $msg_error = "Could not send email, possible reasons: unexisting email, system FAIL";
                        }
                      } else {
                        $refresh = true;
                        $acc2 = true;
                        $create = false;
                        $msg_error = "Could not send email, server ERROR, TUTOR ACCOUNT CREATED STATUS: INACTIVE";
                      }
                    } else if(!preg_match($pattern_password, $password)) {
                      $refresh = true;
                      $acc3 = true;
                      $create = false;
                      $msg_error = "The password needs to contain at least a capital letter, 8 characters, one special character, and a number!!";
                    }
                  }
                } else if (strlen($user_name) > 10) {
                  $refresh = true;
                  $acc3 = true;
                  $create = false;
                  $msg_error = "Username is too long (max-chars: 30).";
                }
              } else if (!preg_match($pattern_name, $user_name)) {
                $msg_error = "Invalid username!";
                $refresh = true;
                $create = false;
                $acc3 = true;
              }
            }
          } else if(!preg_match($pattern_email, $email)) {
            $refresh = true;
            $acc3 = true;
            $create = false;
            $msg_error = "Please, type a valid email!";
          }
        }else
        {
          $msg_error = "Please, type valid information!";
        }
      } else {
        $email = $_POST['emaillog'];
        $password = $_POST['passwordlog'];
        $refresh = false;

        if(!empty($email) && !empty($password) && !is_numeric($email))
        {
          // read from database
          $query = "select * from users where email = '$email' limit 1"; 
          $result = mysqli_query($con, $query);

          if($result)
          {
            if($result && mysqli_num_rows($result) > 0)
            {
              $user_data = mysqli_fetch_assoc($result);
              if($user_data['email'] === $email)
              {
                $verifier = password_verify($password, $user_data['password']);
                if($verifier) {
                  $_SESSION['user_id'] = $user_data['user_id'];
                  header("Location: /");
                  die;
                }else {
                  $acc4 == true;
                  $create = false;
                  $msg_error = "Error: You couldn't log in! (invalid password or system fail)";
                }
              } else {
                $acc4 == true;
                $create = false;
                $msg_error = "Invalid username or password!";
              }
            }
          }else {
            $acc4 == true;
            $create = false;
            $msg_error = "Invalid username or password!";
          }
        }else
        {
          $acc4 == true;
          $create = false;
          $msg_error = "Account not found!";
        }
      }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/account.css">
  <title>ANILLO Worldwide</title>
</head>

<body>
  <div class="container">
    <div class="create-container item <?php if($create == false) { echo "deactive";}?>">
      <div class="form-image">
        <img src="images/choose.svg" alt="">
      </div>
      <div class="form">
        <form action="#" id="chooseForm">
          <div class="form-header">
            <div class="title">
              <h1>Register</h1>
            </div>
            <div class="login-button">
              <button class="signin">SIGN IN</button>
            </div>
          </div>

          <div class="inputs">
            <div class="title">
              <h6>What kind of account do you want?</h6>
            </div>

            <div class="group">
              <div class="input">
                <input id="tutor" class="tutor" type="radio" name="account">
                <label for="tutor">Tutor</label>
              </div>

              <div class="input">
                <input id="Student" class="student" type="radio" name="account">
                <label for="Student">Student</label>
              </div>

              <div class="input">
                <input id="contentcreator" class="content" type="radio" name="account">
                <label for="contentcreator">Content Creator</label>
              </div>
            </div>
          </div>

          <div class="continue-button">
            <button class="btnone">Continue</button>
          </div>
          <a href="/" class="return">← return</a>
      </div>
      </form>
    </div>
    <div class="account-container item <?php if($acc == true) { echo "active";} else if($acc == false) {echo "deactive";} ?>">
      <div class="form-image">
        <img src="images/account.svg" alt="">
      </div>
      <div class="form">
        <form action="#" style="overflow-y: scroll;" method="post" enctype="multipart/form-data">
          <div class="form-header">
            <div class="title">
              <h1>Register</h1>
            </div>
            <div class="login-button">
              <button class="signin">SIGN IN</button>
            </div>
          </div>

          <div class="input-group">
            <div class="input-box">
              <label for="firstname">First Name</label>
              <input id="firstname" type="text" name="firstname" placeholder="Type out your first name" <?php if(isset($refresh) && $refresh) { echo 'value="'. $_POST['firstname'] .'"';} ?> required>
            </div>

            <div class="input-box">
              <label for="lastname">Last Name</label>
              <input id="lastname" type="text" name="lastname" placeholder="Type out your last name" <?php if(isset($refresh) && $refresh) { echo 'value="'. $_POST['lastname'] .'"';} ?> required>
            </div>
            <div class="input-box">
              <label for="email">E-mail</label>
              <input id="email" type="email" name="email" placeholder="Write your e-mail" <?php if(isset($refresh) && $refresh) { echo 'value="'. $email .'"';} ?> required>
            </div>

            <div class="input-box">
              <label for="number">Phone #</label>
              <input id="number" type="tel" name="number" placeholder="(+XX/XXX) XX xxxx-xxxx" <?php if(isset($refresh) && $refresh) { echo 'value="'. $_POST['number'] .'"';} ?> required>
            </div>

            <div class="input-box">
              <label for="password">Password</label>
              <input id="password" type="password" name="password" placeholder="Password" <?php if(isset($refresh) && $refresh) { echo 'value="'. $password .'"';} ?> required>
            </div>

            <div class="input-box">
              <label for="cpassword">Confirm Your Password</label>
              <input id="cpassword" type="password" name="cpassword" placeholder="Confirm your password" <?php if(isset($refresh) && $refresh) { echo 'value="'. $password .'"';} ?> required>
            </div>

            <div class="input-box">
              <span class="sp" style="color: red"><?php if(isset($msg_error)){echo $msg_error;} ?></span>
            </div>
          </div>

          <div class="inputs">
            <div class="title">
              <h6>Gender</h6>
            </div>

            <div class="group">
              <div class="input">
                <input id="female" type="radio" name="gender" value="Female">
                <label for="female">Female</label>
              </div>

              <div class="input">
                <input id="male" type="radio" name="gender" value="Male">
                <label for="male">Male</label>
              </div>

              <div class="input">
                <input id="others" type="radio" name="gender" value="Others">
                <label for="others">Others</label>
              </div>

              <div class="input">
                <input id="none" type="radio" name="gender" value="PNTS">
                <label for="none">Prefer not to say</label>
              </div>
            </div>
          </div>

          <div class="inputs">
            <div class="title">
              <h6>Choose your Profile Photo (JPG ONLY)</h6>
            </div>

            <div class="group">
              <div class="input">
                <input type="file" id="myprofile" name="pfpname" accept=".jpg" required style="color: black;">
              </div>
            </div>
          </div>
          <div class="continue-button">
            <button class="btntwo" type>REGISTER</button>
          </div>
          <a href="/" class="return">← return</a>
      </div>
      </form>
    </div>
    <div class="tutor-container item <?php if($acc2 == true) { echo "active";} else if($acc2 == false){echo "deactive";} ?>">
      <div class="form-image">
        <img src="images/tutor.svg" alt="">
      </div>
      <div class="form">
        <form action="#" style="overflow-y: scroll;" method="post" enctype="multipart/form-data">
          <div class="form-header">
            <div class="title">
              <h1>Tutor Register</h1>
            </div>
            <div class="login-button">
              <button class="signin">SIGN IN</button>
            </div>
          </div>

          <div class="input-group">
            <div class="input-box">
              <label for="firstname">Full Name</label>
              <input id="firstnametwo" type="text" name="firstnametwo" placeholder="Type out your full name" <?php if(isset($refresh) && $refresh) { echo 'value="'. $_POST['firstnametwo'] .'"';} ?> required>
            </div>

            <div class="input-box">
              <label for="skills">Skills</label>
              <input id="skills" type="text" name="skills" placeholder="Example: programming, lecturing, so on" <?php if(isset($refresh) && $refresh) { echo 'value="'. $_POST['skills'] .'"';} ?> required>
            </div>
            <div class="input-box">
              <label for="email">E-mail</label>
              <input id="emailtwo" type="email" name="emailtwo" placeholder="Write your e-mail" <?php if(isset($refresh) && $refresh) { echo 'value="'. $_POST['emailtwo'] .'"';} ?> required>
            </div>

            <div class="input-box">
              <label for="number">Phone #</label>
              <input id="numbertwo" type="tel" name="numbertwo" placeholder="(+XX/XXX) XX xxxx-xxxx" <?php if(isset($refresh) && $refresh) { echo 'value="'. $_POST['numbertwo'] .'"';} ?> required>
            </div>

            <div class="input-box">
              <label for="password">Password</label>
              <input id="passwordtwo" type="password" name="passwordtwo" placeholder="Password" <?php if(isset($refresh) && $refresh) { echo 'value="'. $_POST['passwordtwo'] .'"';} ?> required>
            </div>


            <div class="input-box">
              <label for="confirmPassword">Confirm Your Password</label>
              <input id="confirmPasswordtwo" type="password" name="cpasswordtwo" placeholder="Confirm your password" <?php if(isset($refresh) && $refresh) { echo 'value="'. $_POST['passwordtwo'] .'"';} ?> required>
            </div>

            <div class="input-box">
              <span class="sp" style="color: red"><?php if(isset($msg_error)){echo $msg_error;} ?></span>
            </div>

          </div>

          <div class="inputs">
            <div class="title">
              <h6>Gender</h6>
            </div>

            <div class="group">
              <div class="input">
                <input id="femaletwo" type="radio" name="gendertwo" value="Female">
                <label for="female">Female</label>
              </div>

              <div class="input">
                <input id="maletwo" type="radio" name="gendertwo" value="Male">
                <label for="male">Male</label>
              </div>

              <div class="input">
                <input id="otherstwo" type="radio" name="gendertwo" value="Others">
                <label for="others">Others</label>
              </div>

              <div class="input">
                <input id="nonetwo" type="radio" name="gendertwo" value="PNTS">
                <label for="none">Prefer not to say</label>
              </div>
            </div>
          </div>

          <div class="inputs">
            <div class="title">
              <h6>Availability</h6>
            </div>

            <div class="group">
              <div class="input">
                <input id="part-time" type="radio" name="availability" value="parttime">
                <label for="part-time">part-time</label>
              </div>

              <div class="input">
                <input id="full-time" type="radio" name="availability" value="fulltime">
                <label for="full-time">full-time</label>
              </div>
            </div>
          </div>

          <div class="inputs">
            <div class="title">
              <h6>Send us your CV (PDF ONLY)</h6>
            </div>

            <div class="group">
              <div class="input">
                <input type="file" id="myFile" name="filename" accept=".pdf" required style="color: black;">
              </div>
            </div>
          </div>
          <div class="inputs">
            <div class="title">
              <h6>Choose your Profile Photo (JPG ONLY)</h6>
            </div>

            <div class="group">
              <div class="input">
                <input type="file" id="myprofiletwo" name="pfpname" accept=".jpg" required style="color: black;">
              </div>
            </div>
          </div>

          <div class="continue-button">
            <button class="btnthree">REGISTER</button>
          </div>
          <a href="/" class="return">← return</a>
      </div>
      </form>
    </div>
    <div class="social-container item <?php if($acc3 == true) { echo "active";} else if($acc3 == false) {echo "deactive";} ?>">
      <div class="form-image">
        <img src="images/content.svg" alt="">
      </div>
      <div class="form">
        <form action="#" style="overflow-y: scroll;" method="post" enctype="multipart/form-data">
          <div class="form-header">
            <div class="title">
              <h1>Content Creator Register</h1>
            </div>
            <div class="login-button">
              <button class="signin">SIGN IN</button>
            </div>
          </div>

          <div class="input-group">
            <div class="input-box">
              <label for="firstname">Full Name</label>
              <input id="firstnamethree" type="text" name="firstnamethree" <?php if(isset($refresh) && $refresh) { echo 'value="'. $_POST['firstnamethree'] .'"';} ?> placeholder="Type out your full name" required>
            </div>

            <div class="input-box">
              <label for="socialmedia">Social Media</label>
              <input id="socialmedia" type="text" name="socialmedia" <?php if(isset($refresh) && $refresh) { echo 'value="'. $_POST['socialmedia'] .'"';} ?> placeholder="Your social media" required>
            </div>
            <div class="input-box">
              <label for="email">E-mail</label>
              <input id="emailthree" type="email" name="emailthree" <?php if(isset($refresh) && $refresh) { echo 'value="'. $_POST['emailthree'] .'"';} ?> placeholder="Write your e-mail" required>
            </div>

            <div class="input-box">
              <label for="number">Phone #</label>
              <input id="numberthree" type="tel" name="numberthree" <?php if(isset($refresh) && $refresh) { echo 'value="'. $_POST['emailthree'] .'"';} ?> placeholder="(+XX/XXX) XX xxxx-xxxx" required>
            </div>

            <div class="input-box">
              <label for="password">Password</label>
              <input id="passwordthree" type="password" name="passwordthree" <?php if(isset($refresh) && $refresh) { echo 'value="'. $_POST['passwordthree'] .'"';} ?> placeholder="Password" required>
            </div>


            <div class="input-box">
              <label for="confirmPassword">Confirm Your Password</label>
              <input id="confirmPasswordthree" type="password" name="cpasswordthree" <?php if(isset($refresh) && $refresh) { echo 'value="'. $_POST['passwordthree'] .'"';} ?> placeholder="Confirm your password" required>
            </div>

          </div>

          <div class="inputs">
            <div class="title">
              <h6>Gender</h6>
            </div>

            <div class="group">
              <div class="input">
                <input id="femalethree" type="radio" name="gender">
                <label for="female">Female</label>
              </div>

              <div class="input">
                <input id="malethree" type="radio" name="gender">
                <label for="male">Male</label>
              </div>

              <div class="input">
                <input id="othersthree" type="radio" name="gender">
                <label for="others">Others</label>
              </div>

              <div class="input">
                <input id="nonethree" type="radio" name="gender">
                <label for="none">Prefer not to say</label>
              </div>
            </div>
          </div>

          <div class="inputs">
            <div class="title">
              <h6>Availability</h6>
            </div>

            <div class="group">
              <div class="input">
                <input id="part-timetwo" type="radio" name="availabilitytwo" value="parttime">
                <label for="part-time">part-time</label>
              </div>

              <div class="input">
                <input id="full-timetwo" type="radio" name="availabilitytwo" value="fulltime">
                <label for="full-time">full-time</label>
              </div>
            </div>
          </div>

          <div class="inputs">
            <div class="title">
              <h6>Send us a screenshot of your media (JPG ONLY)</h6>
            </div>

            <div class="group">
              <div class="input">
                <input type="file" id="myFiletwo" name="filename" accept=".jpg" required style="color: black;">
              </div>
            </div>
          </div>

          <div class="inputs">
            <div class="title">
              <h6>Choose your Profile Photo (JPG ONLY)</h6>
            </div>

            <div class="group">
              <div class="input">
                <input type="file" id="myprofilethree" name="pfpname" accept=".jpg" required style="color: black;">
              </div>
            </div>
          </div>

          <div class="continue-button">
            <button class="btnthree">REGISTER</button>
          </div>
          <a href="/" class="return">← return</a>
      </div>
      </form>
    </div>
    <div class="login-container item <?php if($acc4 === true) { echo "active";} else if($acc4 === false) {echo "deactive";} ?>">
      <div class="form-image">
        <img src="images/content.svg" alt="">
      </div>
      <div class="form">
        <form action="#" style="overflow-y: scroll;" method="post">
          <div class="form-header">
            <div class="title">
              <h1>Sign In</h1>
            </div>
            <div class="login-button">
              <button class="register">REGISTER</button>
            </div>
          </div>

          <div class="input-group">
            <div class="input-box">
              <label for="email">E-mail</label>
              <input id="emailfour" type="email" name="emaillog" placeholder="Write your e-mail" required>
            </div>
            <div class="input-box">
              <label for="password">Password</label>
              <input id="passwordfour" type="password" name="passwordlog" placeholder="Password" required>
            </div>
            <div class="input-box">
              <span class="sp"><?php if(isset($msg_error)){echo $msg_error;} ?></span>
            </div>
          </div>
          <div class="continue-button">
            <button class="btnfour">Sign In</button>
          </div>
          <a href="/" class="return">← return</a>
      </div>
      </form>
    </div>
  </div>

  <script src="js/login.js"></script>
</body>

</html>