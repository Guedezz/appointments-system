<?php
/* Database connection settings for calendar */
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'calendar';
$mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);
