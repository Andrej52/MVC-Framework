<?php
class Handler
{
    protected function view($path,$view)
    {
        $fallbackViewFileName = dirname(__DIR__,1)."/views/404.php";

        if (!is_dir($path."")) {
            $viewFileName =$path."{$view}.php";
        }
        else
        {
            $viewFileName =$path."{$view}.php";
        }
        
        if (file_exists($viewFileName)) 
        {
            require $viewFileName;
        }
        else
        {
            include $fallbackViewFileName;
        }
    } 
    
    protected function loadModel($model)
    {
        if (file_exists("../app/models/$model.php")) 
        {
            include "../app/models/$model.php";
            return $model = new $model;
        }

        return false;
    } 
}