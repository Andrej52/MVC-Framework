<?php
class Form extends Database
{
    private $db;
    private $Colname;
    private $type = ["text","password","date","number","checkbox","file",]; // array of types for FORM inputs
    private $acceptable = ["img"=>[".png","jpg","jpeg","image/*"], "file"=>[".doc",".docx",".pdf",".xml","doc/*"]]; // associative array of acceptable extenstions
    private $jsonFilePath = '/data/';    // add your own path
    private $filePath = 'path/to/your/';    // add your own path    

    public function __construct() {
        $this->db = new Database();
    }

    // return column type of specific column in table
    private function getColType($tablename,$arrNum)
    {
        $type = $this->getTableColType($tablename,$arrNum);
        // bitmap of each statement
        // each bit represents one formula from terms 
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
     //   var_dump(__DIR__);
        $jsonData = file_get_contents(dirname(__DIR__,1).$this->jsonFilePath.$filename);
        $jsonDecodedData = json_decode($jsonData,true); // decodes data from forms.json ,  accesible by formname  
        $form = $jsonDecodedData[$formname]; // form inputs metadata 

        echo'<form action="../app/controllers/'.$controller.'" enctype="multipart/form-data" method="'.$method.'">';
        echo '<input type="hidden" name="table" value="'.$formname.'">';
        for ($i=0; $i < count($form); $i++) { // iterate over all inputs
            foreach ($form[$i] as $key => $value) { // iterate over all inputs's metada and insert
                echo '<input type="'.$value['type'].'" name="'.$value['name'].'" value="'.$value['value'].'" placeholder="'.$value['placeholder'].'">';
            }
        }
        echo '</form>';
        //echo '<script>alert("this form has been generated from JSON")</script>'; 
    }

    // generate FORM via XML
    /*
    // TODO
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