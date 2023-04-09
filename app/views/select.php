<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script defer src="/OOP/public/assets/select.js"></script>
    <title>Select</title>
</head>
<nav>
    <li>
        <a href="register">register</a>
        <a href="login">login</a>
        <a href="add">add-topic</a>
        <a href="add2">add_gallery</a>
        <a href="select">select</a>
        <?php  if(isset($_SESSION['username'])) echo '<a href="?User=logout" class="logout-btn">logout</a>'; ?>
    </li>
    <li>
        <?php echo "<div>prihlaseny ako: {$_SESSION['username']}</div>";?>
    </li>
</nav>
<body>
    
    <select id="select" onchange="update()">
        <option value="ASC" selected>Price to lowest</option>
        <option value="DESC">Price to highest</option>
        <option value="DATE">Add Date</option>
    </select> 
    <p id="demo"></p>
</body>

</html>
