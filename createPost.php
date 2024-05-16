<?php 
include("connection.php");
session_start();
$user_id = $_SESSION['userId'];

if(!$user_id){
    header("location:login.php");
}
if(isset($_POST['post'])){
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_FILES['image'];
    $fileName = $image['name'];
    $fileTmpName = $image['tmp_name'];
    $fileSize = $image['size'];
    $fileError = $image['error'];
    $fileExt = explode('.',$fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowedExt = array('jpg','jpeg','png','jfif','webp');


    if(!empty($name) && !empty($price) && !empty($image)){
        if(in_array($fileActualExt,$allowedExt)){
            if($fileError === 0 ){
                if($fileSize < 100000000){

                    $fileNameNew = uniqid('',true).".".$fileActualExt;
                    $fileDestination = 'images/'.$fileNameNew;
                    move_uploaded_file($fileTmpName,$fileDestination);

                    $addPost = "INSERT INTO products (user_id,name,img,price)
                    VALUES ('$user_id','$name','$fileNameNew','$price')";
                    $addPost_run = mysqli_query($conn,$addPost);
                    
                    if($addPost_run){
                        header("location:index.php");
                    }else{
                        echo "<script> alert('Post is not posted ')</script>";
                
                    }

                }else{
                echo "<script> alert('File is to big ')</script>";

                }
            }else{
            echo "<script> alert('Error uploading the file ')</script>";
        }
        }else{
            echo "<script> alert('This type of image in not suported ')</script>";
        }
    }else{
        echo "<script> alert('Please do not leave empty fields ')</script>";
    }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>
    
<?php include("includes/header.php")?>


<div class="container">
        <form action="" method="post" enctype="multipart/form-data">
            <h1>Create your own post </h1>
            <input type="hidden" name="user_id" value="<?php if(isset($_GET['user_id'])){echo "$_GET[user_id]";}?>" >
            <input type="text" name="name" placeholder="Enter product name">
            <input type="text"  name="price" placeholder="Enter product price" >
            <input type="file" name="image">
            <input type="submit" class="btn btn-primary" name="post">
            <a href="index.php" class="btn btn-danger"> Cancel</a>

        </form>
    </div>

    <?php include("includes/footer.php");?>
</body>
</html>