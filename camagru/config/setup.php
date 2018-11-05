<?php

require 'database.php';

try {
    $conn = new PDO("mysql:host=$DB_DSN", $DB_USER, $DB_PASSWORD);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE camagru";
    // use exec() because no results are returned
    $conn->exec($sql);
    echo "Database created successfully<br>";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;

try {
    $conn = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to create table
    $sql = "CREATE TABLE users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    Username VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    Passwrd VARCHAR(255) NOT NULL,
    token VARCHAR(32) NOT NULL/*,
    reg_date TIMESTAMP*/
    )";

    // use exec() because no results are returned
    $conn->exec($sql);
    echo "Table users created successfully<br>";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;

try {
    $conn = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to create table
    $sql = "CREATE TABLE images (
    `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    `image`VARCHAR(200) NOT NULL,
    `text` TEXT(30) NOT NULL
    )";

    // use exec() because no results are returned
    $conn->exec($sql);
    echo "Table images created successfully";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;
?>