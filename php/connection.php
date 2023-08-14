<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "@uLilcDY@JZC3*x-";
$dbname = "anillo";

if(!$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
{
  die("failed to connect!");
}