<?php

abstract class AbstractController{

   /**
   *@param string $template
   *@param ?array $params default []
   *@param string $pageName
   *
   *@return void
   */
    protected function render(string $template, ?array $params = [],string $pageName)
    {
      $view = new View($pageName);
      $view->render($template,$params);
    }


    protected function redirect(string $page)
    {
      header("Location: $page");    
      exit();
    }
}