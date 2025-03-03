<?php
  include "../backend/connection.php";
  session_start();
  if(!isset($_SESSION["USER_SESSION"]))
  {
      header("location:login.php");
  }
  $item_id = $_GET["id"];

  if(isset($item_id))
  {
    // Fetch the specific item from the database
    $sql = "SELECT * FROM ITEM WHERE ITEM_ID = '".$item_id."'";
    $result = mysqli_query($connect,$sql);
    $item = mysqli_fetch_array($result);

    // fetch current commission for seller
    $current_commision = mysqli_query($connect,"SELECT * FROM COMMISSION WHERE USER_ID = '".$item["USER_ID"]."' ");
    $cur_com = mysqli_fetch_array($current_commision);

    $sql_1 = "SELECT * FROM CART WHERE ITEM_ID = '".$item_id."'";
    $result_1 = mysqli_query($connect,$sql_1);
    $item_1 = mysqli_fetch_array($result_1);

  }
  else{
    echo(
        "
            <script>
                alert('Request Error! no item selected');
                window.location.assign('cart.php');
            </script>
        "
    );
  }
  $price = $item["ITEM_PRICE"] * $item_1["QUANTITY"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content=" developed by Microlasan Technologies">
  <title>Checkout</title>
  <link rel="stylesheet" href="../css/checkout.css">
  <link href="../images/timave.jpg" rel="shortcut icon">
</head>
<body>
  <div class="container">
    <form class="checkout-form" method="post">
      <h2>Shipping Address</h2>
      <label for="address">Address: <span class="required">*</span></label>
      <textarea id="address" name="address" ></textarea>
      <label for="city">District:<span class="required">*</span></label>
      <input type="text" id="city" name="city" >
      <label for="state">Province:<span class="required">*</span></label>
      <input type="text" id="state" name="state" >
      <label for="zip">Closest Landmark:<span class="required">*</span></label>
      <input type="text" id="zip" name="zip" >
      <button type="submit" name="buy" class="checkout">Checkout</button>
      <button type="submit" name="delete" class="delete">Delete From Cart</button>
    </form>
    <?php
      if(isset($_POST["delete"]))
      {
        $action = mysqli_query($connect, "DELETE FROM CART WHERE CART_ID = '".$item_1["CART_ID"]."'");
        ?>
            <script>
                alert('Item Deleted, locating to cart');
                window.location.assign("cart.php");
            </script>
        <?php
      }
      if(isset($_POST["buy"]))
      {
        $address = $_POST["address"];
        $district = $_POST["city"];
        $province = $_POST["state"];
        $postal = $_POST["zip"];
        //insert item in the purchase history
        $purchase_default = 'not disbursed';
        $bought = mysqli_query($connect,"INSERT INTO PURCHASE (ITEM_ID,QUANTITY,SELLER_ID,USER_ID,USER_ADDRESS,USER_DISTRICT,USER_PROVINCE,USER_POSTAL,PURCHASE_STATUS) 
        VALUES('".$item_id."','".$item_1["QUANTITY"]."','".$item["USER_ID"]."','".$_SESSION["USER_SESSION"]."','".$address."','".$district."','".$province."','".$postal."','".$purchase_default."')");
        //delete item from the card
        $remome = mysqli_query($connect,"DELETE FROM CART WHERE CART_ID = '".$item_1["CART_ID"]."'");
        //reduce the quantity
        $remaining  = $item["ITEM_QUANTITY"] - $item_1["QUANTITY"];
        $reduce = mysqli_query($connect,"UPDATE ITEM SET ITEM_QUANTITY = $remaining WHERE ITEM_ID = '".$item_1["ITEM_ID"]."'");
        echo(
          "
          <script>
            alert('Congratulations, You have successfully purchased Your Item');
            window.location.assign('profile.php');
          </script>
          " 
        ); 

      }
    ?>
    <div class="cart-item">
      <img src="../images/item_photos/<?php echo($item["ITEM_PICTURE"]) ?>" alt="Product Image">
      <div class="item-details">
        <h3><?php echo($item["ITEM_NAME"]) ?> x <?php echo($item_1["QUANTITY"] ) ?></h3>
        <p>Price: ZMW <span id="price"><?php echo($price) ?></span></p>
      </div>
    </div>
  </div>
</body>
</html>

