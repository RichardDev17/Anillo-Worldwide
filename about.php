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
  <link rel="stylesheet" href="css/about/about.css">
  <link rel="stylesheet" href="css/responsive.css">
  <link rel="stylesheet" href="css/card/card.css">
  <title>ANILLO Worldwide</title>
</head>

<body>
  <nav class="menu">
    <div class="container">
      <div class="menu-flex fade-in">
        <div class="logo" onclick="window.location.href = '/'">
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
              <a href="hire.php">Tutors</a>
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
  <section class="about-wrapper">
    <div class="container">
      <div class="about-content">
        <div class="about-text">
          <h1 class="title fade-in">GET TO KNOW <span class="sp">ANILLO</span>!</h1>
          <div class="paragraphs">
            <p class="paragraph fade-right">ANILLO stands for Allied Network of International Language Learners Online, but it's more than just an acronym–the word <span style="font-style: italic">anillo</span> means ring in Spanish like unity, a bond, and the circle of life. ANILLO Worldwide is a community dedicated to promoting the power of language and culture. We believe that individuals with diverse multilingual and multicultural backgrounds possess a unique gift that can positively impact the world. Our mission is to empower these individuals by providing a range of services, including tutoring options, conversation partners, engaging activities and events, and fundraisers. Through these initiatives, we aim to bring people together, celebrate diversity, and foster understanding on a global scale.</p>
            <p class="paragraph fade-in">At ANILLO Worldwide, we are committed to building a more interconnected and interactive world through the promotion of language, culture, and communication. With a deep appreciation for the compassion we have received in our own lives, we strive to inspire and empower individuals from all backgrounds to embrace their linguistic and cultural diversity, utilizing it as a tool for personal growth and success. Our platform serves as a dynamic and supportive environment where language instructors, professionals, and learners can come together, share knowledge, learn from one another, and have fun. By providing one-on-one tutoring, group sessions, and engaging games and activities, we create an atmosphere where individuals can thrive, irrespective of their background or circumstances.</p>
            <p class="paragraph fade-left">Ultimately, our vision is to revitalize endangered languages globally while encouraging people from all walks of life to embrace language learning and cultural exploration in general. Through fostering a greater appreciation for linguistic and cultural diversity, we believe we can contribute to the creation of a more interconnected, understanding, and harmonious world. Join ANILLO Worldwide as we strive to make this vision a reality, one conversation, one session, and one learner at a time.</p>
          </div>
        </div>
        <div class="about-images">
          <img src="images/about3.svg" alt="" class="air fade-right">
          <img src="images/about.svg" alt="" class="fade-in">
          <img src="images/about2.svg" alt="" class="air fade-left">
        </div>
      </div>
    </div>
  </section>
  <section class="team-wrapper">
    <h1 class="title">MEET THE <span class="sp">TEAM</span></h1>
    <div class="cards-section" style="width: 100%;">
      <div class="container" style="margin: 0px 50px">
        <div class="cards-container">
        <?php 
            $team_query = new QueryProcessor("select * from team", $con);
            $result = $team_query->getResult();
            $counter = 0;
            while($row = mysqli_fetch_array($result)) {
              $counter++;
              $name_team= $row['name'];
              $checker = new QueryProcessor("select * from team where name='$name_team'", $con);
              $result2 = $checker->getResult();
              $member = mysqli_fetch_array($result2);
              $url = $member['url'];
              $name = $member['name'];
              $role = $member['role'];
              $hometown = $member['hometown'];
              $languages = $member['languages'];
              $experience = $member['experience'];
  
              if(mysqli_num_rows($result2) > 0) {
                echo '<div class="card">
                  <img src="'. $url .'" alt="">
                  <div class="info">
                    <h1 class="name">'. $name .' – <span class="sp">'. $role .'</span></h1>
                    <ul>
                      <li class="item"><span class="sp">Hometown:</span> '. $hometown .'</li>
                      <li class="item"><span class="sp">Languages:</span> '. $languages .'</li>
                      <li class="item"><span class="sp">Experience:</span> '. $experience .'</li>
                    </ul>
                  </div>
                </div>';
              } else if(mysqli_num_rows($result2) < 0){
                echo 'no team found';
              }
            }
          ?>
        </div>
      </div>
    </div>
  </section>
  <div class="disclaimer-wrapper">
    <p class="paragraph">Copyright © 2022 ANILLO Worldwide ®</p>
  </div>
  <script src="js/observers.js"></script>
</body>

</html>