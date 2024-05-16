<?php 
include("connection.php");
session_start();
$user_id = $_SESSION['userId'];

if(!$user_id){
    header("location:login.php");
}

if(isset($_POST['update'])){

    $name=$_POST['name'];
    $price=$_POST['price'];
    $fileName = $_FILES['image']['name'];
    $fileTmpName =  $_FILES['image']['tmp_name'];
    $fileSize = $_FILES['image']['size'];
    $fileError = $_FILES['image']['error'];
    $fileExt = explode('.',$fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowedExt = array('jpg','jpeg','png','jfif','webp');
    $product_id=$_POST['product_id'];
    $old_img = $_POST['old_img'];

    if(!empty($fileName) ){
        if(in_array($fileActualExt,$allowedExt)){
            
        $fileNameNew = "img-".rand(1,100000000).".".$fileActualExt;
        $fileDestination = 'images/'.$fileNameNew;
        move_uploaded_file($fileTmpName,$fileDestination);

        $post_img="UPDATE products SET img = '$fileNameNew' WHERE id='$product_id'";  
        $post_img_run=mysqli_query($conn,$post_img);

        $postCart_img="UPDATE cart SET image = '$fileNameNew' WHERE product_id='$product_id'";  
        $postCart_img_run=mysqli_query($conn,$postCart_img);

        if($post_img_run){
            header("Location:manageBook.php");
        }else{
            echo "<script>window.alert('Something went wrong')</script>";
        }
    }else{
        echo "<script>window.alert('Please fill all the fields')</script>";
    }
    }

    if(!empty($name) && !empty($price)){
        $postData="UPDATE products SET  name = '$name', price = '$price' WHERE id='$product_id'";  
        $postData_run=mysqli_query($conn,$postData);

        $postCart="UPDATE cart SET  name = '$name', price = '$price' WHERE product_id='$product_id'";  
        $postCart_run=mysqli_query($conn,$postCart);


        if($postData_run){
            header("Location:manageBook.php");
        }else{
            echo "<script>window.alert('Something went wrong')</script>";
        }
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
    <?php if(isset($_GET['product_id'])){
            $product_id=$_GET['product_id'];
            $product = "SELECT * FROM products WHERE id = '$product_id'";
            $product_run = mysqli_query($conn,$product);
            $productData = mysqli_fetch_assoc($product_run);

        } 
    ?>

        <form action="" method="post" enctype="multipart/form-data">
            <h1>Create your own post </h1>
            <input type="hidden" name="product_id" value="<?php echo"$productData[id]"; ?>" >
            <input type="hidden" name="old_img" value="<?php echo"$productData[img]"; ?>" >
            <input type="text" name="name" value="<?php echo"$productData[name]"; ?>">
            <input type="text"  name="price" value="<?php echo"$productData[price]"; ?>" >
            <img src="images/<?php echo"$productData[img]"; ?>"  alt="">
            <input type="file" name="image">
            <input type="submit" class="btn btn-primary" name="update">
            <a href="manageBook.php" class="btn btn-danger"> Cancel</a>

        </form>
    </div>

    <?php include("includes/footer.php");?>
</body>
</html>