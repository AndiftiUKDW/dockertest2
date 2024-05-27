<?php
$hostname = getenv('db_host');
$username = getenv('db_user');
$password = getenv('db_pass');
$db = getenv('db_name');
$conn = mysqli_connect($hostname,$username,$password,$db);
?>