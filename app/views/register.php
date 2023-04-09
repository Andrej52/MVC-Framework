<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon">
        <script src="assets/js/http.js"></script>
        <script src="assets/js/signinup.js"></script>
        <title>Registration</title>
</head>
<body>
<section>
    <p>registracia</p>
    <form oninput="check()">
         <input type="hidden" name="table" value="users">
         <input type="email"  name="email" placeholder="email"  required ></p>
         <input type="text" name="name" placeholder="meno priezvysko"  ></p>
         <input type="text" name="username"  placeholder="uzivatelske meno" oninput=" checkInputs(this)"  required ></p>
        <input type="password" id="password" name="password" placeholder="heslo"  required ></p>
        <input type="password" id="repeat-password" placeholder="potvrd heslo" required></p>
        <label>Zobraziť Heslo <input type="checkbox"  onclick="show_Password(this)"></label>
        <p id="values"></p>
    </form>
    <button  id="signUp" onclick="post(this)">register</button>
    <span id="message"></span>
</section>
</body>
<style>
        form{
                display: flex;
                flex-direction: column;
                width: 200px;
        }
        body{
                background-color: gray;
        }
</style>
</html>
