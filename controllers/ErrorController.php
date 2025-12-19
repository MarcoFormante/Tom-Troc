<?php 

class ErrorController extends AbstractController
{
    /**
     * Show the Error page
     * @param int $code
     * @param string $message
     * @return void
     */
    public function showError(int $code = 500,string $message = "")
    {
        $this->render("error",["code" => $code,"message" => $message],"Error");
    }


    /**
     * Handle errors and call showError function
     * @param Error $error
     * @return void
     */ 
    public function handleError(Throwable $error)
    {
        if($error instanceof Throwable){
            switch($error->getCode()){
                case 404:
                    $this->showError(404,$error->getMessage());
                break;

                 case 403:
                   $this->showError(403, $error->getMessage());
                break;

                default:
                    $this->showError(500,"Une erreur inattendue est survenue");
                break;
            }
       
        }
    }
}