<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/session.php');
Session::checkLogin();
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');

class adminlogin {
    private $db;
    private $fm;

    public function __construct() {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function login_admin($adminuser, $adminpass) {
        $adminuser = $this->fm->validation($adminuser);
        $adminpass = $this->fm->validation($adminpass);

        $adminuser = mysqli_real_escape_string($this->db->link, $adminuser);

        if (empty($adminuser) || empty($adminpass)) {
            return "Username and password cannot be empty!";
        } else {
            $query = "SELECT * FROM tb_admin WHERE adminuser = ?";
            $stmt = $this->db->link->prepare($query);
            $stmt->bind_param("s", $adminuser);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $value = $result->fetch_assoc();
                if (password_verify($adminpass, $value['adminpass'])) {
                    Session::set('adminlogin', true);
                    Session::set('idadmin', $value['id_admin']);
                    Session::set('adminuser', $value['adminuser']);
                    Session::set('adminname', $value['Name_admin']);
                    header('Location: index.php');
                } else {
                    return "Invalid username or password!";
                }
            } else {
                return "Invalid username or password!";
            }
        }
    }
}
?>
