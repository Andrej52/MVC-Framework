<?php
class Handler
{
    // NOTE  treba dokodit to aby sa reweretla URL pocas requeire

    /**
     * Return view of specific page
     * @param string $view name of view that has to be showed
     */
    protected function view($view)
    {
        $fallbackViewFileName = dirname(__DIR__,1)."/views/404.php";
        $path = dirname(__DIR__,1) ."/views/";
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
    
    /**
     * load model of specific object
     *@param string $model name of mode to load
     */
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