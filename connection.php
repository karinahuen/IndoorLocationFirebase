<?php

    // $servername = "localhost";
    $hostname = "localhost"; //Defaults to mysqli.default_host
    $username = "karen";
    $password = "fypkko";
    $database = "fypMysql"; //Defaults to "" 
    $port = "3306"; //Defaults to mysqli.default_port
    $socket = "/cloudsql/indoorlocationproject:us-central1:fypid";

    date_default_timezone_set('Asia/Hong_Kong');


    // Create connection
    $conn = mysqli_connect($hostname, $username, $password, $database, $port, $socket);

    // $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) 
        die("Connection failed: " . $conn->connect_error);


?>