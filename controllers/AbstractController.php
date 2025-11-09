<?php

class AbstractController{

   /**
   *@param string $template
   *@param ?array $params default []
   *@param string $layout default "main"
   *
   *@return void
   */
    protected function render(string $template, ?array $params = []){
      $view = new View("Home");
      $view->render($template,$params);
    }
}