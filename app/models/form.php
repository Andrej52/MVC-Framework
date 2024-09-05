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

    /**
     * Returs column type of specific column in table
     *@param string $tablename name of table
     *@param int $arrNum position(INDEX) of column
     */
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

        for ($i=0; $i < count($this->type) ; $i++) {
            // checking each bitmap via bitshifrt right  
            if (($initval >> $i) == $switchcases[$i]  ) {
                var_dump($switchcases[$i]);
                return $this->type[$i];
            }
        }
    }

    /**
     * Generate Form via database table
     * @param string $tableName name of table
     * @param string $controller controller name
     * @param string $method POST || GET
     */
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

    /**
     * Validate if file exist , tries to open and check if it is empty
     */
    protected function openFile($file)
    {
        try {
            if (!file_exists($file)) {
                throw new Exception("Error: The file '$file' does not exist.");
            }

            $rawData = file_get_contents($file);

            if ($rawData === false) {
                throw new Exception("Error: Unable to read the file '$file'. It may be corrupted or inaccessible.");
            }
            
            // Check if the file is empty
            if (empty($rawData)) {
                throw new Exception("Error: The file '$file' is empty.");
            }

            return $rawData;

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    /**
     * Generates Form from JSON file
     * @param string $fileName name of the JSON file eg.: "DATA.json"
     * @param string $formName name of the form
     * @param string $controller controller name
     * @param string $method POST || GET
     */
    public function createFormbyJSON($fileName, $formName, $controller, $method)
    {
        $directory = dirname(__DIR__,1).$this->jsonFilePath.$fileName;
        $file_response =  $this->openFile($directory);
        if (strpos($file_response, 'Error:') === 0) {
            // Handle the error
            exit("An error occurred: " . $file_response);
        }

        $jsonData = json_decode($file_response,true); // decodes data from forms.json ,  accesible by formName  

        if (json_last_error() !== JSON_ERROR_NONE) {
            exit("An error occurred: Invalid JSON format.");
        }

        if (!isset($jsonData[$formName])) {
            exit("An error occurred: Form '$formName' not found in JSON data.");
        }

        $form = $jsonData[$formName]; // form inputs metadata 

        echo'<form action="../app/controllers/'.$controller.'" enctype="multipart/form-data" method="'.$method.'">';
        echo '<input type="hidden" name="table" value="'.$formName.'">';
        for ($i=0; $i < count($form); $i++) { // iterate over all inputs
            foreach ($form[$i] as $key => $value) { // iterate over all inputs's metada and insert
                echo '<input type="'.$value['type'].'" name="'.$value['name'].'" value="'.$value['value'].'" placeholder="'.$value['placeholder'].'">';
            }
        }
        echo '</form>';
        //echo '<script>alert("this form has been generated from JSON")</script>'; 
    }

    /**
     * generate FORM via XML 
     * @param string $fileName name of the XML file eg.: "excelExport.xml"
     * @param string $formName name of the form
     * @param string $controller controller name
     * @param string $method POST || GET
     * */
    public function createFormByXML($fileName,$formName,$controller,$method)
    {
        $directory = dirname(__DIR__,1).$this->filePath.$fileName;
        $file_response = $this->openFile($directory);

        if (strpos($file_response, 'Error:') === 0) {
            exit("An error occurred: " . $file_response);
        }

        $xmlData = simplexml_load_string($file_response);

        if ($xmlData === false) {
            exit("An error occurred: Invalid XML format.");
        }

        $form = $xmlData->xpath("//form[@name='$formName']");

        if (empty($form)) {
            exit("An error occurred: Form '$formName' not found in XML data.");
        }

        $form = $form[0];
        
         echo'<form action="../app/controllers/'.$controller.'" enctype="multipart/form-data" method="'.$method.'">';
        echo '<input type="hidden" name="table" value="'.$formName.'">';
        for ($i=0; $i < count($form); $i++) { // iterate over all inputs
            foreach ($form[$i] as $key => $value) { // iterate over all inputs's metada and insert
                echo '<input type="'.$value['type'].'" name="'.$value['name'].'" value="'.$value['value'].'" placeholder="'.$value['placeholder'].'">';
            }
        }
        echo '</form>';
    
    }


}