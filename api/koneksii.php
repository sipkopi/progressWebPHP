<?php

$DBhost = "localhost";
$DBuser = "sipkopic_team";
$DBpassword ="sipkopiteam@2";
$DBname="sipkopic_team2";



$koneksi = mysqli_connect($DBhost, $DBuser, $DBpassword, $DBname); 

if(!$koneksi){
	die("Connection failed: " . mysqli_connect_error());
}

?> 