<?php
$filepath= realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/database.php');
include_once ($filepath.'/../helpers/format.php');
?>
<?php

class khuyenmai {
    private $db ;
    private $fm ;

    public function __construct(){
        $this->db = new Database();
        $this->fm = new Format(); 
    }
    public function insert_km($data,$files)   
    {
        $time_star=$this->fm->formatDate($data['time_star']);
        $time_end=$this->fm->formatDate($data['time_end']);

        $name_km = mysqli_real_escape_string($this->db->link,$data['name_km']);
        $time_star = mysqli_real_escape_string($this->db->link,$data['time_star']);
        $time_end = mysqli_real_escape_string($this->db->link,$data['time_end']);
        $discout = mysqli_real_escape_string($this->db->link,$data['discout']);
        $ghichu = mysqli_real_escape_string($this->db->link,$data['ghichu']);
        // $image = mysqli_real_escape_string($this->db->link,$data['name_mon']);
        //kiểm tra hình ảnh và lấy hình ảnh cho vào folder upload
        $permited = array('jpg','jpeg','png','gif');
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_temp = $_FILES['image']['tmp_name'];

        $div = explode('.',$file_name);
        $file_ext = strtolower(end($div));
        $unique_image= substr(md5(time()),0,10).'.'.$file_ext;
        $uploaded_image = "../images/food/".$unique_image;


        if($name_km==''||$discout==''){
            $alert ="Not enough information has been entered.";
            return $alert ;
        }
        else{
            move_uploaded_file($file_temp,$uploaded_image);
            $query = "INSERT INTO khuyenmai(name_km,time_star,time_end,discout,ghichu,images) VALUES('$name_km','$time_star','$time_end','$discout','$ghichu','$unique_image')";
            $result = $this->db->insert($query);
            if($result){
                $alert ="<span class='succsess'> Success</span>";
                return $alert ;
            }else{
                $alert ="<span class='succsess'> Error</span>";
                return $alert ;
            }

            }
    
    }
    public function show_km(){
    
        $query = "SELECT * FROM khuyenmai order by id_km desc" ;
        $result = $this->db->select($query);
        return $result;

    }
    public function update_km($data,$files,$id){
       
        $time_star=$this->fm->formatDate($data['time_star']);
        $time_end=$this->fm->formatDate($data['time_end']);

        $name_km = mysqli_real_escape_string($this->db->link,$data['name_km']);
        $time_star = mysqli_real_escape_string($this->db->link,$data['time_star']);
        $time_end = mysqli_real_escape_string($this->db->link,$data['time_end']);
        $discout = mysqli_real_escape_string($this->db->link,$data['discout']);
        $ghichu = mysqli_real_escape_string($this->db->link,$data['ghichu']);
        // $image = mysqli_real_escape_string($this->db->link,$data['name_mon']);
        //kiểm tra hình ảnh và lấy hình ảnh cho vào folder upload
        $permited = array('jpg','jpeg','png','gif'); // cho phép 
        $file_name = $_FILES['image']['name'];// 
        $file_size = $_FILES['image']['size'];
        $file_temp = $_FILES['image']['tmp_name'];

        $div = explode('.',$file_name); // tách tên 
        $file_ext = strtolower(end($div)); // chuyển chữ hoa thành chữ thường   
        $unique_image= substr(md5(time()),0,10).'.'.$file_ext;
        $uploaded_image = "uploads/".$unique_image;

      
        if($name_km==''||$discout==''){
            $alert ="Not enough information has been entered.";
            return $alert ;
        }
        else{  
             if(!empty($file_name)){
                 //nếu người dùng chọn ảnh
                 if($file_size> 2000000){
                     $alert="<span class='error' > Image size should be less then 2MB!</span> . echo $file_size ";
                     return $alert;
                 }
                 elseif(in_array($file_ext,$permited)==false){
                     $alert="<span class='error'> You can upload only : -".implode(',',$permited)."</span>";
                     return $alert;
                 }
                 $query ="  UPDATE khuyenmai SET 
                
                 name_km= '$name_km',
                 time_star='$time_star',
                 time_end='$time_end',
                 discout ='$discout',
                 ghichu = '$ghichu',
                 images ='$unique_image'
                 WHERE id_km='$id'";
             }else{
                 //nếu người dùng không chọn ảnh
                $query ="  UPDATE khuyenmai SET 
                 name_km= '$name_km',
                 time_star='$time_star',
                 time_end='$time_end',
                 discout ='$discout',
                 ghichu = '$ghichu'
                WHERE id_km='$id'";
             }


            $result = $this->db->insert($query);
            if($result){
                $alert ="<span class='success'> Sửa thành công!</span>";
                return $alert ;
            }else{
                $alert ="<span class='error'> Sửa không thành công</span>";
                return $alert ;
            }

        }
    }
    public function del_km($id){
        $query = "DELETE FROM  khuyenmai  Where id_km='$id'" ;
            $result = $this->db->delete($query);
            if($result){
                $alert ="<span class='success'> Success !</span>";
                return $alert ;
            }else{
                $alert ="<span class='error'> Error ! </span>";
                return $alert ;
            }

    }
    public function getkmbyid($id){
        $query = "SELECT * FROM khuyenmai where id_km='$id'" ;
        $result = $this->db->select($query);
        return $result;
    }
}

?>