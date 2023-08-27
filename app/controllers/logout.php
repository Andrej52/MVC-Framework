<?php
include_once dirname(__DIR__,1)."/models/user.php";

$user = new User;
if ($user->signOut()) {
    echo "userLoggedOut";
    header("Location:../../public/home");
    http_response_code(200);
    exit();
}
    echo "Logout Failed";
    header("Location:../../public/home");
    http_response_code(301);
    exit();