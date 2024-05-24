
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/test.css">
    <script defer src="js/scripts.js"></script>
    <script defer src="assets/js/http.js"></script>
    <link rel="icon" href="">
    <title>home</title>
</head>


<header>
    
</header>
<nav>
    <li>
    <?php include_once "../app/components/adminpanel.php" ?>
    <?php include_once "../app/models/form.php" ?>
    </li>
</nav>
<body>
    <h1 style="text-align: center;">This is land page of MVC model</h1>
    <section style="text-align: center;">
       <p>you can edit this however u want </p>
       <p> nav includes register if you are not Logged IN or possiblity to login if u have conected the database</p>
       <p>Database  structure is mentioned in database Class model</p> 
    </section>
    <?php
    $form = new Form();
    $form->createFormbyJSON('forms.json','login','daco.php','post')
    ?>
</body>
</html>