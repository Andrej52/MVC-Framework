<?php

        include_once "../models/user.php";
        $user= new User;
        $user->username=strtolower($_POST['username']);
        $user->password=$_POST['password'];
        $user->name=$_POST['name'];
        $user->email=$_POST['email'];
        $user->password=hash("sha1",$user->password.$user->username);
        $user->signUp();
        
?>