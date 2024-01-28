<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="">
    <title>Add</title>
</head>
<body>
    <h1>Topic add </h1>
    <?php createTopicForm(); ?>
<?php
    if(isset($_GET['error']) && ($_GET['error'] === "topicalreadyexist")){
      echo"  <p>Topic with this name already exist!</p>";
    }
    ?>
</body>
</html>
<style>
        form{
                display: flex;
                flex-direction: column;
                width: 200px;
        }
        input{
            margin: 10px;
        }

</style>
