<?php
if (isset($_POST)) {
    include_once "../models/user.php";

    $user = new User;
    $user->username = stripslashes(strtolower($_POST['username']));
    $user->password = stripslashes($_POST['password']);
    $user->password = hash("sha1", $user->password . $user->username);
    
    if (empty($user->username) && empty($user->password)) {
        http_response_code(400);
        header("Location:../../public/login");
        echo "emptyInputs";
        exit();
    } 
    elseif (empty($user->username)) 
    {
        http_response_code(400);
        header("Location:../../public/login");
        echo "emptyUsername";
        exit();
    } 
    elseif (empty($user->password)) 
    {
        http_response_code(400);
        header("Location:../../public/login");
        echo "emptyPassword";
        exit();
    } else
     {
       if ($user->signIn()) 
       {
        http_response_code(301);
        header("Location:../../public/home");
        echo "user Logged Succesfully!";
        exit();
       }
       else 
       {
        http_response_code(409);
        echo ("Auth failed");
        header("Location:../../public/login");
        exit();
       }
        }
    }
