<?php
// the only thing u need to do if u want just simply LogIN Register or Add/delete/edit topics is 
// adding/ediding the parameters of  database e.g(name,password,username)
// database model's PURPOSE is ONLY for database adding not for uploading files into the server !!

class Database {
    private $DB_name = "framework";     // database name on server
    private $DB_host = "localhost";     // database url 
    private $DB_user = "root";          // database username
    private $DB_pwd = "";               // database password for  an access
    private $conn;                      //conection of database          
    protected $sql,$sql_result,$prep,$vals,$values; //SQL things
    protected $tableArr = array();      // List of all tables inside Database
    protected $rows,$tablename;
    public $data;

    //constructor 
    public function __construct()
    {
        // setting up connection with database
        $conn = new mysqli($this->DB_host,$this->DB_user,$this->DB_pwd,$this->DB_name);
        if (!$conn->connect_error) {
            $this->conn = $conn;
            $this->getTableNames();
            return true;
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

    /**
     * Extract name of every table in database
     * @return bool true if database contains atl. 1 table
     */
    protected function getTableNames()
    {
        $sql= "SELECT COUNT(*) AS table_count
        FROM information_schema.tables WHERE table_schema = '$this->DB_name'";

        $tablesCount= (int) $this->conn->query($sql)->fetch_assoc()['table_count'];
        $query = $this->conn->query("SHOW TABLES FROM $this->DB_name");

        while ($data = mysqli_fetch_array($query)) {
            array_push($this->tableArr, $data['Tables_in_'.$this->DB_name]);
            if (count($this->tableArr) < 1) {
                return false; // if query didnt passed
            } 
        }
        if (count($this->tableArr) != $tablesCount) {
            return false; // if not all appended into Array
        }
        
        return true; // if success 
     }

    /**
     * Get count of colmns in TABLE
     *@param string $tablename Table that has to be proccessed 
     *@return int count of colmns
     */
    public function getTableColsCount($tablename)
    {
        $sqlQuery = "SELECT count(*) FROM information_schema.columns WHERE table_name = $tablename;";
        $this->SubmitQuery($sqlQuery);
        $count = $this->sql_result[0] - 1;
        return $count;
    }

    // get specific tablebanes  n-th Type
    /**
     * Get datatyp of column in Table
     * @param string $tablename Table that has to be proccessed 
     * @param int $arrNum colmn position 
     * @return array 
     */
    public function getTableColType($tablename,$arrNum)
    {
        $sqlQuery = "SELECT DATA_TYPE FROM information_schema.columns WHERE table_name = $tablename LIMIT 1 OFFSET ($arrNum - 1) ;";
        $this->SubmitQuery($sqlQuery);
        return $this->sql_result;
    }

    /**
     * Prepares data for execution of query, 
     * Asign prepared data into instance's keys
     * @param array  $post data array of POST
     * @return void
     */
    private function prepareData($post)
    {   
        if(empty($post)) return false;
        $this->tablename = array_shift($post);              // separing targetning tablename
        $this->rows=array_keys($post);                       // getting array keys  of post
        $this->values=array_values($post);                   // getting array values of post  
        $this->vals=substr(str_repeat("?,",sizeof($post)),0,-1);   //making string of ? into prepare()
        $this->prep=str_repeat("s",sizeof($post));              //making string of  data types into bind_param()
        $this->rows=join(",",$this->rows);
    }

   /**
    * Get all data from table
    *@param string $tablename Table which has to be data queried
    *@return void
    */
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

    //send query
    /**
     * check if query is correct and proceeds to execute
     * @param string $sql SQL query  
     */
    public function SubmitQuery($sql)
    {
        if (!empty(trim($sql))) { 
            $sqlAction = strtoupper(substr(trim($sql), 0, 6)); 

            try {
                $stmt = $this->conn->prepare($sql);
    
                if (in_array($sqlAction, ["INSERT", "UPDATE", "DELETE", "SELECT"])) {
    
                    if ($this->prep !== null) {
                        $stmt->bind_param($this->prep, ...$this->values);
                    }

                    $stmt->execute();

                    if ($sqlAction === "SELECT") {
                        $this->sql_result = $stmt->get_result();
                    }
    
                    if (in_array($sqlAction, ["INSERT", "UPDATE", "DELETE"])) {
                        $this->sql_result = $stmt->affected_rows;
                    }
                    
                    $stmt->close();
                    return true; 
                }
                else {
                    throw new Exception("Unsupported SQL action: $sqlAction" );
                    return false;
                }
                
            } catch (Exception $e) {
                throw new Exception("Error executing query: " . $e->getMessage());
                return false;
            }
        } else {
            throw new Exception("SQL query cannot be empty.");
            return false;
        }
    }
    
    

    /**
     * Add record to database 
     * @param array  $post data array of POST
     * @return bool true if record  has been sucesfully added
     */
    public function add($post)
    {
        $this->prepareData($post);
        $this->sql=("INSERT INTO $this->tablename($this->rows)  VALUES($this->vals)");
        
        if ($this->SubmitQuery($this->sql)) 
            return true;
        else
            return false;
        
    }

   /**
     * Update existing record in the database 
     * @param array $post data array of post data
     * @param int $id identifcation number of record
     * @return bool true if record  has been sucesfully changed
     */
    public function edit($post,$id)
    {
        $this->prepareData($post);
        $this->sql =("UPDATE  $this->tablename SET $this->rows = $this->vals  WHERE id = ? ");
        $this->prep="s";  
        $this->values = $id;
        if ($this->SubmitQuery($this->sql)) 
            return true;
        else 
            return false;
    }

   /**
     * Delete record from the database 
     * @param string $tablename name of the table
     * @param int $id identifcation number of record
     * @return bool true if record  has been sucesfully removed
     */
    public function remove($tablename,$id)
    {
        $this->sql =("DELETE * FROM $tablename WHERE id = ?");
        $this->prep="s";
        $this->values = $id;
        if ($this->SubmitQuery($this->sql)) 
            return true;
        else 
            return false;
    }   
}