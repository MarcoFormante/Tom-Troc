<?php

class View{
    private string $title;


    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function render(string $template, array $params = []){
        
        $content = $this->getContentFromTemplate($template,$params);
        $title = $this->title;
        ob_start();
        require(MAIN_LAYOUT);
        echo ob_get_clean();
    }


    private function getContentFromTemplate(string $template,array $params){
        $viewPath = TEMPLATE_PATH . $template.'.php';
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