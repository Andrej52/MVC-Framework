<?php
// ©copyright Andrej-52
require_once  dirname(__DIR__,1)."/core/handler.php";
class PageController  extends Handler
{
    function home()
    {

        $this->view($_SERVER['view_path'],"home");
    }

    function show()
    {
        $this->view($_SERVER['view_path'],"show");
    }
    function error404()
    {
        $this->view(dirname(__DIR__,1)."/views/","404");
    }

    function dsa()
    {
        $this->view($_SERVER['view_path'],"dsa");
    }

}