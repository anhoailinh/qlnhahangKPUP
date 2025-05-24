<?php
$filepath= realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/database.php');
include_once ($filepath.'/../helpers/format.php');

class User {
    private $db;
    private $fm;

    public function __construct() {
        $this->db = new Database();
        $this->fm = new Format(); 
    }

    public function login_user($sdt, $pass) {
        $sdt = $this->fm->validation($sdt);
        $pass = $this->fm->validation($pass);

        // Protect against SQL injection
        $sdt = mysqli_real_escape_string($this->db->link, $sdt);

        if (empty($sdt) || empty($pass)) {
            return "<span class='error'>Please fill in all the fields!</span>";
        } else {
            $query = "SELECT * FROM khach_hang WHERE sodienthoai = ? LIMIT 1";
            $stmt = $this->db->link->prepare($query);
            $stmt->bind_param("s", $sdt);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $value = $result->fetch_assoc();

                if (password_verify($pass, $value['passwords'])) {
                    Session::set('customer_login', true);
                    Session::set('customer_id', $value['id']);
                    Session::set('sdt', $value['sodienthoai']);
                    Session::set('name', $value['ten']);
                    header('Location:index.php');
                    exit();
                } else {
                    return "<span class='error'>Incorrect phone number or password!</span>";
                }
            }
        }
    }

    public function test_phone($sdt1) {
        $sdt1 = $this->fm->validation($sdt1);
        $sdt1 = mysqli_real_escape_string($this->db->link, $sdt1);
        $query = "SELECT * FROM khach_hang WHERE sodienthoai='$sdt1'";
        return $this->db->select($query);
    }

    public function insert_user($ten, $sdt1, $sex, $pass1, $repass) {
        $sdt1 = $this->fm->validation($sdt1);
        $ten = $this->fm->validation($ten);
        $sex = isset($sex) ? $this->fm->validation($sex) : null;
        $pass1 = $this->fm->validation($pass1);
        $repass = $this->fm->validation($repass);

        $sdt1 = mysqli_real_escape_string($this->db->link, $sdt1);
        $ten = mysqli_real_escape_string($this->db->link, $ten);
        $sex = mysqli_real_escape_string($this->db->link, $sex);

        if (empty($ten) || empty($sdt1) || empty($sex) || empty($pass1) || empty($repass)) {
            return "<span class='error'>Please fill in all fields!</span>";
        }

        $a = $this->test_phone($sdt1);
        if ($a) {
            return "<span class='error'>Phone number already exists!</span>";
        }

        if ($pass1 !== $repass) {
            return "<span class='error'>Passwords do not match!</span>";
        }

        $hashed_password = password_hash($pass1, PASSWORD_DEFAULT);

        $query = "INSERT INTO khach_hang(ten, sodienthoai, gioitinh, passwords) 
                  VALUES('$ten', '$sdt1', '$sex', '$hashed_password')";
        $result = $this->db->insert($query);

        if ($result) {
            $query = "SELECT * FROM khach_hang WHERE sodienthoai='$sdt1' LIMIT 1";
            $results = $this->db->select($query);

            if ($results) {
                $value = $results->fetch_assoc();
                Session::set('userlogin', true);
                Session::set('id', $value['id']);
                Session::set('sdt', $value['sodienthoai']);
                Session::set('name', $value['ten']);
                header('Location: index.php');
                exit();
            }

            return "<span class='success'>Sign Up Success!</span>";
        } else {
            return "<span class='error'>Registration failed!</span>";
        }
    }

    public function show_thongtin($id) {
        $query = "SELECT * FROM khach_hang WHERE id='$id'";
        return $this->db->select($query);
    }
    public function test_pass($pass0) {
        $pass0 = $this->fm->validation($pass0);  // Xử lý đầu vào
        $pass0 = mysqli_real_escape_string($this->db->link, $pass0);  // Tránh SQL Injection
    
        // Lấy mật khẩu đã mã hóa từ cơ sở dữ liệu
        $query = "SELECT passwords FROM khach_hang WHERE id = ?";
        $stmt = $this->db->link->prepare($query);
        $stmt->bind_param("i", $_SESSION['customer_id']);  // Giả sử bạn lưu trữ id khách hàng trong session
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Kiểm tra xem có kết quả không
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashed_password = $row['passwords'];
    
            // So sánh mật khẩu người dùng nhập vào với mật khẩu đã mã hóa trong cơ sở dữ liệu
            if (password_verify($pass0, $hashed_password)) {
                return true;  // Mật khẩu cũ đúng
            } else {
                return false;  // Mật khẩu cũ sai
            }
        }
    
        return false;  // Không tìm thấy người dùng
    }
    
    
    public function change_pass($id, $pass0, $pass1, $repass) {
        // Kiểm tra mật khẩu cũ bằng cách sử dụng password_verify
        $a = $this->test_pass($pass0); // Giả sử test_pass là hàm kiểm tra mật khẩu cũ
        if ($a) {
            // Kiểm tra mật khẩu mới và mật khẩu xác nhận có giống nhau không
            if ($pass1 === $repass) {
                // Mã hóa mật khẩu mới với password_hash
                $hashed_password = password_hash($pass1, PASSWORD_DEFAULT);
                // Cập nhật mật khẩu trong cơ sở dữ liệu
                $query = "UPDATE khach_hang SET passwords='$hashed_password' WHERE id='$id'";
                $result = $this->db->insert($query); // Giả sử db->insert là hàm thực thi câu lệnh SQL
                if ($result) {
                    return "<span class='success'>Password changed successfully!</span>";
                } else {
                    return "<span class='error'>Password change failed!</span>";
                }
            } else {
                return "<span class='error'>Passwords do not match!</span>";
            }
        } else {
            return "<span class='error'>Incorrect old password!</span>";
        }
    }
    

    public function update_user($ten, $sdt1, $sex, $id) {
        $ten = $this->fm->validation($ten);
        $sdt1 = $this->fm->validation($sdt1);
        $sex = $this->fm->validation($sex);
    
        $ten = mysqli_real_escape_string($this->db->link, $ten);
        $sdt1 = mysqli_real_escape_string($this->db->link, $sdt1);
        $sex = mysqli_real_escape_string($this->db->link, $sex);
    
        $query = "UPDATE khach_hang SET ten='$ten', sodienthoai='$sdt1', gioitinh='$sex' WHERE id='$id'";
        $result = $this->db->update($query); // Đúng phương thức
    
        if ($result) {
            return "<div class='alert alert-success'>Cập nhật thông tin thành công!</div>";
        } else {
            return "<div class='alert alert-danger'>Cập nhật thất bại!</div>";
        }
    }
    
    
}
?>
