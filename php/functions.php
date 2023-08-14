<?php

function check_login($con)
{
  if(isset($_SESSION['user_id']))
  {
    $id = $_SESSION['user_id'];
    $query = "select * from users where user_id = '$id' limit 1";

    $result = mysqli_query($con, $query);
    if($result && mysqli_num_rows($result) > 0)
    {
      $user_data = mysqli_fetch_assoc($result);
      return $user_data;
    }
  }
}

function random_num($length)
{
  $text = "";
  if($length < 5)
  {
    $length = 5;
  }

  $len = rand(4,$length);

  for ($i=0; $i < $len; $i++) { 
    $text .= rand(0,9);
  }

  return $text;
}

function deleteAcc($userid, $con) {
  $cards = "delete from users_card where card_user_id='$userid'";
  $result = mysqli_query($con, $cards);
  $user = "delete from users where user_id='$userid'";
  $result2 = mysqli_query($con, $user);
  $cart = "delete from carrinhos where cart_user='$userid'";
  $result = mysqli_query($con, $cart);
  $comments = "delete from comments where name_commentator='$userid'";
  $result = mysqli_query($con, $comments);
  $fav = "delete from fav where fav_user='$userid'";
  $result = mysqli_query($con, $fav);
  header("Location: ../html/index");
  die;
}

function makeStr($num) {
  $str = '';
  for ($i=0; $i < $num; $i++) { 
    $str .= "*";
  }
  return $str;
}

function encrypt($trgt) {
  $anillo_ciphering_stuff = "AES-128-CTR";
  $anillo_iv_length_ssl_stuff = openssl_cipher_iv_length($anillo_ciphering_stuff);
  $opps = 0;
  $anillo_encryption_iv_ssl_iv_stuff = '1234567891011121';
  $anillo_key_ssl_encryption = "7K_T9fmH9*^E^44D";

  $encrypted_string = openssl_encrypt($trgt, $anillo_ciphering_stuff, $anillo_key_ssl_encryption, $opps, $anillo_encryption_iv_ssl_iv_stuff);
  return $base64_encrypted_string = base64_encode($encrypted_string);
}

function decrypt($trgt) {
  $decrypted_trgt = base64_decode($trgt);
  $anillo_ciphering_stuff = "AES-128-CTR";
  $anillo_iv_length_ssl_stuff = openssl_cipher_iv_length($anillo_ciphering_stuff);
  $opps = 0;
  $anillo_decryption_iv_ssl_iv_stuff = '1234567891011121';
  $anillo_key_ssl_decryption = "7K_T9fmH9*^E^44D";

  return $encrypted_string = openssl_decrypt($decrypted_trgt, $anillo_ciphering_stuff, $anillo_key_ssl_decryption, $opps, $anillo_decryption_iv_ssl_iv_stuff);
}