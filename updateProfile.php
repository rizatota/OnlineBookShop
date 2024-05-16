<?php
session_start();
$user_id = $_SESSION['userId']; 
if(!$user_id){
    header("location:login.php");
}else{

    include("connection.php");
    if(isset($_POST['update'])){
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    if(!empty($name) && !empty($email)){
        $update = "UPDATE user SET name = '$name', email = '$email' WHERE id='$user_id'";
        $update_run = mysqli_query($conn,$update);

    }else{
        echo "<script> alert('New Password and Confirm Password must match')</script>";

    }


    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update profile</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<?php include("includes/header.php")?>


<div class="container">
    <?php if(isset($_GET['user_id'])){
        $user_id=$_GET['user_id'];
        $user = "SELECT * FROM user WHERE id = '$user_id'";
        $user_run = mysqli_query($conn,$user);
        $userData = mysqli_fetch_assoc($user_run);

    } ?>
        <form action="" method="post">
            <h1>Update Profile</h1>
            <input type="hidden" name="user_id" value="<?php echo "$userData[id]";?>" >
            <input type="text" name="name" value="<?php echo "$userData[name]";?>"  >
            <input type="email" name="email" value="<?php echo "$userData[email]";?>" >
            <input type="submit" name="update" class="btn btn-primary" value="Update">
            <a href="changePassword.php?user_id=<?php echo"$userData[id]";?>" class="btn btn-warning"> Change password</a>
            <a href="index.php" class="btn btn-danger"> Cancel</a>
            

        </form>
    </div>


    <?php include("includes/footer.php");?>
</body>
</html>