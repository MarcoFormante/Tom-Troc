<?php

class View{
    private string $title;


    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function render(string $template, array $params = [],string $layout = 'main'){
        
        $content = $this->getContentFromTemplate($template,$params);
        $title = $this->title;
        ob_start();
        require($layout == 'main' ?  MAIN_LAYOUT : 'admin' );
        echo ob_get_clean();
    }


    private function getContentFromTemplate(string $template,array $params){
        $viewPath = __DIR__ . '/templates/home.php';
        if (file_exists($viewPath)) {
            extract($params);
            ob_start();
            require($viewPath);
            return ob_get_clean();
        }else{
            throw new Exception("error");
        }
        
    }
}