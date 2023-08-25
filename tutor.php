<?php
error_reporting(0);
session_start();
    
  include("php/connection.php");
  include("php/functions.php");
  include("php/inc/query.inc.php");

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
        <?php
          $tid = decrypt($_GET['if']);
          $tutor_query = new QueryProcessor("select * from tutors where id='$tid'", $con);
          $result = $tutor_query->getResult();
          $tutortwo_query = new QueryProcessor("select * from users where tid='$tid'", $con);
          $result2 = $tutortwo_query->getResult();

          $infoone = mysqli_fetch_array($result);
          $infotwo = mysqli_fetch_array($result2);

          $url = $infoone['url'];
          $name = $infotwo['user_name'];
          $role = $infoone['role'];
          $hometown = $infoone['hometown'];
          $languages = $infoone['languages'];
          $experience = $infoone['experience'];
          $description = $infoone['longdc'];
          $age = $infoone['age'];
          $availability = $infotwo['availability'];

          echo '<div class="info">
          <div class="profile-photo">
            <img src="'. $url .'" alt="">
          </div>
          <div class="skills">
            <p class="paragraph">Name: '. $name .'</p>
            <p class="paragraph">Experience: '. $experience .'</p>
            <p class="paragraph">Availability: '. $availability .'</p>
            <p class="paragraph">Age: '. $age .'</p>
          </div>
        </div>
        <div class="description">
          <p class="paragraph">'. $description  .'</p>
        </div>'
        ?>
      </div>
      <button class="btn">HIRE</button>
    </div>
  </div>
  <div class="disclaimer-wrapper">
    <p class="paragraph">Copyright © 2023 ANILLO Worldwide ®</p>
  </div>
  <script src="js/observers.js"></script>
</body>

</html>