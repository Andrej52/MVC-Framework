<?php
class Form extends Database
{
    private $db;
    private $Colname;
    private $type = ["text","password","file",];
    private $acceptable = ["img"=>[".png","jpg","jpeg","image/*"], "file"=>[".doc",".docx",".pdf",".xml","doc/*"]]; 
    

    public function __construct() {
        $this->db = new Database();
    }

    private function GetType()
    {
        
        for ($i=0; $i <count($type) ; $i++) { 
            # code...
        }
        return $type;
    }

    public function createFormByTable($tableName, $controller)
    {

        $result = $this->db->getTableColsCount($tableName);
        echo'<form action="../app/controllers/'.$controller.'" enctype="multipart/form-data" method="post">';
        echo '<input type="hidden" name="table" value="'.$tableName.'">';
        for ($i = 0; $i < $result ; $i++) 
        { 
            // TODO : 
            /*
                make an decistion tree where it 
            */ 
            echo '<input type="'.$type.'"  placeholder="'.$placeholder.'" name="'.$colName.'">';     
        }
        
        echo '</form>';
    }

}