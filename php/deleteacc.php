<?php
session_start();
    
  include("connection.php");
  include("functions.php");
  include("inc/query.inc.php");

  $user_data = check_login($con);
  if(isset($user_data))
  {
    $username = $user_data['user_name'];
    $query = "delete from users where user_id='". $user_data['user_id'] ."'";
    $result = $con->query($query);
    if(!$result) {
      header("Location: ../index.php");
    } else {
      header("Location: ../index.php");
      die;
    }
  } else if(!isset($user_data)) {
    http_response_code(404);
    die;
  }