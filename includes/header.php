<?php 
include("connection.php");
$user_id = $_SESSION['userId'];

if(!$user_id){
    header("location:login.php");
}
else{$getUser = "SELECT * FROM user WHERE id ='$user_id' ";
    $getUserResult = mysqli_query($conn,$getUser);
    $userData = mysqli_fetch_array($getUserResult);}

?>


<nav class="navbar">

    <div class="left-side">
    
        <div class="nav-options">
            <ul class="nav-menu">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="createPost.php?user_id=<?php echo"$userData[id]";?>">Create Post</a></li>
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="manageBook.php?user_id=<?php echo"$userData[id]";?>">Manage Books</a></li>
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="updateProfile.php?user_id=<?php echo"$userData[id]";?>">Update profile</a></li>
                <li class="nav-item"><a href="logout.php" class="nav-link">Logout</a></li>
            </ul>

        </div>
    </div>

    <div class="hamburger">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
    </div>

</nav>