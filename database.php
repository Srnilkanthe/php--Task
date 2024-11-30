<?php

$hostName = "demodb.chyui6cgyfj6.ap-south-1.rds.amazonaws.com";
$dbUser = "admin";
$dbPassword = "123456789";
$dbName = "DemoDb";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$conn) {
    die("Something went wrong;");
}

?>