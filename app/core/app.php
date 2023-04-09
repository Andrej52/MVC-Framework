<?php
  require_once __DIR__."/../controllers/PageController.php";
class App extends PageController
{   

    public function run()
    {
      $PageController= new PageController;  
      $url = $this->splitURL();
      $urlError=$url['params'];
      $url=$url['url'];
      $viewfolder=$url['folderpath'];
      $viewname = strtolower($url[0]);
      // Homepage
      if ($viewname === '') {
         $viewname = 'home';
      }
        // Subpage
        if (method_exists($PageController , $viewname)) {   
          unset($url[0]);

          if (isset($url[1])) {
            if (method_exists($PageController, $viewname)) {
              $viewname = strtolower($url[1]);

              unset($url[1]);
            } 
          }

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
      call_user_func_array([ $PageController , $viewname ], $params);
    }

    protected function splitURL()
    {
      $path=dirname(__DIR__,1)."/views/";
      $server_url =$_SERVER['REQUEST_URI'];
      $pregsplitedURL = preg_split("*public/*",$server_url);
      array_shift($pregsplitedURL);
      $url = preg_split("*/*",implode("",$pregsplitedURL));
      $subfolder=[];
      if (!isset($url[0]))
      {
        $url[0]="";
      }

      // riesit moznoustou pozerania sa ci dirname,count je vacsi ako 1  kym narazina views/a podla tohho
      for ($i=0; $i < sizeof($url)-1 ; $i++) { 
        if (is_dir($path.$url[$i])) 
        {
          $subfolder[$i] = $url[$i];
          $path =$path."/".$subfolder[$i]."/";
        }
      }
      var_dump($subfolder);
      // odtalto dole treba dokodit IF
      $url = explode('?', $url[sizeof($url)-1]);
      $urlParams = $url[sizeof($url)-1];
      //return ["folderpath" => $path.$url[0], "url"=>$url, "params" => $urlParams]; 
      //file_exists($path.$url[0]."/".$url[sizeof($url)-1].".php")
      //return ["url"=>$url, "params" => $urlParams];
    }
}