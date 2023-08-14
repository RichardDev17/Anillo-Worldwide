<?php
session_start();
    
  include("php/connection.php");
  include("php/functions.php");
  include("php/inc/query.inc.php");

  $user_data = check_login($con);
  if(isset($user_data))
  {
    $username = $user_data['user_name'];
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/index/index.css">
  <link rel="stylesheet" href="css/responsive.css">
  <link rel="stylesheet" href="css/reset.css">
  <title>Anillo Worldwide</title>
</head>

<body>
  <nav class="menu">
    <div class="bg"></div>
    <div class="container">
      <div class="menu-flex fade-in">
        <div class="logo" onclick="window.location = '/'">
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
                echo '<li class="item register">
                <a href="account.php">SIGN IN</a>
                <button class="btn" onclick="window.location = "/account.php"">REGISTER</button>
                </li>';
              }
            ?>
          </ul>
        </div>
      </div>
    </div>
    <div class="container">
      <section class="welcome fade-in">
        <h1 class="title">OUR AMBITION</h1>
        <div class="pg">
          <p class="paragraph">The creation of ANILLO Worldwide was inspired by a passion to help others by spreading knowledge through language and culture. </p>
        </div>
        <button class="btn" onclick="window.location = '/hire.php'">VIEW OUR TUTORS</button>
      </section>
    </div>
  </nav>
  <section class="cards-wrapper">
    <div class="card-starter fade-in">
      <div class="container">
        <h1 class="title">ANILLO Worldwide</h1>
        <p class="paragraph">Learn more about our missions, visions and goals</p>
        <button class="btn" onclick="window.location = '/about.php'">LEARN MORE</button>
      </div>
    </div>

    <div class="cards-container">
      <div class="cards">
        <div class="card fade-left">
          <h1 class="title">Our <span class="sp">Mission</span></h1>
          <div class="container">
            <p class="paragraph">We strive to <span class="sp">empower</span> & <span class="sp">enlighten</span> the world to achieve <span class="sp">success</span> through language learning & cultural enthusiasm.</p>
          </div>
        </div>
        <div class="card fade-in">
          <h1 class="title">Our <span class="sp">Vision</span></h1>
          <div class="container">
            <p class="paragraph">We connect language teachers, experts, and learners to expand their <span class="sp">horizon</span>, <span class="sp">socialize</span>, and <span class="sp">have fun</span>.</p>
          </div>
        </div>
        <div class="card fade-right">
          <h1 class="title">Our <span class="sp">Goal</span></h1>
          <div class="container">
            <p class="paragraph">We aim to <span class="sp">revitalize</span> endangered <span class="sp">languages globally</span> and <span class="sp">promote</span> language learning worldwide.</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="socials-wrapper">
    <div class="social-starter">
      <div class="container">
        <div class="starter fade-in">
          <h1 class="title">Get in on the action</h1>
          <p class="paragraph">across multiple outlets starting with 5 languages: <br><span class="sp">English, German, Spanish, Portuguese and Arabic</span></p>
        </div>
        <div class="socials">
          <div class="social fade-left">
            <img src="images/icon1.svg" alt="">
            <p class="paragraph">Public Community</p>
          </div>
          <div class="social fade-in">
            <img src="images/icon2.svg" alt="">
            <p class="paragraph">Private Groups</p>
          </div>
          <div class="social fade-in">
            <img src="images/icon3.svg" alt="">
            <p class="paragraph">Creative Content</p>
          </div>
          <div class="social fade-right">
            <img src="images/icon4.svg" alt="">
            <p class="paragraph">Discussion Forum <br>(coming soon)</p>
          </div>
        </div>
        <button class="btn fade-in" onclick="window.location = 'linktr.ee/anilloworldwide'">LEARN MORE</button>
      </div>
    </div>
    <div class="social-ender">
      <div class="social-container">
        <div class="social-info">
          <div class="info fade-left">
            <p class="paragraph-title">1 on 1</p>
            <p class="paragraph">tutoring</p>
          </div>
          <div class="info fade-in">
            <p class="paragraph-title">Conversation</p>
            <p class="paragraph">partners</p>
          </div>
          <div class="info fade-right">
            <p class="paragraph-title">Small Group</p>
            <p class="paragraph">workshops</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <footer class="footer-wrapper">
    <div class="container">
      <div class="footer-container">
        <img src="images/footer-image.svg" class="fade-left">
        <p class="paragraph fade-right">At ANILLO Worldwide, once fully operational, we aim to devote our efforts towards becoming a certified B Corp benefit corporation. Our goal on this front is to breathe life into languages and cultures around the world that are fading away. As well as providing an incredible opportunity for teachers and other professionals to make a living using our intuitive and interactive platforms. Join us for the ride!</p>
      </div>
      <div>
        <button class="btn fade-in">WHAT'S A B CORP?</button>
      </div>
    </div>
  </footer>
  <div class="disclaimer-wrapper">
    <p class="paragraph">Copyright © 2023 ANILLO WorldWide ®</p>
  </div>

  <script src="js/observers.js"></script>
</body>

</html>