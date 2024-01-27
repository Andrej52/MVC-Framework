<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="">
    <link rel="stylesheet" href="assets/css/test.css">
    <script defer src=""></script>
    <title>Add</title>
</head>
<body>
    <h1>pridavanie test 2 </h1>
    <form action="../app/controllers/topic_add.php" enctype="multipart/form-data" method="post">
        <input type="hidden" name="table" value="galleries">
        <input type="text" placeholder="text1" name="header">
        <textarea name="desc" cols="30" rows="10"></textarea>
        <input type="file" accept="image/*"    name="img[]" multiple >
        <!--
            multiple document input
        <input type="file" accept="doc/*"    name="files[]" multiple  >
        -->
        <input type="submit" value="upload">
    </form>
    <div class="output-images">
        <div class="uploaded-img">
            <img src="" alt="obrazok">
        </div>
        <div class="uploaded-img">
            <img src="" alt="obrazok">
        </div>
        <div class="uploaded-img">
            <i class="delete">X</i>
            <img src="" alt="obrazok">
        </div>
        <div class="add-frame">
            <input type="file" accept="image/*"  name="image">
        </div>
    </div>
</body>
</html>
<script>
    let wrap =document.querySelector(".output-images");
    let images =document.querySelectorAll(".uploaded-img");
    let addbtn = document.querySelector(".add-frame").firstElementChild.addEventListener("");
    function load_content()
    {
        console.log(addbtn.value);
    }
</script>
<style>
        form{
                display: flex;
                flex-direction: column;
                width: 200px;
        }
        input{
            margin: 10px;
        }
        .output-images
        {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            width: 80%;
            border:1px blue dotted;
        }
        .output-images > *
        {
            border:  solid 3px red;
            height: 100px;
            width: 100px;   
        }


</style>