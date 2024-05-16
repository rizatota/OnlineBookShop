
<?php 
include("connection.php");
session_start();
$user_id = $_SESSION['userId'];

if(!$user_id){
    header("location:login.php");
}

if(isset($_POST['delete'])){
    
    $product_id = $_POST['product_id'];
    $delete = "DELETE  FROM products WHERE id = '$product_id'";
    $delete_run = mysqli_query($conn,$delete);
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Books</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
   
<?php include("includes/header.php")?>


<a href="index.php" class="btn btn-danger">Cancel</a>
<div class="products-container">

    <?php if(isset($_GET['user_id'])){
        $user_id=$_GET['user_id'];
        $user = "SELECT * FROM user WHERE id = '$user_id'";
        $user_run = mysqli_query($conn,$user);
        $userData = mysqli_fetch_assoc($user_run);

    } 

     
    $products = "SELECT * FROM products WHERE user_id = '$user_id'" ;
    $productsResult = mysqli_query($conn,$products);    

    if(mysqli_num_rows($productsResult)){
        while($productsData = mysqli_fetch_assoc($productsResult)){
            
    ?>
        <form action="" method="post">
            <div class="product">  
                <img class="img" src="images/<?php echo "$productsData[img]"?>" alt="">     
                <div class="name"><?php echo "$productsData[name]"?></div>
                <div class="price">$<?php echo "$productsData[price]"?></div>
                <a href="updateBook.php?product_id=<?php echo "$productsData[id]"?>" class="btn btn-warning">Update</a>
                <input type="submit" name="delete" class="btn btn-danger" value="Delete"> 
                <input type="hidden" name="product_id"  value="<?php echo "$productsData[id]";?>">            
            </div> 


        </form>
       
        <?php
        }
    }
    ?>
    

</div>

<?php include("includes/footer.php");?>
</body>
</html>