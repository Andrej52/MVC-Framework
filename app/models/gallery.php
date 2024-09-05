<?php
// gallery model is extended model of an BASE object Topic
// RECOMENDED:
// if you want  different strucure  of an gallery  then edit  content of echo to the way how u want it
// or make yourself an html  inside the view where data's should be inserted by an javascript/PHP  code to get best result

class Gallery extends Database
{
    private $db;

    public function __construct()
    {
        $this->db= new Database;
    }
    
    // adds gallery 
    // nebude potrebne
    public function add($post)
    {
        $this->db->add($post);
    }

    // generate gallery item for each gallery
     /**
     * Generate HTML gallery thumbnail item for each gallery
     * @param string $tablename  Table that has to be generated
     */
    public function show($tablename)
    {
        $this->db->getData($tablename);
        if ($this->db->data != null) {
            foreach($this->db->data as $key => $row)
            {
                echo "
                <section class='gallery-wrap'>
                    <h1>{$row['header']}</h1>
                    <div> <img src='{$row['images']}' alt='not found '> </div>
                    <div>{$row['desc']}</div>
                </section>
                ";
            }
        }
    }

    /**
     * Generate HTML table with management option's
     * @param string $tablename  Table that has to be generated
     */
    public function manage($tablename)
    {
        $this->db->getData($tablename);
        $this->data = $this->db->data;
        if ($this->data === null) {
           
        }
        else
        {
            echo "<table id='{$tablename}'>
            <tr>";
                foreach ($this->data[0] as $key => $value) echo "<th>{$key}</th>";echo " <th>Akcia</th></tr>";   
                for ($i=0; $i <sizeof($this->db->data) ; $i++) 
                { 
                    echo  "<tr>";
                        foreach ($this->data[$i] as $key => $value) echo "<td>{$value}</td>"; 
                        echo "  <td>
                        <button id='{$this->data[$i]['ID']}'>delete</button>
                        <button id='{$this->data[$i]['ID']}'>edit</button>
                        </td> 
                    </tr>";
                    }
            echo "</table>";
        }
    }

}
