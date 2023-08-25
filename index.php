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
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/index/index.css">
  <link rel="stylesheet" href="css/responsive.css">
  <title>ANILLO Worldwide</title>
</head>

<body>
  <nav class="menu">
    <div class="bg"></div>
    <div class="container">
      <div class="menu-flex fade-in">
        <div class="logo" onclick="window.location.href = '/test'">
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
    <div class="container">
      <section class="welcome fade-in">
        <h1 class="title">OUR AMBITION</h1>
        <div class="pg">
          <p class="paragraph">We are passionate about helping others by spreading knowledge of language and culture.</p>
        </div>
        <button class="btn" onclick="window.location.href = '/hire.php'">VIEW OUR TUTORS</button>
      </section>
    </div>
  </nav>
  <section class="cards-wrapper">
    <div class="card-starter fade-in">
      <div class="container">
        <h1 class="title">ANILLO Worldwide</h1>
        <p class="paragraph">Learn more about our mission, vision and goals</p>
        <button class="btn" onclick="window.location.href = '/about.php'">LEARN MORE</button>
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
        <button class="btn fade-in" onclick="window.location.href = 'linktr.ee/anilloworldwide'">LEARN MORE</button>
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
        <img src="images/footer-image.jpg" class="fade-left">
        <p class="paragraph fade-right">ANILLO Worldwide is working to become fully operational with several mainstream languages, then our next goal is to preserve and teach less common and endangered languages. We aim to breathe new life into languages and cultures that are less commonly spoken and others that are fading away. We believe that all languages and cultures offer unique knowledge and understanding. Join our community and embark on this exciting journey with us!</p>
      </div>
      <div>
        <button class="btn fade-in" onclick="window.location.href = '/about.php'">Learn More</button>
      </div>
    </div>
  </footer>
  <div class="disclaimer-wrapper">
    <p class="paragraph">Copyright © 2023 ANILLO Worldwide ®</p>
  </div>

  <script src="js/observers.js"></script>
</body>

</html>