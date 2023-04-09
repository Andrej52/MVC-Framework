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
    <h1>pridavanie test1</h1>

   <form action="../app/controllers/ad.php" enctype="multipart/form-data" method="POST">
        <input type="hidden" name="table" value="adds">
        <input type="text" placeholder="nadpis" name="header">
        <input type="text" name="text" placeholder="content">
        <input type="file" accept="image/*"  name="image">
        <input type="file" accept=".docx,.pdf,.xml"  name="doc">
        <input type="submit" value="submit">
    </form>

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
