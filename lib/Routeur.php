<?php

session_start();
/**
 * Created by PhpStorm.
 * User: Gilles
 * Date: 07/05/2018
 * Time: 22:43
 */



/**
 * Class Router
 *
 *Create route et find controller
 */


class Routeur
{
    private $request;
    private $routes = [
       // 'contact.html'                  => ['controller' => 'MiscController', 'method' => 'ShowContact'],
        //'about.html'                    => ['controller' => 'MiscController', 'method' => 'ShowAbout'],
       'home.html'                     => ['controller' => 'CookController', 'method' => 'showHome'],
        'recipe.html'                     => ['controller' => 'CookController', 'method' => 'showDish'],
        'category.html'                     => ['controller' => 'CookController', 'method' => 'showCategory'],

      // 'admin.html'                    => ['controller' => 'MemberController', 'method' => 'loginSession'],
   //  'deconnexion.html'              => ['controller' => 'MemberController', 'method' => 'deconnexion'],
        'error.html'         => ['controller' =>'PostsController', 'method' => 'error']
    ];


    public function __construct($request)
    {
        $this -> request =$request;
    }

    /**
     *  public function findController()
     *
     *  Retrieve controller from request read in browser adress
     */

    public function findController()
    {
        $request = $this->request;

        if (key_exists($request , $this->routes))
        {
            $controller = $this->routes[$request]['controller'];
            $method = $this->routes[$request]['method'];

            $currentController = new $controller();
            $currentController ->$method();
        }else{
            //$myView = new View('error');
            //$myView->build( array('chapters'=> null ,'comments'=>null,'warningList' => null,'HOST'=>HOST, 'adminLevel' => $_SESSION['adminLevel']));
        }
    }

}