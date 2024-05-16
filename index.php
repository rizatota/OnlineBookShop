<?php 
include("connection.php");
session_start();
$user_id = $_SESSION['userId'];

if(!$user_id){
    header("location:login.php");
}
else{$getUser = "SELECT * FROM user WHERE id ='$user_id' ";
    $getUserResult = mysqli_query($conn,$getUser);
    $userData = mysqli_fetch_array($getUserResult);}


if(isset($_POST['addToCart'])){
    $product_name = $_POST['product_name'];
    $product_img = $_POST['product_img'];
    $product_price = $_POST['product_price'];
    $product_quantity = $_POST['product_quantity'];
    $product_id = $_POST['product_id'];


    $cart = "SELECT * FROM cart WHERE product_id='$product_id' AND user_id='$user_id'" ;
    $cartResult = mysqli_query($conn,$cart);    

    if(mysqli_num_rows($cartResult) > 0){
        $addProductSum = "UPDATE cart SET quantity= quantity + '$product_quantity' WHERE 
                          product_id='$product_id' AND user_id = '$user_id'";
        $addProductResult = mysqli_query($conn,  $addProductSum);

    }
    else{
        $addProduct = "INSERT INTO cart (user_id,name,price,image,quantity,product_id)
        VALUES('$user_id','$product_name',' $product_price','$product_img','$product_quantity','$product_id')";
        $addProductResult = mysqli_query($conn,  $addProduct);  
    }
}
if(isset($_GET['proId'])){
    $pro_id = $_GET['proId'];
    $remove = "DELETE FROM cart WHERE id='$pro_id' AND user_id='$user_id' ";
    $removeResult = mysqli_query($conn,$remove);
    header("location:index.php");

}
if(isset($_GET['deleteAll'])){
    $remove = "DELETE FROM cart WHERE  user_id='$user_id' ";
    $removeResult = mysqli_query($conn,$remove);
    header("location:index.php");
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<?php include("includes/header.php")?>



<div class="header">
    <div class="username">Username: <?php echo"$userData[name]"; ?></div>
    <div class="email">Email: <?php echo"$userData[email]"; ?></div>
   
</div>


<div class="products-container">
    <?php 
    $products = "SELECT * FROM products";
    $productsResult = mysqli_query($conn,$products);

    if(mysqli_num_rows($productsResult)){
        while($productsData = mysqli_fetch_assoc($productsResult)){
            
        ?>
        <form action="" method="post">
            <div class="product">  
                <img class="img" src="images/<?php echo "$productsData[img]"?>" alt="">     
                <div class="name"><?php echo "$productsData[name]"?></div>
                <div class="price">$<?php echo "$productsData[price]"?></div>
                <input type="number" min="1" name="product_quantity" value="1">
                <input type="hidden" name="product_name" value="<?php echo "$productsData[name]"?>">
                <input type="hidden" name="product_img" value="<?php echo "$productsData[img]"?>">
                <input type="hidden" name="product_price" value="<?php echo "$productsData[price]"?>">
                <input type="hidden" name="product_id" value="<?php echo "$productsData[id]"?>" >
                <input class="cart-button" type="submit" name="addToCart" value="Add to Cart">
            </div> 


        </form>
        <?php
        }
    }
    ?>
    

</div>

<div class="cart-container">

<table>
    <thead>
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
    <?php 
        $grandTotal = 0;
        $cartProducts = "SELECT * FROM cart WHERE user_id='$user_id'";
        $cartProductsResult = mysqli_query($conn,$cartProducts);
        if(mysqli_num_rows($cartProductsResult)){
            while($cartData = mysqli_fetch_assoc($cartProductsResult)){
                
            ?>
        <tr>
        <?php $totalPrice = $cartData['quantity'] * $cartData['price'];?>
            <td><img src="images/<?php echo "$cartData[image]"?>" alt=""></td>
            <td><?php echo "$cartData[name]"?></td>
            <td><?php echo "$cartData[price]"?></td>
            <td><?php echo "$cartData[quantity]"?></td>
            <td><?php echo "$totalPrice" ?> </td>
            <td><a class="btn btn-warning" href="index.php?proId=<?php echo "$cartData[id]"?>">Remove Item</a></td>
            <?php  $grandTotal += $totalPrice; ?>
        </tr>

        <?php
        }
    }
    ?>
        <tr>
            <td colspan="4">Grand Total:</td>
            <td><?php echo "$grandTotal" ?></td>
            <td><a class="btn btn-danger" href="index.php?deleteAll">Delete All</a></td>

        </tr>
    </tbody>
</table>

</div>

<?php include("includes/footer.php");?>
    


<script>
const hamburger = document.querySelector('.hamburger');
        const navMenu = document.querySelector('.nav-menu');
        
        hamburger.addEventListener("click",() =>{
            hamburger.classList.toggle("active");
            navMenu.classList.toggle("active");

        });

        document.querySelectorAll("nav-link").forEach(link => link.addEventListener(
            "click", () =>{
                hamburger.classList.remove("active");
                navMenu.classList.remove("active");
            }
        ));

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>