<?php 

    $dsn = 'mysql:host=localhost;dbname=chat';
    $name = 'root';
    $pass = '';
    $option = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    );

    try {

        $con = new PDO($dsn,$name,$pass,$option);
        $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        // echo 'You Are Connected';

    } catch(PDOException $e) {

        echo "Error $e";
    }