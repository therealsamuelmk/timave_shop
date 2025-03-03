<?php
  include "../backend/connection.php";
  session_start();
  if(!isset($_SESSION["USER_SESSION"]))
  {
      header("location:login.php");
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shopping Cart Checkout</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/cart.css" rel="stylesheet" type="text/css">
    <meta name="description" content=" developed by Microlasan Technologies">
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');
      *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
      }

        body {
          font-family: 'Arial', sans-serif;
          background-color: #f4f4f4;
        }

        header {
          background-color: #F4730B;
          color: #fff;
          text-align: center;
          padding: 1rem;
        }

        .cart-container {
          max-width: 800px;
          margin: 20px auto;
          background-color: #fff;
          padding: 20px;
          border-radius: 8px;
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .item {
          display: flex;
          margin-bottom: 20px;
          border-bottom: 1px solid #eee;
          padding-bottom: 10px;
        }

        .item img {
          width: 90%;
          height: 200px;
          border-radius: 20px;
          object-fit: cover;
          margin-right: 10px;
        }

        .item-info {
          flex-grow: 1;
        }

        .item-info h3 {
          margin-bottom: 5px;
          font-size: 1.2rem;
        }

        .item-info p {
          margin-bottom: 10px;
          color: #666;
        }

        .item-price {
          font-size: 1.2rem;
        }

        .total {
          margin-top: 20px;
          font-size: 1.5rem;
          text-align: right;
        }

        .checkout-btn {
          display: block;
          width: 100%;
          padding: 10px;
          background-color: #F4730B;
          color: #fff;
          text-align: center;
          text-decoration: none;
          border: none;
          border-radius: 5px;
          cursor: pointer;
          font-size: 1.2rem;
          margin-top: 20px;
        }
        .return-btn {
          display: block;
          width: 100%;
          padding: 10px;
          background-color: #e50914;
          color: #fff;
          text-align: center;
          text-decoration: none;
          border: none;
          border-radius: 5px;
          cursor: pointer;
          font-size: 1.2rem;
          margin-top: 20px;
        }
        a{
          color: #fff;
          text-decoration: none;
        }

        @media (max-width: 600px) {
          .item {
            flex-direction: column;
            align-items: center;
          }

          .item img {
            margin-right: 0;
            margin-bottom: 10px;
          }
        }
    </style>
    <link href="../images/timave.jpg" rel="shortcut icon">
</head>
<body>
<main>
  <header>
    <h1>Shopping Cart Checkout</h1>
  </header>

  <div class="cart-container">
    <?php
        $amount = 0;
        $find_items = "SELECT * FROM CART WHERE USER_ID = '".$_SESSION["USER_SESSION"]."'";
        $execute_query = mysqli_query($connect,$find_items);
        while($items_found = mysqli_fetch_array($execute_query))
        {
          
          if($items_found == null)
          {
            
            echo("
              <script>
                  alert('Sorry you dont have items in the cart');
                  window.location.assign('profile.php');
              </script>
              "
              );
          }
          else{
            $locate_item = "SELECT * FROM ITEM WHERE ITEM_ID = '".$items_found["ITEM_ID"]."'";
            $query = mysqli_query($connect, $locate_item);
            while($item_located = mysqli_fetch_array($query))
            {
              $total = $items_found["QUANTITY"] * $item_located["ITEM_PRICE"] ;
              ?>
                <div class="item">
                  <img src="../images/item_photos/<?php echo($item_located["ITEM_PICTURE"]);?>" alt="Item 1">
                  <div class="item-info">
                    <h3><?php echo($item_located["ITEM_NAME"]);?> x <?php echo($items_found["QUANTITY"]);?></h3>
                  </div>
                  <div class="item-price">ZMW <?php echo($total);?> </div> 
                  <a class="checkout-btn" href="checkout.php?id=<?php echo($item_located["ITEM_ID"]) ?>">Buy Now</a>
                </div>
              <?php
              $amount = $amount+$total;
            }
          }
        }
    ?>

    <div class="total">
      <strong>Total: ZMW <?php echo($amount);?></strong>
    </div>

    <a class="return-btn" href="profile.php">Cancel Checkout</a>
  </div>
  </main>
</body>
</html>