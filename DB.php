<?php
    function dbconn(){
        $server = "localhost";
        $username = "root";
        // riccharl_scent
        $password = "";
        // ZSXr]@P]NpS$
        $db = "scent";
        // riccharl_scent
        $conn = null;
        
        try {
            $conn = new PDO("mysql:host=$server;dbname=$db", $username, $password);
            // Set PDO to throw exceptions on error
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
        } catch (PDOException $err) {
            // Handle connection error
            echo "Connection failed: " . $err->getMessage();
            // Exit or perform appropriate action
            return null;
            exit();
        }

    }
        // WGHQ~2EN~boP

?>