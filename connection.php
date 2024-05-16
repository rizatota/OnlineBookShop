<?php

$host = "localhost";
$username = "root";
$password = "";
$dbName = "ecommerce";

$conn = mysqli_connect("$host","$username","$password","$dbName");

if(!$conn){
    die("Can not connect to the database");
}