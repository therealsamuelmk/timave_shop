<?php
    include "../backend/connection.php";
    session_start();
    if(!isset($_SESSION["USER_SESSION"]))
    {
        header("location:login.php");
    }
    else{
        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get the form fields
            $name = trim($_POST["full_name"]);
            $email = trim($_POST["email"]);
            $message = trim($_POST["message"]);

            // Validate input
            if (empty($name) || empty($email) || empty($message)) {
                echo "Please fill in all fields.";
                exit;
            }

            // Construct email message
            $to = "phirialex17@gmail.com"; 
            $subject = "New message from $name";
            $body = "Name: $name\n";
            $body .= "Email: $email\n";
            $body .= "Message:\n$message";

            // Send email
            if (mail($to, $subject, $body)) {
                echo ("
                        <script>
                            alert('Message sent Successfully!.')
                            window.location.assign('contact_us.html')
                        </script>
                    ");
            } else {
                echo ("
                        <script>
                            alert('Failed to send message. Please try again later.')
                            window.location.assign('contact_us.html')
                        </script>
                    ");
                
            }
        } else {
            // If the form is not submitted, redirect to the contact page
            header("Location: contact_us.html");
        }

    }
?>