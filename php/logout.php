<?php

header("Acces-Control-Allow-Origin: *");
Header("Content-Type: application/x-javascript; charset=UTF-8"); 
session_start();

session_destroy();

header('location:login.php');

?>
