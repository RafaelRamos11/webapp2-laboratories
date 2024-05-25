<?php

$host = "localhost"; // My Localhost name
$db = "student_record"; // My database name
$user = "root"; // My sql user
$password = ""; // Password

// require "03_php_pdo_mysql_connection.php";

$dsn = "mysql:host=$host; dbname=$db;charset=UTF8";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    $pdo = new PDO($dsn, $user, $password, $options);

    if($pdo){
        echo "Connected to the $db database successfully";

        $sql = 'SELECT * FROM customers';
        $statement = $pdo->query($sql);

        $customers = $statement->FetchAll(PDO::FETCH_ASSOC);


        echo '<pre>';
        print_r($customers);
        echo '</pre>';

    }

} catch (PDOException $e) {
    echo $e->getMessage();}
?>