<?php
    function dbconn(){
        $server = "	sql200.byethost7.com";
        // $username = "root";
        $username = "b7_36872746";
        // riccharl_scent
        $password = "ErickaValenzona_12345";
        // ZSXr]@P]NpS$
        $db = "b7_36872746_scent";
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