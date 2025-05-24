<?php 
    $server = 'localhost';
    $user = 'root';
    $pass = '';
    $database ='gs_restaurant';

    $conn= new mysqli($server,$user,$pass,$database);
    if($conn){
        mysqli_query($conn, " SET NAMES 'utf8' ");
    }else{
        echo "ket noi khong thnah coong";
    }

