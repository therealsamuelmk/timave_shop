<?php
if(isset($_POST["signup_button"]))
  {
    //capturing the data entered in the fields
    $names = $_POST["full_name"];
    $phone = $_POST["phone_number"];
    $mail = $_POST["email_address"];
    $password = $_POST["password"];
    $confirm = $_POST["confirm_password"];

    //checking whether the passwords entered are matching

    if($password != $confirm)
    {
      ?>
        <script>
          alert("Sorry the passwords do not match");
        </script>
      <?php
    }
    //checking if the user already exists
    else{
      $verification = "SELECT COUNT(*) AS POSSIBLE FROM SELLER WHERE USER_PHONE_NUMBER = '".$phone."'";
      $search = mysqli_query($connect,$verification);
      $found = mysqli_fetch_array($search);
      if($found["POSSIBLE"]>0)
      {
        ?>
          <script>
            alert("This User Is Already In The System");
          </script>
        <?php
      }
      //registering the user
      else{
        //capturing the image
        $picture = $_FILES["profile_image"]["name"];
        $tempname = $_FILES["profile_image"]["tmp_name"];
        $folder = "../images/profile_photos/".$picture; 
        //encrypting the entered password to md5
        $password = md5($password); 
        $register = "INSERT INTO SELLER(USER_ID, USER_FULL_NAME,USER_PHONE_NUMBER,	USER_EMAIL_ADDRESS, PROFILE_PICTURE, USER_PASSWORD) VALUES('".md5($phone)."','".$names."','".$phone."','".$mail."','".$picture."','".$password."') ";
        $enterd = mysqli_query($connect,$register);
        if(!$enterd)
        {
          ?>
            <script>
              alert("Sorry could not register because: <?php echo(mysqli_error($connect)) ?> ");
            </script>
          <?php
        }
        else{
          move_uploaded_file($tempname,$folder);
          ?>
            <script>
              alert("Congratulations, you have successfully added a Seller");
            </script>
          <?php
        }
      }
    }
  }
  ?>