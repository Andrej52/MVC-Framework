<?php
// the only thing u need to do if u want just simply LogIN Register or Add/delete/edit topics is 
// adding/ediding the parameters of  database e.g(name,password,username)
// database model's PURPOSE is ONLY for database adding not for uploading files into the server !!

class Database {
    private $DB_name="framework";        // database name on server
    private $DB_host="localhost";  // database url 
    private $DB_user="root";      // database username
    private $DB_pwd="";          // database password for  an access
    private $conn;              
    protected $sql,$sql_result,$prep,$vals,$values,$rows,$tablename;
    public $data;
    protected $tableArr = array();
    //constructor 
    
    public function __construct()
    {
        // setting up connection with database
        $conn = new mysqli($this->DB_host,$this->DB_user,$this->DB_pwd,$this->DB_name);
        if (!$conn->connect_error) {
            return $this->conn = $conn;
        }
        else{
            return false;
        }
    }

    // destructor
    public function __destruct()
    {
            unset($this->conn);
    }

    // gets tablenames in array
    private function getTableNames()
    {
        $sql = "SHOW TABLES;";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $this->tableArr =  $stmt->get_result();
    }

    // gets count of cols in table
    public function getTableColsCount($tablename)
    {
        $sqlQuery = "SELECT count(*) FROM information_schema.columns WHERE table_name = $tablename;";
        $this->SubmitQuery($sqlQuery);
        $count = $this->sql_result[0] - 1;
        return $count;
    }

    private function prepareData($post)
    {   
        $this->tablename = array_shift($post);              // separing targetning tablename
        $this->rows=array_keys($post);                       // getting array keys  of post
        $this->values=array_values($post);                   // getting array values of post  
        $this->vals=substr(str_repeat("?,",sizeof($post)),0,-1);   //making string of ? into prepare()
        $this->prep=str_repeat("s",sizeof($post));              //making string of  data types into bind_param()
        $this->rows=join(",",$this->rows);
    }

    public function getData($tablename)
    {
        $this->sql =("SELECT * from $tablename");
        $this->SubmitQuery($this->sql);

        try {
            if ($this->sql_result->num_rows > 0 ) {
                for ($i=0; $i < $this->sql_result->num_rows; $i++) { 
                    $this->data[$i]=mysqli_fetch_assoc($this->sql_result);
                }
            }
        } catch (PDOException $e) {
            throw "<p>data not found</p>" . $e->getMessage();
        }
    }

    public function SubmitQuery($sql)
    {
        if (!empty(trim($sql))) { 
            $sqlAction = substr($sql, 0, 6);
            try {
                $stmt = $this->conn->prepare($sql);
                if($sqlAction === "INSERT" || $sqlAction === "UPDATE" || $sqlAction === "SELECT")
                {
                    if ($this->prep !== null) 
                    {
                       $stmt->bind_param($this->prep, ...$this->values);
                    }
                    $stmt->execute();
                    $this->sql_result= $stmt->get_result();
                }
                $stmt->close();

            } catch (PDOException $e) {
                throw "Error: " . $e->getMessage();
            }
        }
    }
    
    public function add($post)
    {
        $this->prepareData($post);
        $this->sql=("INSERT INTO $this->tablename($this->rows)  VALUES($this->vals)");

        if ($this->SubmitQuery($this->sql)) 
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function edit($post,$id)
    {
        $this->prepareData($post);
        $this->sql =("UPDATE  $this->tablename SET $this->rows = $this->vals  WHERE id = ? ");
        $this->prep="s";
        if ($this->SubmitQuery($this->sql)) {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function remove($tablename,$id)
    {
        $this->sql =("DELETE * FROM $tablename WHERE id = ?");
        $this->prep="s";
        $this->values=$id;
        if ($this->SubmitQuery($this->sql)) {
            return true;
        }
        else
        {
            return false;
        }
    }   
}