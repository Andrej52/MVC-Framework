<?php
       include_once "database.php";
class User extends Database
{   
    public $name, $username,$password,$email;
    public $result;
    private $db;
    
    public function __construct()
    {
        $this->db=new Database();
        return $this->db;
    }
    
    public function signUp()
    {
            if ($this->userExist()) {
                return false;
            }
            $_POST['password']=$this->password;
            $this->db->add($_POST);
            if ($this->signIn()) {
                echo "userRegistered";
                return true;
            }
            else
            {
                return false;
            }
      
    }

    public function signIn()
    {
        $sql = "SELECT * from  users where username = ? AND password = ? ";
        $this->db->prep="ss";
        $this->db->values=[$this->username,$this->password];
        $this->db->SubmitQuery($sql);

        if ($this->db->sql_result->num_rows === 1) {
            foreach($this->db->sql_result as $row)
            {
                session_start();
                $_SESSION['username'] =$row['username'];
                $_SESSION['role'] = $row['role'];
            }
                $_SESSION["loggedin"] = TRUE;

                return true;
        }
        else
        {
            return false;
        }
    }

    public function signOut()
    {
        session_start();
        unset($_SESSION);
        session_destroy();
        if (empty($_SESSION)) {
            return true;
        }
            return false;
    }

    private function userExist()
    {
        $sql = "SELECT * from  users where email=?";
        $this->db->prep="s";
        $this->db->values=[$this->email];
        $this->db->SubmitQuery($sql);
        if ($this->db->sql_result->num_rows > 1) {
            http_response_code(409);
            echo"userExist";
            return true ;
        }
        return false;
    }
}