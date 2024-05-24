<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        //instance
        $topic=new Topic;
        // shows html of specific table
        // topic can be any kind of file 
        // $topic->display("here insert tablename of topic");     
       
        //  shows  table with interactions of specific table
        // $topic->management("here insert TABLENAME");

        //instance
        $form = new Form();
        //$form->createFormbyTable('users','daco.php','post') 
        //$form->createFormbyJSON('forms.json','login','daco.php','post') // see:app/data/config/forms.json
        //$form->createFormbyXML('forms.xml','login','daco.php','post')
    ?>
</body>
</html>