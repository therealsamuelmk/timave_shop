<?php
    $connect = mysqli_connect("localhost","root","","TIMAVE");
    if(!$connect)
    {
        ?>
            <script>
                alert("sorry could not connect to the database, see webmaster");
            </script>
        <?php
    }
?>