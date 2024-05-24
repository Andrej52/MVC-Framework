<?php
class Form extends Database
{
    private $db;
    private $Colname;
    private $type = ["text","password","date","number","checkbox","file",];
    private $acceptable = ["img"=>[".png","jpg","jpeg","image/*"], "file"=>[".doc",".docx",".pdf",".xml","doc/*"]]; 
    private $jsonFilePath = 'path/to/your/';    

    public function __construct() {
        $this->db = new Database();
    }


    private function getColType($tablename,$arrNum)
    {
        $type = $this->getTableColType($tablename,$arrNum);
        // bitmap of each statement
        $switchcases = [
            (($type == "text") || ($type == "varchar") || ($type == "tinytext") || ($type == "smalltext") || ($type == "bigtext")) ? 1 : 0, // TEXT
            (($type == "text") || ($type == "varchar")) ? 1 : 0, // PASSWORD
            (($type == "date") || ($type == "datetime")) ? 1 : 0, // DATE
            (($type == "bigint") || ($type == "int") || ($type == "tinyint")) ? 1 : 0, // NUMBER
            (($type == "int") || ($type == "boolean") || ($type == "bit")) ? 1 : 0, // CHECKBOX
            (($type == "varchar") || ($type == "longblob") || ($type == "blob") || ($type == "tinyblob") || ($type == "mediumblob")) ? 1 : 0 // IMAGE, FILE
        ];
        var_dump($switchcases);

        $initval = '1000000'; // initial value =>  TEXT
        echo 'initval: '.$initval.'\n';

        for ($i=0; $i < count($this->type) ; $i++) {
            // checking each bitmap via bitshifrt right  
            if (($initval >> $i) == $switchcases[$i]  ) {
                var_dump($switchcases[$i]);
                print_r($this->type[$i]);
            }
        }

        /*
            same shit ale inak        
            if ($switchcases[0] && !$switchcases[1] && !$switchcases[2] && !$switchcases[3] && !$switchcases[4] && !$switchcases[5]) {
                return $type[0]; // text
            }
            else if (!$switchcases[0] && $switchcases[1] && !$switchcases[2] && !$switchcases[3] && !$switchcases[4] && !$switchcases[5]) {
                return $type[1]; // password
            }
            else if (!$switchcases[0] && !$switchcases[1] && $switchcases[2] && !$switchcases[3] && !$switchcases[4] && !$switchcases[5]) {
                return $type[2]; // date
            }
            else if (!$switchcases[0] && !$switchcases[1] && !$switchcases[2] && $switchcases[3] && !$switchcases[4] && !$switchcases[5]) {
                return $type[3]; // number
            }
            else if (!$switchcases[0] && !$switchcases[1] && !$switchcases[2] && !$switchcases[3] && $switchcases[4] && !$switchcases[5]) {
                return $type[4]; // checkbox
            }
            else if (!$switchcases[0] && !$switchcases[1] && !$switchcases[2] && !$switchcases[3] && !$switchcases[4] && $switchcases[5]) {
                return $type[5]; // file
            }
            else
            {
                return null;
            }
            
        */

    }

    // generate FORM with input fields
    public function createFormByTable($tableName, $controller,$method)
    {
        $colsCount = $this->db->getTableColsCount($tableName);
        echo'<form action="../app/controllers/'.$controller.'" enctype="multipart/form-data" method="'.$method.'">';
        echo '<input type="hidden" name="table" value="'.$tableName.'">';
        for ($i=0; $i < $colsCount; $i++) { 
            echo '<input type="hidden" name="table" value="'.$tableName.'">';
        }
        echo '</form>';
    }

    // generate FORM via JSON
    public function createFormbyJSON($filename,$formname,$controller,$method)
    {
        $jsonData = file_get_contents($this->jsonFilePath.$filename);
        $form = $jsonData['formname']; 
        echo'<form action="../app/controllers/'.$controller.'" enctype="multipart/form-data" method="'.$method.'">';
        echo '<input type="hidden" name="table" value="'.$tableName.'">';
        for ($i=0; $i < $colsCount; $i++) { 
            echo '<input type="'.$form['type'].'" name="'.$form['name'].'" value="'.$form['value'].'" placeholder="'.$form['placeholder'].'">';
        }
        echo '</form>';
    }

    // generate FORM via XML
    /*
    public function createFormByXML($filename,$controller,$method)
    {
        echo'<form action="../app/controllers/'.$controller.'" enctype="multipart/form-data" method="'.$method.'">';
        echo '<input type="hidden" name="table" value="'.$tableName.'">';
        for ($i=0; $i < $colsCount; $i++) { 
            echo '<input type="hidden" name="table" value="'.$tableName.'">';
        }
        echo '</form>';
    }
    */
    
}