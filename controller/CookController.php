<?php
/**
 * Created by PhpStorm.
 * User: Gilles
 * Date: 10/05/2018
 * Time: 09:40
 */

class CookController extends lib
{

    /**
     *
     * showDishes()
     *
     * call manager to get all chapters in database .
     * call a manger to get warning List on comment .
     *
     *
     *
     */

    public function showHome()
    {
        //$this->sessionStatus();//determine status admin or not
        // Call of manager to get all Chapters in DB
        //$manager = new PostManager();
       // $chapters= $manager->findAll();
        // call of manager to get all warningList ( items and reply comment signaled by user)
       // $warningListManager = new PostManager();
       // $warningList= $warningListManager->getWarnings();

/*
        if (empty($warningList)){
            // call of view in case of no warnings on comments and topic
            $myView = new View('home');
            $myView->build( array('chapters'=> $chapters ,'comments'=>null,'warningList' => null ,'HOST'=>HOST ,'adminLevel'=> $_SESSION['adminLevel']));

        } else{
            // call of view in case of warnings on comments and topic
            $myView = new View('home');
            $myView->build( array('chapters'=> $chapters ,'comments'=>null,'warningList' => $warningList,'HOST'=>HOST ,'adminLevel'=> $_SESSION['adminLevel']));
        }
*/
        // Call of manager to get all recipes
        $manager = new CookManager();
        $recipes= $manager->findFeaturedDishes();
        if (empty($recipes)){
            $recipes= $manager->findDishesfromStatus('R'); // R = ready to display
        }

        $myView = new View('home');
        $myView->build( array('recipes'=> $recipes ,'comments'=>null,'warningList' => null ,'message'=>null,'HOST'=>HOST ,'adminLevel'=> $_SESSION['adminLevel']));
    }

    /**
     * showDish()
     *
     * show one dish from disId
     */

    public function showDish()
    {
        // Call of manager to get all recipes

        if (isset($_GET['dishId']) AND ($_GET['dishId'] >0) ) {
            $manager = new CookManager();
            $recipe= $manager->findDish($_GET['dishId']);
            if (!empty($recipe)){
                $_SESSION['adminLevel']=0;
                $myView = new View('recipe');
                $myView->build( array('recipes'=> $recipe ,'comments'=>null,'warningList' => null ,'message'=>null,'HOST'=>HOST ,'adminLevel'=> $_SESSION['adminLevel']));
            }else{
                $_SESSION['adminLevel']=0;
                $myView = new View('error');
                $myView->build( array('recipes'=>null ,'comments'=>null,'warningList' => null, 'message'=>null,'HOST'=>HOST ,'adminLevel'=> $_SESSION['adminLevel']));
            }
        }else {
            $_SESSION['adminLevel']=0;
        $myView = new View('error');
        $myView->build( array('recipes'=>null ,'comments'=>null,'warningList' => null ,'message'=>null,'HOST'=>HOST ,'adminLevel'=> $_SESSION['adminLevel']));
        }

    }

    /**
     * showCategory()
     * .
     * call manager to get recipe thank to a category
     *
     *
     *
     */
    public function showCategory()
    {
        if (isset($_GET['category']) and $_GET['category']>0){
            $manager = new CookManager();
            $recipes= $manager->findCategory($_GET['category'],'R');
            if (!empty($recipes)){
                $myView = new View('home');
                $myView->build( array('recipes'=> $recipes ,'comments'=>null,'warningList' => null ,'message'=>null ,'HOST'=>HOST ,'adminLevel'=> $_SESSION['adminLevel']));
            }else{



                $manager = new CookManager();
                $recipes= $manager->findDishesFromStatus("R");

                $myView = new View('home');
                $myView->build( array('recipes'=> $recipes ,'comments'=>null,'warningList' => null ,'message'=>'Il n\'y a pas encore de recette dans cette categorie !','HOST'=>HOST ,'adminLevel'=> $_SESSION['adminLevel']));

                //$myView = new View('errorContaintNotAllowed');
               // $myView->build( array('recipes'=>null ,'comments'=>null,'warningList' => null ,'HOST'=>HOST ,'adminLevel'=> $_SESSION['adminLevel']));


            }
        }else {
            $myView = new View('error');
            $myView->build( array('recipes'=>null ,'comments'=>null,'warningList' => null ,'message'=>null,'HOST'=>HOST ,'adminLevel'=> $_SESSION['adminLevel']));
        }
    }
    public function adminBoard()
    {
        $myView = new View('adminBoard');
        $myView->build( array('recipes'=> null ,'comments'=>null,'warningList' => null ,'message'=>null,'HOST'=>HOST ,'adminLevel'=> $_SESSION['adminLevel']));
    }

    public function adminRecipes()
    {
        $manager = new CookManager();
        $recipes= $manager->findDishes();//all status are called
        $myView = new View('adminRecipes');
        $myView->build( array('recipes'=> $recipes ,'comments'=>null,'warningList' => null ,'message'=>null,'HOST'=>HOST ,'adminLevel'=> $_SESSION['adminLevel']));

    }
    public function adminAddRecipeView()
    {

        $manager = new CookManager();
        $recipes= $manager->createEmptyRecipe();
        $recipes= $manager->findDishes();
        $myView = new View('adminRecipes');
        $myView->build( array('recipes'=> $recipes ,'comments'=>null,'warningList' => null ,'message'=>null,'HOST'=>HOST ,'adminLevel'=> $_SESSION['adminLevel']));



    }

    public function adminSendNewRecipe() {
        if (isset($_POST['newRecipePreparation']) AND isset($_POST['newRecipeTitle'])) {
            if (!empty($_POST['newRecipeTitle']) AND (!empty($_POST['newRecipePreparation']))  ) {
                $values = array('Title' => $_POST['newRecipeTitle'], 'Preparation' => $_POST['newRecipePreparation']);
                $manager = new CookManager();
                $manager->addDish($values);


                //$myView = new View('error');
                //myView->build(array('recipes' => null, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));

            } else {
                $myView = new View('error');
                $myView->build(array('recipes' => null, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));
            }
        }
    }

    public function adminRemoveDish()
    {
        if (isset($_GET['dishId']) AND $_GET['dishId'] > 0) {
                $manager = new CookManager();
                $manager->removeDish($_GET['dishId']);

                $myView = new View('');
                $myView->redirect('adminRecipes.html');
                //$myView = new View('error');
                //myView->build(array('recipes' => null, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));
        } else {
            $myView = new View('error');
            $myView->build(array('recipes' => null, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));

        }
    }


    public function duplicDish()
    {
        if (isset($_GET['dishId']) AND $_GET['dishId'] > 0) {

            $manager = new CookManager();
            $currentDish = $manager->findDish($_GET['dishId']);

            $manager = new CookManager();
            $manager->duplicRecipe($currentDish);

            $myView = new View('');
            $myView->redirect('adminRecipes.html');
            //$myView = new View('error');
            //myView->build(array('recipes' => null, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));
        } else {
            $myView = new View('error');
            $myView->build(array('recipes' => null, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));

        }
    }

}