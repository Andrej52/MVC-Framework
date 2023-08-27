<?php
// ©copyright Andrej-52
require_once  dirname(__DIR__,1)."/core/handler.php";
class PageController  extends Handler
{
    function home()
    {
        $this->view("home");
    }

    function show()
    {
        $this->view("show");
    }
    function error404()
    {

        $this->view("404");
    }

    function register()
    {
        $this->view("register");
    }

    function login()
    {
        $this->view("login");
    }

    function add()
    {
        $this->view("add");
    }

    function add2()
    {
        $this->view("add2");
    }

    function select()
    {
        $this->view("select");
    }

}