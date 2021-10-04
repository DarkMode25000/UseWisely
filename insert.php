<?php
if (isset($_POST['submit'])) {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        
        $username = $_POST['username'];
        $password = $_POST['password'];

        $host = "";                         //Host link here
        $dbUsername = "";                   //Username here
        $dbPassword = "";                   //Password here
        $dbName = "";                       //Database Name here(usually same as username)

        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else 
        {
            $Select = "SELECT username FROM register WHERE username = ? LIMIT 1";
            $Insert = "INSERT INTO register(username, password) values(?, ?)";

            $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result($username);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;

            if ($rnum == 0) {
                $stmt->close();
                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("ss",$username, $password);
                if ($stmt->execute()) {
                    echo "Thanks for registering. We'll get back to you regarding your subscription.";
                    echo "<script> location.href='https://javahelp.netlify.app/programs.html' </script>";
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "Someone already registered using this username.";
            }
            $stmt->close();
            $conn->close();
        }
    }
    else 
    {
        echo "All field are required.";
        die();
    }
}
else {
    echo "Submit button is not set";
}
?>
