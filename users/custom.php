<?php
include "../backend/connection.php";
session_start();
if(!isset($_SESSION["USER_SESSION"]))
{
    header("location:login.php");
}
else{
    if(isset($_POST["custom_button"]))
    {
        //capturing the data entered in the fields
        $shirt_size= $_POST["shirt-size"];
        $print_size = $_POST["print-size"];
        $custom_text= $_POST["custom-text"];
        $shirt_color = $_POST["shirt-color"];


        $picture = $_FILES["custom-image"]["name"];
        $tempname = $_FILES["custom-image"]["tmp_name"];
        $folder = "../images/custom/" .$picture; 

        $register = "INSERT INTO CUSTOM_SHIRT(USER_ID,	SHIRT_SIZE,	CUSTOM_PICTURE,	PRINT_SIZE,	CUSTOM_TEXT,	SHIRT_COLOR) VALUES('".$_SESSION["USER_SESSION"]."','".$shirt_size."','".$picture."','".$print_size."','".$custom_text."','".$shirt_color."') ";
        $enterd = mysqli_query($connect,$register);
        if(!$enterd)
        {
          ?>
            <script>
              alert("Sorry could not place order because: <?php echo(mysqli_error($connect)) ?> ");
            </script>
          <?php
        }
        else{
          move_uploaded_file($tempname,$folder);
          ?>
            <script>
              alert("Congratulations, you have successfully placed an order for a custom shirt");
            </script>
          <?php
        }
         
    }
}
?>
<!DOCTYPE html>
<!-- Coding By microlasan -->
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content=" developed by Microlasan Technologies">
    <title> Timave </title>
    <!---Custom Css File!--->
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="stylesheet" href="../css/shop.css">
    <link rel="stylesheet" href="../css/custom_shirt.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet"/>
    <link href="../images/timave.jpg" rel="shortcut icon">
  </head>
  <body>
    <div class="msg">Sorry this app is only available for mobile phones</div>
    <main>
      <section class="main">
            <div class="form-container">
                <h1>Customize Your Shirt</h1>
                <form action="#" method="post" autocomplete="off" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="shirt-size">Shirt Size</label>
                            <select id="shirt-size" name="shirt-size" required>
                            <option value="small">Small</option>
                            <option value="medium">Medium</option>
                            <option value="large">Large</option>
                            <option value="xl">XL</option>
                            <option value="xxl">XXL</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="custom-image">Upload Custom Image</label>
                        <input type="file" id="custom-image" name="custom-image" accept="image/*" required>
                    </div>
                    <div class="form-group">
                        <label for="print-size">Print Size</label>
                        <select id="print-size" name="print-size" required>
                            <option value="a4">A4</option>
                            <option value="a3">A3</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="custom-text">Custom Text</label>
                        <input type="text" id="custom-text" name="custom-text" placeholder="Enter your text" required>
                    </div>
                    <div class="form-group">
                        <label for="shirt-color">Shirt Color</label>
                        <input type="color" id="shirt-color" name="shirt-color" value="#000000" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="custom_button">Submit</button>
                    </div>
                </form>
            </div>
      </section>
        <nav class="nav">
            <a class="nav-link" href="shop.php">
                <i class="ri-shopping-bag-line"></i>
                <span class="nav-text">Shop</span>
            </a>
            <a class="nav-link active" href="custom.php">
                    <i class="ri-scissors-cut-fill"></i>
                    <span class="nav-text">Custom</span>
            </a>
            <a class="nav-link" href="history.php">
                <i class="ri-history-line"></i>
                <span class="nav-text">History</span>
            </a>
            <a class="nav-link" href="profile.php">
                <i class="ri-user-3-line"></i>
                <span class="nav-text">Profile</span>
            </a>
        </nav>
    </main>
  </body>
</html>