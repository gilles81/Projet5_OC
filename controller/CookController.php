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
        $this->sessionStatus();//determine status admin or not
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
    public function adminAddCardRecipeView()
    {
        $manager = new CookManager();
        $recipes= $manager->createEmptyRecipe();
        $recipes= $manager->findDishes();
        $myView = new View('adminRecipes');
        $myView->build( array('recipes'=> $recipes ,'comments'=>null,'warningList' => null ,'message'=>null,'HOST'=>HOST ,'adminLevel'=> $_SESSION['adminLevel']));
    }

    public function adminUpdateRecipeView()
    {

        if (isset($_GET['dishId'])&& (ctype_digit($_GET['dishId']) ==1 ) && $_GET['dishId']>0 ) {

            $manager = new CookManager();

            $recipes= $manager->findDish($_GET['dishId']);

            $myView = new View('adminUpdateRecipe');
            $myView->build( array('recipes'=> $recipes ,'comments'=>null,'warningList' => null ,'message'=>null,'HOST'=>HOST ,'adminLevel'=> $_SESSION['adminLevel']));
        }


    }

// TODO:  verify
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
// todo :
    public function adminSendNewRecipeName()
    {
        if ((!isset($_POST['Annulation']) )) {
            if ((isset($_POST['newName'])) AND (isset($_POST['newName'])) AND (isset($_GET['dishId'] ))  AND ($_GET['dishId'] >=(int) 0) AND (ctype_digit($_GET['dishId']) ==1 ))  {
                // Get Bdd ident

                $data = array();
                $newRecipe= new BasicDish($data);
                $newRecipe->setDishId($_GET['dishId']);
                $newRecipe->setName($_POST['newName']);

                // Manager Call
                $manager = new CookManager();
                $manager->UpdateRecipeName( $newRecipe);

                $recipe=$manager->findDish($_GET['dishId'] );
                $myView = new View('adminUpdateRecipe');
                $myView->build( array('recipes'=> $recipe ,'comments'=>null,'warningList' => null ,'message'=>null,'HOST'=>HOST ,'adminLevel'=> $_SESSION['adminLevel']));



                //View call
                $myView = new View(' ');
                //$myView->redirect('home.html');
            }else {
                $myView = new View('error');
                $myView->build( array('recipes'=> null ,'comments'=>null,'warningList' => null,'message'=>null,'HOST'=>HOST, 'adminLevel' => $_SESSION['adminLevel']));
            }
        }else{
            $myView = new View('error');
            $myView->build( array('recipes'=> null ,'comments'=>null,'warningList' => null,'message'=>null,'HOST'=>HOST, 'adminLevel' => $_SESSION['adminLevel']));
        }



    }

    public function adminSendNewRecipePreparation()
    {
        if ((!isset($_POST['Annulation']) )) {
            if ((isset($_POST['newRecipePreparation'])) AND (isset($_POST['newRecipePreparation'])) AND (isset($_GET['dishId'] ))  AND ($_GET['dishId'] >=(int) 0) AND (ctype_digit($_GET['dishId']) ==1 ))  {
                // Get Bdd ident

                $data = array();
                $newRecipe= new BasicDish($data);
                $newRecipe->setDishId($_GET['dishId']);
                $newRecipe->setRecipe($_POST['newRecipePreparation']);


                $manager = new CookManager();
                $manager->UpdateRecipePreparation( $newRecipe);
                $recipe=$manager->findDish($_GET['dishId'] );

                $myView = new View('adminUpdateRecipe');
                $myView->build( array('recipes'=> $recipe ,'comments'=>null,'warningList' => null ,'message'=>null,'HOST'=>HOST ,'adminLevel'=> $_SESSION['adminLevel']));


            }else {

                $myView = new View('error');
                $myView->build( array('recipes'=> null ,'comments'=>null,'warningList' => null,'message'=>null,'HOST'=>HOST, 'adminLevel' => $_SESSION['adminLevel']));
            }
        }else{

            $myView = new View('error');
            $myView->build( array('recipes'=> null ,'comments'=>null,'warningList' => null,'message'=>null,'HOST'=>HOST, 'adminLevel' => $_SESSION['adminLevel']));
        }



    }



    public function adminUpdateStatusRecipe()
    {

        if ((isset($_POST['customRadioInline1'])) AND (isset($_GET['dishId'] ))  AND ($_GET['dishId'] >=(int) 0) AND (ctype_digit($_GET['dishId']) ==1 ))  {
            // Get Bdd ident

            $data = array();
            $newRecipe= new BasicDish($data);
            $newRecipe->setDishId($_GET['dishId']);
            $newRecipe->setStatus($_POST['customRadioInline1']);


            $manager = new CookManager();
            $manager->UpdateRecipeStatus( $newRecipe);
            $recipe=$manager->findDish($_GET['dishId'] );

            $myView = new View('adminUpdateRecipe');
            $myView->build( array('recipes'=> $recipe ,'comments'=>null,'warningList' => null ,'message'=>null,'HOST'=>HOST ,'adminLevel'=> $_SESSION['adminLevel']));


        }else {

            $myView = new View('error');
            $myView->build( array('recipes'=> null ,'comments'=>null,'warningList' => null,'message'=>null,'HOST'=>HOST, 'adminLevel' => $_SESSION['adminLevel']));
        }

    }


    public function adminUpdateDifficultyRecipe()
    {

        if ((isset($_POST['DifficultyFormValue'])) AND (isset($_GET['dishId'] ))  AND ($_GET['dishId'] >=(int) 0) AND (ctype_digit($_GET['dishId']) ==1 ))  {
            // Get Bdd ident

            $data = array();
            $newRecipe= new BasicDish($data);
            $newRecipe->setDishId($_GET['dishId']);
            $newRecipe->setStatus($_POST['DifficultyFormValue']);


            $manager = new CookManager();
            $manager->UpdateRecipeDifficulty( $newRecipe);
            $recipe=$manager->findDish($_GET['dishId'] );

            $myView = new View('adminUpdateRecipe');
            $myView->build( array('recipes'=> $recipe ,'comments'=>null,'warningList' => null ,'message'=>null,'HOST'=>HOST ,'adminLevel'=> $_SESSION['adminLevel']));


        }else {

            $myView = new View('error');
            $myView->build( array('recipes'=> null ,'comments'=>null,'warningList' => null,'message'=>null,'HOST'=>HOST, 'adminLevel' => $_SESSION['adminLevel']));
        }

    }
//

    public function adminUpdatePortionRecipe()
    {

        if ((isset($_POST['PortionFormValue'])) AND (isset($_GET['dishId'] ))  AND ($_GET['dishId'] >=(int) 0) AND (ctype_digit($_GET['dishId']) ==1 ))  {
            // Get Bdd ident

            $data = array();
            $newRecipe= new BasicDish($data);
            $newRecipe->setDishId($_GET['dishId']);
            $newRecipe->setPortion($_POST['PortionFormValue']);

            $manager = new CookManager();
            $manager->UpdateRecipePortion( $newRecipe);
            $recipe=$manager->findDish($_GET['dishId'] );

            $myView = new View('adminUpdateRecipe');
            $myView->build( array('recipes'=> $recipe ,'comments'=>null,'warningList' => null ,'message'=>null,'HOST'=>HOST ,'adminLevel'=> $_SESSION['adminLevel']));


        }else {

            $myView = new View('error');
            $myView->build( array('recipes'=> null ,'comments'=>null,'warningList' => null,'message'=>null,'HOST'=>HOST, 'adminLevel' => $_SESSION['adminLevel']));
        }

    }

    public function adminUpdateOriginRecipe()
    {
        echo $_POST['OriginFormValue'];
        if ((isset($_POST['OriginFormValue'])) AND (isset($_GET['dishId'] ))  AND ($_GET['dishId'] >=(int) 0) AND (ctype_digit($_GET['dishId']) ==1 ))  {
            // Get Bdd ident

            $data = array();
            $newRecipe= new BasicDish($data);
            $newRecipe->setDishId($_GET['dishId']);
            $newRecipe->setOrigin($_POST['OriginFormValue']);

            $manager = new CookManager();
            $manager->UpdateRecipeOrigin( $newRecipe);
            $recipe=$manager->findDish($_GET['dishId'] );

            $myView = new View('adminUpdateRecipe');
            $myView->build( array('recipes'=> $recipe ,'comments'=>null,'warningList' => null ,'message'=>null,'HOST'=>HOST ,'adminLevel'=> $_SESSION['adminLevel']));


        }else {

            $myView = new View('error');
            $myView->build( array('recipes'=> null ,'comments'=>null,'warningList' => null,'message'=>null,'HOST'=>HOST, 'adminLevel' => $_SESSION['adminLevel']));
        }

    }
    public function adminUpdateCategoryRecipe()
    {
        if ( (isset($_GET['dishId'] )) AND ($_GET['dishId'] >=(int)0) ) {

            // variable set to 0 the variable checked shal be set to 1 when checkbox is on
            $cat1check = 0;
            $cat2check = 0;
            $cat3check = 0;
            $cat4check = 0;

            if (isset($_POST['CategoryValueCatchoix'])) {
                foreach ($_POST['CategoryValueCatchoix'] as $cat) {
                    if ($cat == 1) {$cat1check=1;}
                    if ($cat == 2) {$cat2check=1;}
                    if ($cat == 3) {$cat3check=1;}
                    if ($cat == 4) {$cat4check=1;}
                }

                $data = array();
                $newRecipe= new BasicDish($data);
                $newRecipe->setDishId($_GET['dishId']);
                $newRecipe->setCat1($cat1check);
                $newRecipe->setCat2($cat2check);
                $newRecipe->setCat3($cat3check);
                $newRecipe->setCat4($cat4check);

                $manager = new CookManager();
                $manager->UpdateRecipeCategory( $newRecipe);

                $manager = new CookManager();
                $recipe = $manager->findDish($_GET['dishId']);

                $myView = new View('adminUpdateRecipe');
                $myView->build(array('recipes' => $recipe, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));
            } else {
                $data = array();
                $newRecipe= new BasicDish($data);
                $newRecipe->setDishId($_GET['dishId']);
                $newRecipe->setCat1(0);
                $newRecipe->setCat2(0);
                $newRecipe->setCat3(0);
                $newRecipe->setCat4(0);
                $manager = new CookManager();
                $manager->UpdateRecipeCategory( $newRecipe);
                $manager = new CookManager();
                $currentRecipe = $manager->findDish($_GET['dishId']);
                $myView = new View('adminUpdateRecipe');
                $myView->build(array('recipes' => $currentRecipe, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));
            }
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