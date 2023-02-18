<?php

    try {
        $host = "localhost";
        $dbname = "project";
        $username = "root";
        $password = "";
        $conn = new PDO("mysql: host=$host; dbname=$dbname; charset=utf8", $username, $password);
    } catch (PDOException $e) {
        die ("Lỗi: " . $e->getMessage());
    }

?>