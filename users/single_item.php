<?php
    //adding the connection API
    include "../backend/connection.php";
    //including the session to the page onload
    session_start();
    if(!isset($_SESSION["USER_SESSION"]))
    {
        header("location:login.php");
    }
    //checking if the item id was set
    if (isset($_GET['id'])) {
        $item_id = $_GET['id'];
        // Fetch the specific item from the database
        $sql = "SELECT * FROM ITEM WHERE ITEM_ID = '".$item_id."'";
        $result = mysqli_query($connect,$sql);
        $item = mysqli_fetch_array($result);
    } 
    else {
        echo "Invalid request.";
        header("location:shop.php");
    }
?>
<!DOCTYPE html>
<!-- Coding by microlasan -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> Timave </title>
    <link rel="stylesheet" href="../css/single_item.css">
    <meta name="description" content=" developed by Microlasan Technologies">
    <link href="../images/timave.jpg" rel="shortcut icon">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
  <div class="product-card">
    <div class="logo-cart">
      <a href="../users/shop.php#<?php echo($item["ITEM_ID"]) ?>"><i class='bx bx-arrow-back'></i></a>
    </div>
    <div class="main-images">
      <img id="blue" class="blue active" src="../images/item_photos/<?php echo($item["ITEM_PICTURE"]) ?>" alt="blue">
      <img id="pink" class="pink" src="images/pink.png" alt="blue">
      <img id="yellow" class="yellow" src="images/yellow.png" alt="blue">
    </div>
    <div class="shoe-details">
      <span class="shoe_name"><?php echo($item["ITEM_NAME"]) ?></span>
      <p><?php echo($item["ITEM_DESCRIPTION"]) ?></p>
      <div class="stars">
        <i class='bx bxs-star' ></i>
        <i class='bx bxs-star' ></i>
        <i class='bx bxs-star' ></i>
        <i class='bx bxs-star' ></i>
        <i class='bx bx-star' ></i>
      </div>
    </div>
    <form method="post">
    <div class="color-price">
      <div class="color-option">
        <span class="color">Quantity:</span>
        <div class="circles">
          <input type="number" name="quantity" min="1" value="1">
        </div>
        <style>
          input[type="number"] {
            width: 60px;
            border-radius: 5px;
            padding: 5px; 
            box-sizing: border-box;
          }
        </style>
      </div>
      <div class="price">
        <span class="price_num">ZMW <?php echo($item["ITEM_PRICE"]) ?></span>
      </div>
    </div>
    <div class="button">
      <div class="button-layer"></div>
      <button type="submit" name="add_to_cart">Add to Cart <i class='bx bx-shopping-bag'></i></button>
    </div>
    </form>
  </div>
</body>
</html>
<?php
  if(isset($_POST["add_to_cart"]))
  {
    $num = mysqli_query($connect,"SELECT * FROM ITEM WHERE ITEM_ID = '".$item_id."' ");
    $verify = mysqli_fetch_array($num);
    if($verify["ITEM_QUANTITY"] < $_POST["quantity"])
    {
      echo("
        <script>
          alert('Sorry, Your order exceeds the quantity availbale');
        </script>
      ");
    }
    else{
      if($execute = mysqli_query($connect, "INSERT INTO CART(USER_ID,ITEM_ID,QUANTITY) VALUES('".$_SESSION["USER_SESSION"]."','".$item["ITEM_ID"]."','".$_POST["quantity"]."')"))
    {
      ?>
        <script>
          alert("<?php echo($item["ITEM_NAME"]) ?> has been added to your cart");
          window.location.assign("shop.php");
        </script>
      <?php
    }
    else{
      ?>
        <script>
          alert("Sorry could not add to cart, try later");
        </script>
      <?php
    }
    }
    
  }
?>