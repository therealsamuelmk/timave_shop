<?php
include "../backend/connection.php";
session_start();
if(!isset($_SESSION["SELLER_SESSION"]))
{
    header("location:login.php");
}
else{ 
    if(isset($_POST["post_item"]))
    {
        $item_name = $_POST["item_name"];
        $item_description = $_POST["item_description"];
        $item_price = $_POST["item_price"];
        $item_quantity = $_POST["item_quantity"];

        $picture = $_FILES["item_photo"]["name"];
        $tempname = $_FILES["item_photo"]["tmp_name"];
        $folder = "../images/item_photos/" .$picture; 

        $upload = "INSERT INTO ITEM(ITEM_ID,USER_ID,ITEM_NAME,ITEM_DESCRIPTION,ITEM_PRICE,ITEM_QUANTITY,ITEM_PICTURE) VALUES('".md5($item_description)."','".$_SESSION["SELLER_SESSION"]."','".$item_name."','".$item_description."','".$item_price."','".$item_quantity."','".$picture."')";
        $enterd = mysqli_query($connect,$upload);
        move_uploaded_file($tempname,$folder);
        header("location:index.php");

    }
} 

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Developed by Microlasan Technolgies">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="./css/post_item.css">
    <link href="../images/timave.jpg" rel="shortcut icon">
	<title>Timave</title>
</head>
<body>
	<form method="post" autocomplete="off" enctype="multipart/form-data">
        <div class="container">
            <input type="file" id="file" name="item_photo" accept="image/*" hidden>
            <div class="img-area" data-img="">
                <i class='bx bxs-cloud-upload icon'></i>
                <h3>Upload Image</h3>
                <p>Image size must be less than <span>5MB</span></p>
            </div>
            <button class="select-image">Select Image</button>
            <br>
            <input type="text"  class="input" name="item_name" placeholder="Item Name" required>
            <textarea placeholder="Item Descrption" name="item_description" required></textarea>
            <input type="number"  class="input" name="item_price" placeholder="Item Price" min="1" required>
            <input type="number"  class="input" name="item_quantity" placeholder="Item Quantity" min="0"  required>
            <button class="submit" type="submit" name="post_item">Post Product</button>
            <br>
            <a class="discard" href="admin.php">Discard Post</a>
        </div>
    </form>

	
	<script src="./js/post_item.js"></script>
</body>
</html>