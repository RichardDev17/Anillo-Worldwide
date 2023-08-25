<?php
session_start();
    
  include("php/connection.php");
  include("php/functions.php");
  include("php/inc/query.inc.php");

  error_reporting(0);

  $user_data = check_login($con);
  if(isset($user_data))
  {
    $username = $user_data['user_name'];
  } else if(!isset($user_data)) {
    header("Location: account.php");
    die;
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/tutor/tutor.css">
  <link rel="stylesheet" href="css/responsive.css">
  <title>ANILLO Worldwide</title>
</head>

<body>
  <nav class="menu">
    <div class="container">
      <div class="menu-flex fade-in">
        <div class="logo" onclick="window.location.href.href = '/test'">
          <img src="images/img.svg" alt="">
          <div class="text">
            <h1 class="title-logo">ANILLO Worldwide</h1>
            <p class="subtitle-logo">Uniting the world through language</p>
          </div>
        </div>
        <div class="list">
          <ul class="list-items">
            <li class="item">
              <a href="about.php">About Us</a>
            </li>
            <li class="item">
              <a href="hire.php">Hire Tutor</a>
            </li>
            <?php 
              if(isset($user_data)){
                echo 
                '<li class="item">
                <a href="profile.php#userid='. encrypt($user_data['user_id']) .'">'. $username .'</a>
                </li>';
              } else if(!isset($user_data)){
                $account = "'account.php'";
                echo '<li class="item register">
                <a href="account.php">SIGN IN</a>
                <button class="btn" onclick="window.location.href = '. $account .'">REGISTER</button>
                </li>';
              }
            ?>
          </ul>
        </div>
      </div>
    </div>
  </nav>
  <div class="profile">
    <div class="container">
      <div class="profile-content">
        <div class="info">
          <div class="profile-photo">
            <img <?php if($user_data['gender'] === 'Male'){ echo 'src="images/male.svg"';} else if($user_data['gender'] === 'Female'){ echo 'src="images/female.svg"';}else { echo 'src="images/unkown.png"';} ?> alt="" style="width: 150px; height: 150px;">
          </div>
          <div class="skills">
            <p class="paragraph">Name: <?php echo $username; ?></p>
            <p class="paragraph">Subscription: Free</p>
            <p class="paragraph"><a href="php/logout.php">Log Out</a></p>
            <p class="paragraph"><a href="php/deleteacc.php">Delete Account</a></p>
          </div>
        </div>
        <div class="description">
          <p class="paragraph">BETA</p>
        </div>
      </div>
    </div>
  </div>
  <div class="disclaimer-wrapper">
    <p class="paragraph">Copyright © 2023 ANILLO Worldwide ®</p>
  </div>
  <script src="js/observers.js"></script>
</body>

</html>