<?php 
   $server = 'sql309.infinityfree.com';
    $user = 'if0_39066208';
    $pass = 'Linh3011';
    $database ='if0_39066208_gs_restaurant';

    $conn= new mysqli($server,$user,$pass,$database);
    if($conn){
        mysqli_query($conn, " SET NAMES 'utf8' ");
    }else{
        echo "ket noi khong thnah coong";
    }

