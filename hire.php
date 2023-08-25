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
  <link rel="stylesheet" href="css/hire/hire.css">
  <link rel="stylesheet" href="css/responsive.css">
  <link rel="stylesheet" href="css/card/card.css">
  <title>ANILLO Worldwide</title>
</head>

<body>
  <nav class="menu">
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
  </nav>
  <section class="team-wrapper">
    <h1 class="title">MEET THE <span class="sp">TEAM</span></h1>
    <div class="cards-section" style="width: 100%;">
      <div class="container">
        <div class="cards-container">
        <?php 
            $tutors_query = new QueryProcessor("select * from tutors", $con);
            $result = $tutors_query->getResult();
            $counter = 0;
            while($row = mysqli_fetch_array($result)) {
              $counter++;
              $name_tutors= $row['name'];
              $checker = new QueryProcessor("select * from tutors where name='$name_tutors'", $con);
              $result2 = $checker->getResult();
              $member = mysqli_fetch_array($result2);
              $url = $member['url'];
              $name = $member['name'];
              $role = $member['role'];
              $hometown = $member['hometown'];
              $languages = $member['languages'];
              $experience = $member['experience'];
              $description = $member['description'];
              $id = encrypt($member['id']);
  
              if(mysqli_num_rows($result2) > 0) {
                echo '<div class="card">
                <img src="'. $url .'" alt="">
                <div class="info '. $id .'">
                  <h1 class="name">'. $name .' – <span class="sp">'. $role .'</span></h1>
                  <ul>
                    <li class="item"><span class="sp">Hometown:</span> '. $hometown .'</li>
                    <li class="item"><span class="sp">Languages:</span> '. $languages .'</li>
                    <li class="item"><span class="sp">Experience:</span> '. $experience .'</li>
                  </ul>
                  <button class="btn"><a href="tutor.php?if='. $id .'">VIEW MORE</a></button>
                </div>
                <div class="modal">
                  <div class="modal-content">
                    <img src="'. $url .'" alt="">
                    <div class="info">
                      <h1 class="title"><span class="sp">'. $name .'</span> - Tutor</h1>
                      <div class="description">
                        <p class="paragraph">Languages: '. $languages .'</p>
                        <p class="paragraph">Experience: '. $experience .'</p>
                      </div>
                      <div class="text-description">
                        <p class="paragraph"><span class="sp">Description:</span> '. $description .'</p>
                      </div>
                    </div>
                  </div>
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
    <p class="paragraph">Copyright © 2023 ANILLO Worldwide ®</p>
  </div>
  <script src="js/observers.js"></script>
</body>

</html>