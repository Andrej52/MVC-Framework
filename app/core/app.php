<?php
  require_once __DIR__."/../controllers/PageController.php";
class App extends PageController
{   

    public function run()
    {
      $PageController= new PageController;  
      $url = $this->splitURL();
      if (!isset($url['url'][1])) {
        $urlPath = dirname(__DIR__,1)."/views/";
      }
      else
      {
        $urlPath=$url['url'][1];
      }
      $urlError=$url['params'];
      $url=$url['url'];
      $viewname = strtolower($url[0]);
      // Homepage
      if ($viewname === '') {
         $viewname = 'home';
      }
        // Subpage
        if(method_exists($PageController , $viewname)) {   
          $_SERVER['view_path']=$urlPath;
          
          if (!empty($urlError)) 
          {
          $urlparams=explode("=",$urlError);
          $_SERVER['type']=$urlparams[0];
          $_SERVER['msg']=$urlparams[1];
          }
        }        
        // 404-
        else {
          $viewname = 'error404';
        }
      $params = array_values($url);
     call_user_func_array([ $PageController , $viewname],$params);
    }

    protected function splitURL()
    {
      $path=dirname(__DIR__,1)."/views/";
      $server_url =$_SERVER['REQUEST_URI'];
      $pregsplitedURL = preg_split("*public/*",$server_url);
      array_shift($pregsplitedURL);
      $url = preg_split("*/*",implode("",$pregsplitedURL));
      $subfolder=[];

      $viename = explode('?', $url[sizeof($url)-1]);
      if (isset($viename[1])) {
        $urlParams =$viename[1];
        array_pop($viename);
      }
      else
      {
        $urlParams ="";
      }
      if (empty($viename[0])) {
        $viename[0]="home";
      }
      $viename=implode("",$viename);   
      for ($i=0; $i <= sizeof($url)-1 ; $i++) { 
        if (is_dir($path.$url[$i])) 
        {
          $subfolder[$i] = $url[$i];
          $path =$path.$subfolder[$i]."/";
        
          if (is_file($path.$viename.".php")) {
            return ["url"=>[$viename,$path], "params" => $urlParams];
          }
          else
          {
          $filesarr=array_diff(scandir($path), array('.', '..'));

           for ($x=0; $x < sizeof($filesarr)-1 ; $x++) { 
            if ($filesarr[$x] !== $viename.".php" ) {
              $viename = "error404";
            }
           }
           $path = dirname(__DIR__,1)."/views/";
           return ["url"=>[$viename,$path], "params" => $urlParams];
          }
        }
        else
        {
          if (!is_file($path.$viename.".php")) {
            $viename = "error404";
          }
          return ["url"=>[$viename,$path],"params" => $urlParams];
        }
      }
    }
}