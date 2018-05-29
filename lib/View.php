<?php
/**
 *
 * Class View
 *
 * define a View class
 */

class View {
    private $template;

    public function __construct($template)
    {
        $this -> template =$template;
    }

    public function build($datas)
    {
        $template = $this->template;

        $loader = new Twig_Loader_Filesystem(ROOT . 'view/');

        $twig = new Twig_Environment($loader, [
            'cache' => false //__DIR__ .'/tmp'
        ]);


        if ($datas){
            foreach ($datas as $name => $value) {
                $a = $name;
                $$a = $value;
            }
           // echo $twig->render($template . '.twig', ['chapters' => $chapters,'comments' => $comments ,'warningList' => $warningList,'HOST'=>$HOST, 'adminLevel' => $adminLevel]);
           echo $twig->render($template . '.twig', ['recipes' => $recipes,'ingredients'=> $ingredients,'comments' => $comments ,'warningList' => $warningList,'message'=>$message,'HOST'=>$HOST, 'adminLevel' => $adminLevel]);
        }
    }

    public function redirect($route)
        {
            header("location: ".HOST.$route );
            exit;
        }
}