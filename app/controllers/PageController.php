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

    function add_topic()
    {
        $this->view("add_topic");
    }

    function add_gal()
    {
        $this->view("add_gal");
    }

    function select()
    {
        $this->view("select");
    }
    

    /*
    TEST PURPOSE ONLY
    */
    function itemseshop()
    {
        $this->view("itemseshop");
    }
    
}