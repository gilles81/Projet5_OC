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
        $this->sessionStatus();//determine status admin or not

        // Call of manager to get all recipes
        $manager = new CookManager();
        $recipes= $manager->findCategory('4','R');
        $message ="Selection";
        if (empty($recipes)){
            $recipes= $manager->findDishesfromStatus('R'); // R = ready to display
            $message ="Toutes nos recettes";
        }

        $myView = new View('home');
        $myView->build( array('recipes'=> $recipes ,'comments'=>null,'ingredients'=>null,'warningList' => null ,'message'=>$message,'HOST'=>HOST ,'adminLevel'=> $_SESSION['adminLevel']));
    }

    /**
     * showDish()
     *
     * show one dish from disId
     */

    public function showDish()
    {


        if (isset($_GET['dishId']) AND ($_GET['dishId'] >0) ) {
            $manager = new CookManager();
            $recipe= $manager->findDish($_GET['dishId']);
            if (!empty($recipe)){

                $manager = new CookManager();
                $recipe = $manager->findDish($_GET['dishId']);

                $IngredientsRecipes=$manager->findIngredientsRecipe($_GET['dishId']);
                $ArrayOfIngredients = array();
                $ArrayOfIngredients = ["",$IngredientsRecipes];
                $myView = new View('recipe');
                $myView->build( array('recipes'=> $recipe ,'ingredients'=>$ArrayOfIngredients,'comments'=>null,'warningList' => null ,'message'=>null,'HOST'=>HOST ,'adminLevel'=> $_SESSION['adminLevel']));
            }else{

                $myView = new View('error');
                $myView->build( array('recipes'=>null ,'ingredients'=>null,'comments'=>null,'warningList' => null, 'message'=>null,'HOST'=>HOST ,'adminLevel'=> $_SESSION['adminLevel']));
            }
        }else {

            $myView = new View('error');
            $myView->build( array('recipes'=>null ,'ingredients'=>null,'comments'=>null,'warningList' => null ,'message'=>null,'HOST'=>HOST ,'adminLevel'=> $_SESSION['adminLevel']));
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
            $this->sessionStatus();//determine status admin or not
            $manager = new CookManager();
            $recipes= $manager->findCategory($_GET['category'],'R');
            if (!empty($recipes)){
                $myView = new View('home');
                $myView->build( array('recipes'=> $recipes ,'ingredients'=>null,'comments'=>null,'warningList' => null ,'message'=>null ,'HOST'=>HOST ,'adminLevel'=> $_SESSION['adminLevel']));
            }else{
                $manager = new CookManager();
                $recipes= $manager->findDishesFromStatus("R");
                $myView = new View('home');
                $myView->build( array('recipes'=> $recipes ,'ingredients'=>null,'comments'=>null,'warningList' => null ,'message'=>'Il n\'y a pas encore de recette dans cette categorie !','HOST'=>HOST ,'adminLevel'=> $_SESSION['adminLevel']));

            }
        }else {
            $myView = new View('error');
            $myView->build( array('recipes'=>null ,'ingredients'=>null,'comments'=>null,'warningList' => null ,'message'=>null,'HOST'=>HOST ,'adminLevel'=> $_SESSION['adminLevel']));
        }
    }



    public function adminBoard()
    {
        $myView = new View('adminBoard');
        $myView->build( array('recipes'=> null ,'ingredients'=>null,'comments'=>null,'warningList' => null ,'message'=>null,'HOST'=>HOST ,'adminLevel'=> $_SESSION['adminLevel']));
    }

    /**
     * adminRecipes
     *
     * call manager to find all recipes (all status) and call the view display them.
     *
     */
    public function adminRecipes()
    {
        $manager = new CookManager();
        $recipes= $manager->findDishes();//all status are called
        $myView = new View('adminRecipes');

        $myView->build( array('recipes'=> $recipes ,'ingredients'=>null,'comments'=>null,'warningList' => null ,'message'=>null,'HOST'=>HOST ,'adminLevel'=> $_SESSION['adminLevel']));

    }
    public function adminAddCardRecipeView()
    {
        $manager = new CookManager();
        $recipes= $manager->createEmptyRecipe();
        $recipes= $manager->findDishes();

        $myView = new View('adminRecipes');
        $myView->build( array('recipes'=> $recipes ,'ingredients'=>null,'comments'=>null,'warningList' => null ,'message'=>null,'HOST'=>HOST ,'adminLevel'=> $_SESSION['adminLevel']));
    }

    public function adminUpdateRecipeView()
    {
        if (isset($_GET['dishId'])&& (ctype_digit($_GET['dishId']) ==1 ) && $_GET['dishId']>0 ) {
            $manager = new CookManager();
            $recipe= $manager->findDish($_GET['dishId']);
            $IngredientsList=$manager->findIngredientsList();// list of ingredie,t in db
            $IngredientsRecipes=$manager->findIngredientsRecipe($_GET['dishId']);

            $ArrayOfIngredients = array();
            $ArrayOfIngredients = [$IngredientsList,$IngredientsRecipes];
            $myView = new View('adminUpdateRecipe');
            $myView->build(array('recipes' => $recipe,'ingredients'=>$ArrayOfIngredients, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));

           }
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
                $myView->build(array('recipes' => null,'ingredients'=>null, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));
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
            $myView->build(array('recipes' => null, 'ingredients'=>null,'comments'=> null, 'warningList'=> null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));

        }
    }

    public function adminRemoveIngredientRecipe()
    {

        if (isset($_GET['IngredientId']) AND ($_GET['IngredientId'] > 0) AND
            isset($_GET['RecipeId']) AND ($_GET['RecipeId'] > 0)) {

            $manager = new CookManager();
            $manager->removeIngredientRecipe($_GET['IngredientId']);

            $manager = new CookManager();
            $recipe= $manager->findDish($_GET['RecipeId']);
            $IngredientsList=$manager->findIngredientsList();// list of ingredie,t in db
            $IngredientsRecipes=$manager->findIngredientsRecipe($_GET['RecipeId']);

            $ArrayOfIngredients = array();
            $ArrayOfIngredients = [$IngredientsList,$IngredientsRecipes];
            $myView = new View('adminUpdateRecipe');
            $myView->build(array('recipes' => $recipe,'ingredients'=>$ArrayOfIngredients, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));





            $manager = new CookManager();
            //$manager->removeDish($_GET['dishId']);

           // $myView = new View('');
           // $myView->redirect('adminRecipes.html');
            //$myView = new View('error');
            //myView->build(array('recipes' => null, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));
        } else {
            $myView = new View('error');
           $myView->build(array('recipes' => null, 'ingredients'=>null,'comments'=> null, 'warningList'=> null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));

        }
    }


    public function  adminUpdateStatusRecipe()
    {
        /*
       echo 'on est dans le adminUpdateStatusRecipe <php>';
        echo ' post : </br>';
       var_dump($_POST);
        echo ' files : </br>';
        var_dump($_FILES);
        echo ' </br>';
*/
        if (isset($_FILES['customFile']) ) {
            $dossier=ROOT."assets\pics/";
            $time = time();
            $fichier =  $time.'_'.basename(  $_FILES['customFile']['name']);



            if(move_uploaded_file($_FILES['customFile']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
            {
                echo 'Upload effectué avec succès !';
            }
            else //Sinon (la fonction renvoie FALSE).
            {
                echo 'Echec de l\'upload !';
            }
        }



        if ( (isset($_GET['dishId'] )) AND ($_GET['dishId'] >=(int)0)  AND (ctype_digit($_GET['dishId']) ==1 )) {
            $data = array();
            $newRecipe= new BasicDish($data);
            $newRecipe->setDishId($_GET['dishId']);
            $manager = new CookManager();

            if ((isset($_POST['newName'])) )  {
                // Get Bdd ident

                $newRecipe->setName($_POST['newName']);
                $manager->UpdateRecipeName($newRecipe);
            }
            if ((isset($_POST['newRecipe'])) )  {
                // Get Bdd ident
                $newRecipe->setRecipe($_POST['newRecipe']);
                $manager->UpdateRecipePreparation($newRecipe);
            }
            if ((isset($_POST['customRadioInline1'])) )  {
                // Get Bdd ident
                $newRecipe->setStatus($_POST['customRadioInline1']);
                $manager->UpdateRecipeStatus($newRecipe);
            }

            // Difficulty

            if ((isset($_POST['DifficultyFormValue'])))   {
                $newRecipe->setStatus($_POST['DifficultyFormValue']);
                $manager->UpdateRecipeDifficulty($newRecipe);
            }
            // Portion
            if ((isset($_POST['PortionFormValue'])) )  {
                $newRecipe->setPortion($_POST['PortionFormValue']);
                $manager->UpdateRecipePortion($newRecipe);
            }

            // Origin
            if ((isset($_POST['OriginFormValue'])) )  {
                $newRecipe->setOrigin($_POST['OriginFormValue']);
                $manager->UpdateRecipeOrigin($newRecipe);
            }
            // Category

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
                $newRecipe->setCat1($cat1check);
                $newRecipe->setCat2($cat2check);
                $newRecipe->setCat3($cat3check);
                $newRecipe->setCat4($cat4check);

                $manager->UpdateRecipeCategory($newRecipe);

            } else {
                $newRecipe->setCat1(0);
                $newRecipe->setCat2(0);
                $newRecipe->setCat3(0);
                $newRecipe->setCat4(0);
                $manager->UpdateRecipeCategory($newRecipe);

            }

            if ((isset($_POST['CookingTime'])) )  {
                // Get Bdd ident

                $newRecipe->setCookingTime($_POST['CookingTime']);
                $manager->UpdateRecipeName($newRecipe);
            }

            if ((isset($_POST['PreparationTime'])) )  {
                // Get Bdd ident
                $newRecipe->setCookingTime($_POST['PreparationTime']);
                $manager->UpdateRecipeName($newRecipe);
            }

            if ((isset($_POST['NewRecipeIngredient'])) )  {
                $manager->createRecipeIngredient($_GET['dishId'], $_POST['NewRecipeIngredient']);
                $manager->addIngredientInRecipe($_GET['dishId'],$_POST['NewRecipeIngredient']);
        }

        }else { // If not a good  dish ID

            // todo : refaire vers une page d'eeror
            $manager = new CookManager();
            $currentRecipe = $manager->findDish($_GET['dishId']);
            $IngredientsList=$manager->findIngredientsList();

            $myView = new View('adminUpdateRecipe');
            $myView->build(array('recipes' => $currentRecipe, 'ingredients'=>$IngredientsList, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));

        }
        $manager = new CookManager();
        $Recipe = $manager->findDish($_GET['dishId']);
        $IngredientsList=$manager->findIngredientsList();
        $IngredientsRecipes=$manager->findIngredientsRecipe($_GET['dishId']);
        $ArrayOfIngredients = array();
        $ArrayOfIngredients = [$IngredientsList,$IngredientsRecipes];

        $myView = new View('adminUpdateRecipe');
        $myView->build(array('recipes' => $Recipe,'ingredients'=>$ArrayOfIngredients, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));
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
            $myView->build(array('recipes' => null, 'ingredients'=>null,'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));

        }
    }

    public function adminNewPictureRecipeInDB()
    {
        /*
                echo 'on est dans le adminNewPictureRecipeInDB ';
                var_dump($_POST);
                var_dump($_FILES);
        */
        // Picture loadind and copy into Pics File on serveur
        if (isset($_FILES['customFile']) AND isset($_POST['customHiddenDishId'])) {
            $dossier = ROOT . "assets\pics/";
            $time = time();
            $fichier = $time . '_' . basename($_FILES['customFile']['name'] . '');

            if (move_uploaded_file($_FILES['customFile']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
            {
                //echo 'Upload effectué avec succès !';
                //addNewPictureRecipeInDB($dishId,$pics);
                $manager = new CookManager();
                $currentDish = $manager->addNewPictureRecipeInDB($_POST['customHiddenDishId'], $fichier);
                /*
                $myView = new View('');
                $myView->redirect('adminRecipes.html');
                */
                $Recipe = $manager->findDish($_POST['customHiddenDishId']);
                $IngredientsList=$manager->findIngredientsList();
                $IngredientsRecipes=$manager->findIngredientsRecipe($_POST['customHiddenDishId']);
                $ArrayOfIngredients = array();
                $ArrayOfIngredients = [$IngredientsList,$IngredientsRecipes];

                $myView = new View('adminUpdateRecipe');
                $myView->build(array('recipes' => $Recipe,'ingredients'=>$ArrayOfIngredients, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));


            } else //Sinon (la fonction renvoie FALSE).
            {
                // TODO : Gerer erreur ;
                echo 'Echec de l\'upload !';
            }
        }
    }
}