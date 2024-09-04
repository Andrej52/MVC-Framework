<?php
       include_once "database.php";
class User extends Database
{   
    protected $name, $username,$password,$email;
    public $result;
    private $db;
    
    public function __construct()
    {
        $this->db=new Database();
        return $this->db;
    }
    
    /**
     * Sign up user 
     * If succes ,  user will be registered and logged in  
     * @return bool true if sucesfully registered
     */
    public function signUp()
    {
            if ($this->userExist()) 
                return false;
            $_POST['password'] = $this->password;

            if (!$this->db->add($_POST))  // tries to add user into DB
                return false; // add not succes 
        
            $this->signIn(); // tries login user while registered
            echo "user Registered";
            return true; 
    }

    /**
     * Sign in user 
     * If succes ,set session with username and his role
     * @return bool true if sucesfully logged in
     */
    public function signIn()
    {
        $success = false;
        $sql = "SELECT * from  users where username = ? AND password = ? ";
        $this->db->prep="ss";
        $this->db->values=[$this->username,$this->password];
        $this->db->SubmitQuery($sql);

        if ($this->db->sql_result->num_rows === 1) {
            foreach($this->db->sql_result as $row)
            {
                session_start();

                $_SESSION['username'] = $row['username'];
                $_SESSION['role'] = $row['role'];

            }
                $_SESSION["loggedin"] = TRUE;
                $success = true;
        }
        return $success;
    }

    /**
     * Log out user from website
     */
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

    /**
     * Check if e-mail is already in the database
     * @return bool true if e-mail is found
     */
    private function userExist()
    {
        $sql = "SELECT * from  users where email = ?";
        $this->db->prep = "s";
        $this->db->values = [$this->email];
        $this->db->SubmitQuery($sql);

        if ($this->db->sql_result->num_rows > 1) {
            http_response_code(409);
            echo "userExist";
            return true;
        }
        return false;
    }
}