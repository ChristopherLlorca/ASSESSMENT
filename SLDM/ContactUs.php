<style>
 
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .message-box {
            margin-top: 100px;
            text-align: center;
        }

        h2 {
            color: #333;
            margin-top: 10%;
        }

        a {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: white;
            background-color: #000000;
            padding: 8px 15px;
            border-radius: 4px;
        }

        a:hover {
            background-color: #6b6b6b;
        }
    </style>
</style>
<?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "product_db";

            //create connection

            $conn = new mysqli(hostname: $servername, username: $username, 
            password: $password, database: $database);

            //check connection
            if ($conn->connect_error){
                die ("connection failed: " . $conn->connect_error);
            }
                 
            $name = $_GET['name'];
            $email = $_GET['email'];
            $contactnum = $_GET['contactnum'];
            $subject = $_GET['subject'];
            $message = $_GET['message'];

            $sql = "INSERT INTO contact_us (name, email, contactnum, subject, message) 
            VALUES ('$name', '$email', '$contactnum', '$subject', '$message')";

            if ($conn->query(query:$sql) === TRUE){
                echo "<center><h2>Thank you for reaching out to us, ". ($name).
                "! We'll be back to you soon. </h2>";
                echo "<a href='home.html'>Go Back</a></center>";
            } else{
                echo "Error: ". $sql . "<br>". $conn->error;
            }

            $conn->close();
        ?>
        