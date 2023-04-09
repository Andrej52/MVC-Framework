<?php
        include_once "../models/user.php";
      
        $user= new User;
        
        $user->username=strtolower($_POST['username']);
        $user->password=hash("sha1",$_POST['password'].$user->username);
        $user->name=$_POST['name'];
        $user->email=$_POST['email'];
        if (empty($user->email=$_POST['email'])) {
                header("Location:".dirname(__DIR__,2)."/public/home");
                exit();
        }
        if ($user->signUp()) {
                header("Location:".dirname(__DIR__,2)."/public/home");
                exit();
        }
                header("Location:".dirname(__DIR__,2)."/public/register");
                exit();
?>