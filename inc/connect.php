<?php 
    $server = 'nhahangkpup.mysql.database.azure.com';
    $user = 'nhahangkpup';
    $pass = 'Linh3011';
    $database ='nhahangkpup';

    $conn= new mysqli($server,$user,$pass,$database);
    if($conn){
        mysqli_query($conn, " SET NAMES 'utf8' ");
    }else{
        echo "ket noi khong thnah coong";
    }

