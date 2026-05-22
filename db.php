<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "quizz_app";

$conn = mysqli_connect(
    $host,
    $user,
    $password,
    $database
);

if(!$conn){

    die("Kết nối database thất bại");

}

?>