<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');

class mon {
    private $db;
    private $fm;

    public function __construct(){
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function insert_mon($data, $files){
        $name_mon = mysqli_real_escape_string($this->db->link, $data['name_mon']);
        $loaimon = mysqli_real_escape_string($this->db->link, $data['loaimon']);
        $gia = mysqli_real_escape_string($this->db->link, $data['gia']);
        $ghichu = mysqli_real_escape_string($this->db->link, $data['ghichu']);
        $tinhtrang = mysqli_real_escape_string($this->db->link, $data['tinhtrang']);

        $permited = array('jpg', 'jpeg', 'png', 'gif');

        if (!isset($_FILES['image']) || $_FILES['image']['name'] == "") {
            return "Not enough information has been entered.";
        }

        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_temp = $_FILES['image']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $uploaded_image = "../images/food/" . $unique_image;

        if ($name_mon == "" || $loaimon == "" || $gia == "" || $tinhtrang == "") {
            return "Not enough information has been entered.";
        } else {
            move_uploaded_file($file_temp, $uploaded_image);
            $query = "INSERT INTO monan(name_mon, id_loai, gia_mon, ghichu_mon, images, tinhtrang) 
                      VALUES('$name_mon', '$loaimon', '$gia', '$ghichu', '$unique_image', '$tinhtrang')";
            $result = $this->db->insert($query);
            if ($result) {
                return "<span class='success'>Success</span>";
            } else {
                return "<span class='error'>Error</span>";
            }
        }
    }

    public function show_mon(){
        $query = "SELECT monan.*, loai_mon.name_loai 
                  FROM monan 
                  INNER JOIN loai_mon ON monan.id_loai = loai_mon.id_loai 
                  ORDER BY monan.id_mon DESC";
        return $this->db->select($query);
    }

    public function show_monid($id){
        $query = "SELECT monan.*, loai_mon.name_loai 
                  FROM monan 
                  INNER JOIN loai_mon ON monan.id_loai = loai_mon.id_loai 
                  WHERE monan.id_mon = '$id'
                  ORDER BY monan.id_mon DESC";
        return $this->db->select($query);
    }

    public function update_mon($data, $files, $id) {
        $name_mon = mysqli_real_escape_string($this->db->link, $data['name_mon']);
        $id_loai = mysqli_real_escape_string($this->db->link, $data['id_loai']);
        $tinhtrang = mysqli_real_escape_string($this->db->link, $data['tinhtrang']);
        $gia = mysqli_real_escape_string($this->db->link, $data['gia']);
        $ghichu = mysqli_real_escape_string($this->db->link, $data['ghichu']);
        $special = mysqli_real_escape_string($this->db->link, $data['special']); // ✅ Lấy giá trị special
    
        $permited = array('jpg', 'jpeg', 'png', 'gif');
    
        if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_temp = $_FILES['image']['tmp_name'];
    
            $div = explode('.', $file_name);
            $file_ext = strtolower(end($div));
            $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
            $uploaded_image = "../images/food/" . $unique_image;
    
            if ($file_size > 2000000) {
                return "<span class='error'>Ảnh phải nhỏ hơn 2MB!</span>";
            } elseif (!in_array($file_ext, $permited)) {
                return "<span class='error'>Chỉ cho phép ảnh có định dạng: " . implode(',', $permited) . "</span>";
            }
    
            move_uploaded_file($file_temp, $uploaded_image);
    
            $query = "UPDATE monan SET 
                        name_mon = '$name_mon',
                        id_loai = '$id_loai',
                        gia_mon = '$gia',
                        ghichu_mon = '$ghichu',
                        images = '$unique_image',
                        tinhtrang = '$tinhtrang',
                        special = '$special' -- ✅ Thêm special vào câu lệnh UPDATE
                      WHERE id_mon = '$id'";
        } else {
            $query = "UPDATE monan SET 
                        name_mon = '$name_mon',
                        id_loai = '$id_loai',
                        gia_mon = '$gia',
                        ghichu_mon = '$ghichu',
                        tinhtrang = '$tinhtrang',
                        special = '$special' -- ✅ Thêm special vào câu lệnh UPDATE
                      WHERE id_mon = '$id'";
        }
    
        $result = $this->db->update($query);
        if ($result) {
            return "<span class='success'>Cập nhật thành công!</span>";
        } else {
            return "<span class='error'>Cập nhật thất bại!</span>";
        }
    }
    
    

    public function del_mon($id){
        $query = "DELETE FROM monan WHERE id_mon = '$id'";
        $result = $this->db->delete($query);
        if ($result) {
            return "<span class='success'>Success!</span>";
        } else {
            return "<span class='error'>Error!</span>";
        }
    }

    public function getmonbyid($id){
        $query = "SELECT * FROM monan WHERE id_mon = '$id'";
        return $this->db->select($query);
    }

    public function getmonbyloai($id){
        $query = "SELECT * FROM monan WHERE id_loai = '$id' AND tinhtrang = 1";
        return $this->db->select($query);
    }

    public function getmonkey($key){
        $k = "'%" . $key . "%'";
        $k2 = "'" . $key . "%'";
        $query = "SELECT * FROM monan 
                  WHERE (name_mon LIKE $k OR name_mon LIKE $k2) AND tinhtrang = 1";
        return $this->db->select($query);
    }

    public function get_detail($id) {
        $query = "SELECT monan.*, loai_mon.name_loai 
                  FROM monan 
                  INNER JOIN loai_mon ON monan.id_loai = loai_mon.id_loai  
                  WHERE monan.id_mon = '$id'";
    
        // Kiểm tra kết quả trả về từ câu truy vấn
        $result = $this->db->select($query);
        if ($result) {
            return $result;  // Nếu có dữ liệu, trả về kết quả
        } else {
            return false;  // Nếu không có dữ liệu, trả về false
        }
    }
    

    // Lấy tất cả món ăn có phân trang
public function getAllMon_limit($start_from, $limit){
    $query = "SELECT * FROM monan LIMIT $start_from, $limit";
    return $this->db->select($query);
}

public function countAllMon(){
    $query = "SELECT COUNT(*) as total FROM monan";
    $result = $this->db->select($query);
    $row = $result->fetch_assoc();
    return $row['total'];
}

// Lấy món ăn theo loại có phân trang
public function getmonbyloai_limit($id_loai, $start_from, $limit){
    $query = "SELECT * FROM monan WHERE id_loai = '$id_loai' LIMIT $start_from, $limit";
    return $this->db->select($query);
}

public function countMonByLoai($id_loai){
    $query = "SELECT COUNT(*) as total FROM monan WHERE id_loai = '$id_loai'";
    $result = $this->db->select($query);
    $row = $result->fetch_assoc();
    return $row['total'];
}



}
?>
