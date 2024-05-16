<?php
include("connection.php");
if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $checkUser = "SELECT * FROM user WHERE email = '$email' AND password ='$password' ";
    $checkUserResult = mysqli_query($conn,$checkUser);

    if(mysqli_num_rows($checkUserResult) > 0){
        $data = mysqli_fetch_assoc($checkUserResult);
        session_start();
        $_SESSION['userId'] = $data['id'];
        header("location:index.php");
    }
    else{
        echo "<script> alert('Incorrect email or password ')</script>";

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
            <h1>WELLCOME TO LOG IN </h1>
            <input type="email" name="email" placeholder="Enter your email" >
            <input type="password" name="password" placeholder="Enter your password" >
            <input type="submit" name="login" value="Log In" class="btn btn-primary">
            <p>Don't  have an account <a href="signUp.php" >Sign Up</a></p>

        </form>
    </div>
</body>
</html>