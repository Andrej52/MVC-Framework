<?php
// gallery model is extended model of an BASE object Topic
// RECOMENDED:
// if you want  different strucure  of an gallery  then edit  content of echo to the way how u want it
// or make yourself an html  inside the view where data's should be inserted by an javascript/PHP  code to get best result

class Gallery extends Topic
{
    private $topic;
    public function __construct()
    {
        $this->topic= new Topic;
    }

    public function add($post)
    {
        $this->topic->add($post);
    }

    public function show($tablename)
    {
        $this->topic->databaseData($tablename);
        if ($this->topic->data != null) {
            // $row is an variable which hold the value of specific row 
            foreach($this->topic->data as $key => $row)
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

    public function manage($tablename)
    {
        $this->topic->management($tablename);
    }
}
