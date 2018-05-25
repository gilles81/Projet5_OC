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
        'contact.html'                  => ['controller' => 'MiscController', 'method' => 'ShowContact'],
        'contactMail.html'              => ['controller' => 'MiscController', 'method' => 'ContactMail'],
        //'about.html'                    => ['controller' => 'MiscController', 'method' => 'ShowAbout'],
        'home.html'                             => ['controller' => 'CookController', 'method' => 'showHome'],
        'admin.html'                            => ['controller' => 'MemberController', 'method' => 'loginSession'],
        'adminverif.html'                       => ['controller' => 'MemberController', 'method' => 'identification'],
        'adminBoard.html'                       => ['controller' => 'CookController', 'method' => 'adminBoard'],
        'adminRecipes.html'                     => ['controller' => 'CookController', 'method' => 'adminRecipes'],
        'adminUpdateRecipe.html'                => ['controller' => 'CookController', 'method' => 'adminUpdateRecipeView'],
        'adminSendNewRecipeName.html'           => ['controller' => 'CookController', 'method' => 'adminSendNewRecipeName'],
        'adminSendNewRecipePreparation.html'    => ['controller' => 'CookController', 'method' => 'adminSendNewRecipePreparation'],
        'adminAddCardRecipe.html'               => ['controller' => 'CookController', 'method' => 'adminAddCardRecipeView'],
        'adminSendNewRecipe.html'               => ['controller' => 'CookController', 'method' => 'adminSendNewRecipe'],
        'adminRemoveRecipe.html'                => ['controller' => 'CookController', 'method' => 'adminRemoveDish'],
        'adminUpdateStatusRecipe.html'          => ['controller' => 'CookController', 'method' => 'adminUpdateStatusRecipe'],
        'adminUpdateDifficultyRecipe.html'      => ['controller' => 'CookController', 'method' => 'adminUpdateDifficultyRecipe'],
        'adminUpdatePortionRecipe.html'         => ['controller' => 'CookController', 'method' => 'adminUpdatePortionRecipe'],
        'adminUpdateOriginRecipe.html'          => ['controller' => 'CookController', 'method' => 'adminUpdateOriginRecipe'],
        'adminUpdateCategoryRecipe.html'        => ['controller' => 'CookController', 'method' => 'adminUpdateCategoryRecipe'],


        'recipe.html'                     => ['controller' => 'CookController', 'method' => 'showDish'],
        'category.html'                     => ['controller' => 'CookController', 'method' => 'showCategory'],

        // 'admin.html'                    => ['controller' => 'MemberController', 'method' => 'loginSession'],
        'deconnection.html'              => ['controller' => 'MemberController', 'method' => 'deconnection'],
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
            $myView = new View('error');
            $myView->build( array('recipes'=> null ,'comments'=>null,'warningList' => null,'message'=>null,'HOST'=>HOST, 'adminLevel' => $_SESSION['adminLevel']));
        }
    }

}