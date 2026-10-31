<?php

@include 'config.php';
@include 'header.php';

if(isset($_POST['add_product'])){

   $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
   $product_price = mysqli_real_escape_string($conn, $_POST['product_price']);
   $product_image = $_FILES['product_image']['name'];
   $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
   $product_image_folder = 'image/'.$product_image;
   $product_description = mysqli_real_escape_string($conn, $_POST['product_description']);

   if(empty($product_name) || empty($product_price) || empty($product_image) || empty($product_description)){
      $message[] = 'Please fill out all the information';
   }else{
      $insert = "INSERT INTO products(name, price, image, description) VALUES('$product_name', '$product_price', '$product_image', '$product_description')";
      $upload = mysqli_query($conn, $insert);

      if($upload){
         move_uploaded_file($product_image_tmp_name, $product_image_folder);
         $message[] = 'New product added successfully';
      }else{
         $message[] = 'Could not add the product';
      }
   }
}

if(isset($_GET['delete'])){
   $id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM products WHERE id = $id");
   header('location:admin1.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Page</title>

   <link rel="stylesheet" href="admin1.css">

</head>
<body>

<?php
// Display any messages
if(isset($message)){
   foreach($message as $message){
      echo '<span class="message">'.$message.'</span>';
   }
}
?>

<div class="container">

   <!-- Form to add a new product -->
   <div class="admin-product-form-container">
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
         <h3>Add a New Product</h3>
         <input type="text" placeholder="Enter product name" name="product_name" class="box">
         <input type="number" placeholder="Enter product price" name="product_price" class="box">
         <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
         <input type="text" placeholder="Enter product description" name="product_description" class="box">
         <input type="submit" class="btn" name="add_product" value="Add Product">
      </form>
   </div>

   <!-- Display existing products -->
   <div class="product-display">
      <table class="product-display-table">
         <thead>
            <tr>
               <th>Product Image</th>
               <th>Product Name</th>
               <th>Product Price</th>
               <th>Product Description</th>
               <th>Action</th>
            </tr>
         </thead>
         <?php
         $select = mysqli_query($conn, "SELECT * FROM products");
         while($row = mysqli_fetch_assoc($select)){ ?>
         <tr>
            <td><img src="image/<?php echo $row['image']; ?>" height="100" alt="Product Image"></td>
            <td><?php echo $row['name']; ?></td>
            <td>$<?php echo $row['price']; ?>/-</td>
            <td><?php echo $row['description']; ?></td>
            <td>
               <a href="admin1.php?delete=<?php echo $row['id']; ?>" class="btn"><i class="fas fa-trash"></i> Delete</a>
            </td>
         </tr>
         <?php } ?>
      </table>
   </div>

</div>

</body>
</html>
