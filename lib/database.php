<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../config/config.php');

?>


<?php
 
Class Database{
   public $host   = DB_HOST;
   public $user   = DB_USER;
   public $pass   = DB_PASS;
   public $dbname = DB_NAME;
 
   public $link;
   public $error;
 
 public function __construct(){
  $this->connectDB();
  
 }
 
private function connectDB() {
    $mysqli = mysqli_init();

    // Thiết lập SSL - không cần chỉ định cert nếu không yêu cầu verify CA
    $mysqli->ssl_set(NULL, NULL, NULL, NULL, NULL);

    // Kết nối sử dụng SSL
    if (!$mysqli->real_connect($this->host, $this->user, $this->pass, $this->dbname, DB_PORT, NULL, MYSQLI_CLIENT_SSL)) {
        $this->error = "Connection failed: " . $mysqli->connect_error;
        return false;
    }

    $this->link = $mysqli;
    return true;
}

 
// Select or Read data
public function select($query){
  $result = $this->link->query($query) or 
   die($this->link->error.__LINE__);
  if($result->num_rows > 0){
    return $result;
  } else {
    return false;
  }
 }
 
// Insert data
public function insert($query){
   $insert_row = $this->link->query($query) or 
     die($this->link->error.__LINE__);
   if($insert_row){
     return $insert_row;
   } else {
     return false;
    }
 }
  
// Update data
 public function update($query){
   $update_row = $this->link->query($query) or 
     die($this->link->error.__LINE__);
   if($update_row){
    return $update_row;
   } else {
    return false;
    }
 }
  
// Delete data
 public function delete($query){
   $delete_row = $this->link->query($query) or 
     die($this->link->error.__LINE__);
   if($delete_row){
     return $delete_row;
   } else {
     return false;
    }
   }
 
}
?>


 
