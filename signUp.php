<?php
include("connection.php");
if(isset($_POST['signUp'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cPassword = $_POST['cPassword'];

    $checkUser = "SELECT * FROM user WHERE email = '$email' ";
    $checkUserResult = mysqli_query($conn,$checkUser);

    if(mysqli_num_rows($checkUserResult) > 0){
        echo "<script> alert('User already exists'); </script>";
    }
    else {
        if ($password == $cPassword && !empty($name) && !empty($email) && !empty($password) && !empty($cPassword)){
            $insert = "INSERT INTO user (name,email,password) VALUES ('$name','$email','$password')";
            $insertResult = mysqli_query($conn,$insert);
            header("location:login.php");
        }
        else{
            echo "<script> alert('Passwords does not match or empty fields ')</script>";
        }
    }

}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <form action="" method="post">
            <h1>REGISTER NOW</h1>
            <input type="text" name="name" placeholder="Enter your name" >
            <input type="email" name="email" placeholder="Enter your email" >
            <input type="password" name="password" placeholder="Enter your password" >
            <input type="password" name="cPassword" placeholder="Enter your password again" >
            <input type="submit" name="signUp" value="Sign Up" class="btn btn-primary">
            <p>Already have an account<a href="login.php">Login</a></p>



        </form>
    </div>
</body>
</html>