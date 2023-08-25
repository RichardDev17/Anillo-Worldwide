<?php

$dbhost = "204.44.192.79";
$dbuser = "anill850_walker";
$dbpass = "7[hW6o,r?y1a";
$dbname = "anill850_anillo";

if(!$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
{
  die("failed to connect!");
}