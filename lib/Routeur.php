<?php
session_start();
/**
 * Class Router
 *
 *Create route et find controller
 */

class Routeur
{
    private $request;
    private $routes = [
        //Miscellanous
        'contact.html'                          => ['controller' => 'MiscController', 'method' => 'ShowContact'],
        'contactMail.html'                      => ['controller' => 'MiscController', 'method' => 'ContactMail'],
        'LegalMentions.html'                    => ['controller' => 'MiscController', 'method' => 'legalMentions'],
        'about.html'                            => ['controller' => 'MiscController', 'method' => 'ShowAbout'],
        // Member identification
        'admin.html'                            => ['controller' => 'MemberController', 'method' => 'loginSession'],
        'adminverif.html'                       => ['controller' => 'MemberController', 'method' => 'identification'],
        // Users part
        'home.html'                             => ['controller' => 'CookController', 'method' => 'showHome'],
        'recipe.html'                           => ['controller' => 'CookController', 'method' => 'showDish'],
        'category.html'                         => ['controller' => 'CookController', 'method' => 'showCategory'],
        'homeRecipesCat1.html'                  => ['controller' => 'CookController', 'method' => 'homeRecipesCat1View'],
        'homeRecipesCat2.html'                  => ['controller' => 'CookController', 'method' => 'homeRecipesCat2View'],
        'homeRecipesCat3.html'                  => ['controller' => 'CookController', 'method' => 'homeRecipesCat3View'],
        'homeRecipesCat4.html'                  => ['controller' => 'CookController', 'method' => 'homeRecipesCat4View'],
        'error.html'                            => ['controller' =>'PostsController', 'method' => 'error'],
        // Recipe Administration
        'adminBoard.html'                       => ['controller' => 'CookController', 'method' => 'adminBoard'],
        'adminRecipes.html'                     => ['controller' => 'CookController', 'method' => 'adminRecipes'],
        'adminSendNewRecipeName.html'           => ['controller' => 'CookController', 'method' => 'adminSendNewRecipeName'],
        'adminSendNewRecipePreparation.html'    => ['controller' => 'CookController', 'method' => 'adminSendNewRecipePreparation'],
        'adminAddCardRecipe.html'               => ['controller' => 'CookController', 'method' => 'adminAddCardRecipeView'],
        'adminSendNewRecipe.html'               => ['controller' => 'CookController', 'method' => 'adminSendNewRecipe'],
        'adminRemoveRecipe.html'                => ['controller' => 'CookController', 'method' => 'adminRemoveDish'],
        'adminRemoveIngredientRecipe.html'      => ['controller' => 'CookController', 'method' => 'adminRemoveIngredientRecipe'],
        'adminNewPictureRecipeInDB.html'        => ['controller' => 'CookController', 'method' => 'adminNewPictureRecipeInDB'], // Ne fonctionne pas a supprimer a pres debug
        'adminUpdateRecipe.html'                => ['controller' => 'CookController', 'method' => 'adminUpdateRecipeView'],
        'adminSendUpdateRecipe.html'            => ['controller' => 'CookController', 'method' => 'adminUpdateStatusRecipe'],
        'findInDb.html'                         => ['controller' => 'CookController', 'method' => 'findInDb'],
        'adminRecipesSearch.html'               => ['controller' => 'CookController', 'method' => 'adminRecipesSearch'],
        'adminCopyRecipe.html'                  => ['controller' => 'CookController', 'method' => 'adminCopyRecipe'],
        'deconnection.html'                     => ['controller' => 'MemberController', 'method' => 'deconnection'],
// Zone de test
        'adminSearchComputeList.html'           => ['controller' => 'CookController', 'method' => 'adminSearchComputeList'],


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
            $myView->build( array('recipes'=> null ,'ingredients'=>null,'comments'=>null,'warningList' => null,'message'=>null,'HOST'=>HOST, 'adminLevel' => $_SESSION['adminLevel']));
        }
    }

}