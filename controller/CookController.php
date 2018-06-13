<?php

/**
 * Class CookController
 */
class CookController extends lib
{

    /**
     *
     * showhome
     *
     * call manager to get all chapters in database .
     * call a manger to get warning List on comment .
     *
     */

    public function showHome()
    {
        $this->sessionStatus();//if not session open a session user is open
        // Call of manager to get all recipes
        $manager = new CookManager();
        $recipes = $manager->findCategory('4', 'R');
        $message = "Selection";
        if (empty($recipes)) {
            $recipes = $manager->findDishesfromStatus('R'); // R = ready to display
            $message = "Toutes nos recettes";
        }

        $myView = new View('home');
        $myView->build(array('recipes' => $recipes, 'comments' => null, 'ingredients' => null, 'warningList' => null, 'message' => $message, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));
    }

    /**
     * showDish()
     *
     * show one dish from dishId
     */
    public function showDish()
    {

        if (isset($_GET['dishId']) AND ($_GET['dishId'] > 0)) {
            $this->sessionStatus();
            $manager = new CookManager();
            $recipe = $manager->findDish($_GET['dishId']);
            if (!empty($recipe)) {

                $manager = new CookManager();
                $recipe = $manager->findDish($_GET['dishId']);

                $IngredientsRecipes = $manager->findIngredientsRecipe($_GET['dishId']);
                $ArrayOfIngredients = array();
                $ArrayOfIngredients = ["", $IngredientsRecipes];

                $myView = new View('recipe');
                $myView->build(array('recipes' => $recipe, 'ingredients' => $ArrayOfIngredients, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));
            } else {
                $myView = new View('error');
                $myView->build(array('recipes' => null, 'ingredients' => null, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));
            }
        } else {

            $myView = new View('error');
            $myView->build(array('recipes' => null, 'ingredients' => null, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));
        }

    }

    /**
     * showCategory()
     * .
     * call manager to get recipe thank to a category
     *
     */
    public function showCategory()
    {
        $this->sessionStatus();
        if (isset($_GET['category']) and $_GET['category'] > 0) {

            $manager = new CookManager();
            $recipes = $manager->findCategory($_GET['category'], 'R');
            if (!empty($recipes)) {
                $myView = new View('home');
                $myView->build(array('recipes' => $recipes, 'ingredients' => null, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));
            } else {
                $manager = new CookManager();
                $recipes = $manager->findDishesFromStatus("R");
                $myView = new View('home');
                $myView->build(array('recipes' => $recipes, 'ingredients' => null, 'comments' => null, 'warningList' => null, 'message' => 'Il n\'y a pas encore de recette dans cette categorie !', 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));
            }
        } else {
            $myView = new View('error');
            $myView->build(array('recipes' => null, 'ingredients' => null, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));
        }
    }


    /**
     *
     * adminBoard()
     *
     * call a view for administration Menu
     *
     */

    public function adminBoard()
    {
        $this->sessionStatus();//determine status admin or not
            if ($_SESSION['adminLevel']==1) {
                $myView = new View('adminBoard');
                $myView->build(array('recipes' => null, 'ingredients' => null, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));
            }else {
                $myView = new View('');
                $myView->redirect('admin.html');

            }
    }

/*
 * adminAddCardRecipeView()
 *
 *  call a manager to create an empty recipe in database and go to corresponding view
 */

    public function adminAddCardRecipeView()
    {
        $this->sessionStatus();
        if ($_SESSION['adminLevel']==1) {
            $manager = new CookManager();
            $recipes = $manager->createEmptyRecipe();
            $recipes = $manager->findDishes();

            $myView = new View('adminRecipes');
            $myView->build(array('recipes' => $recipes, 'ingredients' => null, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));
        }else {
            $myView = new View('');
            $myView->redirect('admin.html');

        }
        }

    /**
     *
     * adminUpdateRecipeView()
     *
     * call manager and view for updating view
     *
     */

    public function adminUpdateRecipeView()
    {
        $this->sessionStatus();
        if ($_SESSION['adminLevel']==1) {
            if (isset($_GET['dishId']) && (ctype_digit($_GET['dishId']) == 1) && $_GET['dishId'] > 0) {
                $this->sessionStatus();//determine status admin or not
                $manager = new CookManager();
                $recipe = $manager->findDish($_GET['dishId']);
                $IngredientsList = $manager->findIngredientsList();// list of ingredient in db
                $IngredientsRecipes = $manager->findIngredientsRecipe($_GET['dishId']);
                $IngredientsListNotSelected = $this->findIngredientsListAlreadySelectioned($IngredientsList, $IngredientsRecipes);
                $ArrayOfIngredients = array();
                $ArrayOfIngredients = [$IngredientsListNotSelected, $IngredientsRecipes];
                $myView = new View('adminUpdateRecipe');
                $myView->build(array('recipes' => $recipe, 'ingredients' => $ArrayOfIngredients, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));

            }
        }else {
            $myView = new View('');
            $myView->redirect('admin.html');

        }

    }



    /**
     *
     * adminRemoveDish()
     *
     *  call manager to remove a recipe in db
     */

    public function adminRemoveDish()
    {
        $this->sessionStatus();
        if ($_SESSION['adminLevel']==1) {
            if (isset($_GET['dishId']) AND $_GET['dishId'] > 0 AND (ctype_digit($_GET['dishId']) == 1)) {
                $manager = new CookManager();
                $manager->removeDish($_GET['dishId']);

                $myView = new View('');
                $myView->redirect('adminRecipes.html');
            } else {
                $myView = new View('error');
                $myView->build(array('recipes' => null, 'ingredients' => null, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));
            }
        }else {
            $myView = new View('');
            $myView->redirect('admin.html');
        }
    }

    /**
     *
     * adminRemoveIngredientRecipe()
     *
     * call a manager to remove in RecipeIngredient table . This table is a table for link a recipe to an ingredient
     *
     *
     */

    public function adminRemoveIngredientRecipe()
    {
        $this->sessionStatus();
        if ($_SESSION['adminLevel']==1) {
            if (isset($_GET['IngredientId']) AND ($_GET['IngredientId'] > 0) AND (ctype_digit($_GET['IngredientId']) == 1) AND
                isset($_GET['RecipeId']) AND ($_GET['RecipeId'] > 0) AND (ctype_digit($_GET['RecipeId']) == 1)) {

                $manager = new CookManager();
                $manager->removeIngredientRecipe($_GET['RecipeId'], $_GET['IngredientId']);

                $recipe = $manager->findDish($_GET['RecipeId']);
                $IngredientsList = $manager->findIngredientsList();// list of ingredient in db
                $IngredientsRecipes = $manager->findIngredientsRecipe($_GET['RecipeId']);
                $IngredientsListNotSelected = $this->findIngredientsListAlreadySelectioned($IngredientsList, $IngredientsRecipes);
                $ArrayOfIngredients = array();
                $ArrayOfIngredients = [$IngredientsListNotSelected, $IngredientsRecipes];
                $myView = new View('adminUpdateRecipe');
                $myView->build(array('recipes' => $recipe, 'ingredients' => $ArrayOfIngredients, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));

            } else {
                $myView = new View('error');
                $myView->build(array('recipes' => null, 'ingredients' => null, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));

            }
        }else {
            $myView = new View('');
            $myView->redirect('admin.html');
        }
    }

    /**
     *
     * adminUpdateStatusRecipe()
     *
     *   Method actions :
     *
     *       - update picture on a recipe
     *         and save all categorie status ,
     *
     *
     */
    public function adminUpdateStatusRecipe()
    {
        $this->sessionStatus();
        if ($_SESSION['adminLevel']==1) {
        // Pictures
        if (isset($_FILES['customFile'])) {
            $dossier = ROOT . "assets\pics/";
            $time = time();
            $fichier = $time . '_' . basename($_FILES['customFile']['name']);

            if (move_uploaded_file($_FILES['customFile']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
            {
                echo 'Upload effectué avec succès !';
            } else //Sinon (la fonction renvoie FALSE).
            {
                echo 'Echec de l\'upload !';
            }
        }


        if ((isset($_GET['dishId'])) AND ($_GET['dishId'] >= (int)0) AND (ctype_digit($_GET['dishId']) == 1)) {
            $data = array();
            $newRecipe = new BasicDish($data);
            $newRecipe->setDishId($_GET['dishId']);
            $manager = new CookManager();
            // Name
            if ((isset($_POST['newName']))) {
                // Get Bdd ident

                $newRecipe->setName($_POST['newName']);
                $manager->UpdateRecipeName($newRecipe);
            }
            // Recipe content
            if ((isset($_POST['newRecipe']))) {
                // Get Bdd ident
                $newRecipe->setRecipe($_POST['newRecipe']);
                $manager->UpdateRecipePreparation($newRecipe);
            }

            // Status --> draft , ready , waiting ...
            if ((isset($_POST['customRadioInline1']))) {
                // Get Bdd ident
                $newRecipe->setStatus($_POST['customRadioInline1']);
                $manager->UpdateRecipeStatus($newRecipe);
            }

            // Difficulty
            if ((isset($_POST['DifficultyFormValue']))) {
                $newRecipe->setDifficulty($_POST['DifficultyFormValue']);
                $manager->UpdateRecipeDifficulty($newRecipe);
            }
            // Portion
            if ((isset($_POST['PortionFormValue']))) {
                $newRecipe->setPortion($_POST['PortionFormValue']);
                $manager->UpdateRecipePortion($newRecipe);
            }

            // Origin
            if ((isset($_POST['OriginFormValue']))) {
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
                    if ($cat == 1) {
                        $cat1check = 1;
                    }
                    if ($cat == 2) {
                        $cat2check = 1;
                    }
                    if ($cat == 3) {
                        $cat3check = 1;
                    }
                    if ($cat == 4) {
                        $cat4check = 1;
                    }
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
            // Cooking Time
            if ((isset($_POST['CookingTimeFormValue']))) {
                // Get Bdd ident

                $newRecipe->setCookingTime($_POST['CookingTimeFormValue']);
                $manager->UpdateRecipeCookingTime($newRecipe);
            }
            // Preparation Time
            if ((isset($_POST['PreparationTimeFormValue']))) {
                // Get Bdd ident
                $newRecipe->setPreparationTime($_POST['PreparationTimeFormValue']);
                $manager->UpdateRecipePreparationTime($newRecipe);
            }
            // Ingredients
            if ((isset($_POST['NewRecipeIngredient']))) {
                if ((isset($_POST['UnitFormValue']))) {
                    $Unit = $_POST['UnitFormValue'];
                } else {
                    $Unit = "";
                }
                if ((isset($_POST['QuantityFormValue']) AND (!empty($_POST['QuantityFormValue'])))) {
                    $manager->createRecipeIngredient($_GET['dishId'], $_POST['NewRecipeIngredient'], $_POST['QuantityFormValue'], $Unit);
                }
                $manager->createRecipeIngredient($_GET['dishId'], $_POST['NewRecipeIngredient'], $_POST['QuantityFormValue'], $Unit);
            }
        } else { // If not a good  dish ID

            // in case of a not good dis ID , restart to adminRecipes
            $manager = new CookManager();
            $recipe = $manager->findDish($_GET['dishId']);
            $IngredientsList = $manager->findIngredientsList();// list of ingredient in db
            $IngredientsRecipes = $manager->findIngredientsRecipe($_GET['dishId']);
            $IngredientsListNotSelected = $this->findIngredientsListAlreadySelectioned($IngredientsList, $IngredientsRecipes);
            $ArrayOfIngredients = array();
            $ArrayOfIngredients = [$IngredientsListNotSelected, $IngredientsRecipes];
            $myView = new View('adminUpdateRecipe');
            $myView->build(array('recipes' => $recipe, 'ingredients' => $ArrayOfIngredients, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));

        }

        // call of adminUpdateRecipeView updated
        $manager = new CookManager();
        $recipe = $manager->findDish($_GET['dishId']);
        $IngredientsList = $manager->findIngredientsList();// list of ingredient in db
        $IngredientsRecipes = $manager->findIngredientsRecipe($_GET['dishId']);
        $IngredientsListNotSelected = $this->findIngredientsListAlreadySelectioned($IngredientsList, $IngredientsRecipes);
        $ArrayOfIngredients = array();
        $ArrayOfIngredients = [$IngredientsListNotSelected, $IngredientsRecipes];
        $myView = new View('adminUpdateRecipe');
        $myView->build(array('recipes' => $recipe, 'ingredients' => $ArrayOfIngredients, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));

        }else { // case of not session Admin logged
            $myView = new View('');
            $myView->redirect('admin.html');
        }
    }

    /*
     *  adminCopyRecipe()
     *
     *
     *
     */
    public function adminCopyRecipe()
    {
        $this->sessionStatus();
        if ($_SESSION['adminLevel']==1) {
            if (isset($_GET['dishId']) AND $_GET['dishId'] > 0) {
                // call of manager to find a dish
                $manager = new CookManager();
                $currentDish = $manager->findDish($_GET['dishId']);
                // cal a manager to copy a recipe
                $manager = new CookManager();
                $manager->adminCopyRecipe($currentDish);
                // call a view
                $myView = new View('');
                $myView->redirect('adminRecipes.html');
                //$myView = new View('error');
                //myView->build(array('recipes' => null, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));
            } else {
                $myView = new View('error');
                $myView->build(array('recipes' => null, 'ingredients' => null, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));

            }
        }else { // case of not session Admin logged
            $myView = new View('');
            $myView->redirect('admin.html');
        }
    }

    /**
     * adminNewPictureRecipeInDB
     *
     * call a  manager to add a new picture in recpe
     *
     */
    public function adminNewPictureRecipeInDB()
    {
        $this->sessionStatus();
        if ($_SESSION['adminLevel']==1) {
        // Picture loadind and copy into Pics File on serveur
            if (isset($_FILES['customFile']) AND isset($_POST['customHiddenDishId'])) {
                if (isset($_FILES['customFile']['size']) AND (($_FILES['customFile']['size']<= 1000000))
                    AND (isset($_FILES['customFile']['tmp_name'])) AND (!empty($_FILES['customFile']['tmp_name'])))  {
                    $dossier = ROOT . "assets\pics/";
                    $time = time();
                    $fichier = $time . '_' . basename($_FILES['customFile']['name'] . '');


                    $dimensions = getimagesize($_FILES['customFile']['tmp_name']);


                    if ($dimensions[0]==1920 AND $dimensions[1]==1080 ) {
                        if (move_uploaded_file($_FILES['customFile']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
                        {
                            $manager = new CookManager();
                            $currentDish = $manager->addNewPictureRecipeInDB($_POST['customHiddenDishId'], $fichier);
                            $Recipe = $manager->findDish($_POST['customHiddenDishId']);
                            $IngredientsList = $manager->findIngredientsList();
                            $IngredientsRecipes = $manager->findIngredientsRecipe($_POST['customHiddenDishId']);
                            $ArrayOfIngredients = array();
                            $ArrayOfIngredients = [$IngredientsList, $IngredientsRecipes];
                            $myView = new View('adminUpdateRecipe');
                            $myView->build(array('recipes' => $Recipe, 'ingredients' => $ArrayOfIngredients, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));
                        } else //Sinon (la fonction renvoie FALSE).
                        {

                            echo 'Echec de l\'upload !';
                        }
                    }else {
                        $manager = new CookManager();
                        $Recipe = $manager->findDish($_POST['customHiddenDishId']);
                        $IngredientsList = $manager->findIngredientsList();
                        $IngredientsRecipes = $manager->findIngredientsRecipe($_POST['customHiddenDishId']);
                        $ArrayOfIngredients = array();
                        $ArrayOfIngredients = [$IngredientsList, $IngredientsRecipes];

                        $myView = new View('adminUpdateRecipe');
                        $myView->build(array('recipes' => $Recipe, 'ingredients' => $ArrayOfIngredients, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));


                    }
                }else {
                    $manager = new CookManager();
                    $Recipe = $manager->findDish($_POST['customHiddenDishId']);
                    $IngredientsList = $manager->findIngredientsList();
                    $IngredientsRecipes = $manager->findIngredientsRecipe($_POST['customHiddenDishId']);
                    $ArrayOfIngredients = array();
                    $ArrayOfIngredients = [$IngredientsList, $IngredientsRecipes];

                    $myView = new View('adminUpdateRecipe');
                    $myView->build(array('recipes' => $Recipe, 'ingredients' => $ArrayOfIngredients, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));

                }
            }else {
                $_SESSION['adminLeve'];
                session_destroy();
                $myView = new View('');
                $myView->redirect('admin.html');

            }
        }else { // case of not session Admin logged
            $myView = new View('');
            $myView->redirect('admin.html');
        }
    }

    /*
     *
     * homeRecipesCat1View()
     *
     * call of view for categorie 1 recipe with status "R"
     *
     */

    public function homeRecipesCat1View()
    {
        // Call of manager to get all recipes
        $manager = new CookManager();
        $recipes = $manager->findCategory('1', 'R');

        $message = ' Voici nos entrées ';

        if (empty($recipes)) {
            $recipes = $manager->findDishesfromStatus('R'); // R = ready to display
            $message = "Nous n'avons pas de recette pour cette categorie - Voici toutes nos recettes";
        }

        $myView = new View('homeRecipes');
        $myView->build(array('recipes' => $recipes, 'comments' => null, 'ingredients' => null, 'warningList' => null, 'message' => $message, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));
    }

    /*
     *
     * homeRecipesCat2View()
     *
     * call of view for categorie 2 recipe with status "R"
     *
     */

    public function homeRecipesCat2View()
    {
        // Call of manager to get all recipes
        $manager = new CookManager();
        $recipes = $manager->findCategory('2', 'R');

        $message = ' Voici nos Plats ';

        if (empty($recipes)) {
            $recipes = $manager->findDishesfromStatus('R'); // R = ready to display
            $message = "Nous n'avons pas de recette pour cette categorie - Voici toutes nos recettes";
        }

        $myView = new View('homeRecipes');
        $myView->build(array('recipes' => $recipes, 'comments' => null, 'ingredients' => null, 'warningList' => null, 'message' => $message, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));
    }

    /*
         *
         * homeRecipesCat1View()
         *
         * call of view for categorie 3 recipe with status "R"
         *
         */
    public function homeRecipesCat3View()
    {
        // Call of manager to get all recipes
        $manager = new CookManager();
        $recipes = $manager->findCategory('3', 'R');

        $message = ' Voici nos desserts  ';

        if (empty($recipes)) {
            $recipes = $manager->findDishesfromStatus('R'); // R = ready to display
            $message = "Nous n'avons pas de recette pour cette categorie - Voici toutes nos recettes";
        }

        $myView = new View('homeRecipes');
        $myView->build(array('recipes' => $recipes, 'comments' => null, 'ingredients' => null, 'warningList' => null, 'message' => $message, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));
    }

    /*
         *
         * homeRecipesCat1View()
         *
         * call of view for categorie 4 recipe with status "R"
         *
         */
    public function homeRecipesCat4View()
    {
        // Call of manager to get all recipes
        $manager = new CookManager();
        $recipes = $manager->findCategory('4', 'R');

        $message = ' Nôtre sélection ';

        if (empty($recipes)) {
            $recipes = $manager->findDishesfromStatus('R'); // R = ready to display
            $message = "Nous n'avons pas de recette pour cette categorie - Voici toutes nos recettes";
        }

        $myView = new View('homeRecipes');
        $myView->build(array('recipes' => $recipes, 'comments' => null, 'ingredients' => null, 'warningList' => null, 'message' => $message, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));
    }


    /*
     *
     * findInDb()
     *
     * call manager for find  dishes in db  with status R
     *
     */

    public function findInDb()

    {

            if (isset($_POST['SearchFormHome']) AND (!empty($_POST['SearchFormHome']))) {

                $manager = new CookManager();
                $recipes = $manager->findInDb($_POST['SearchFormHome']);

                if (empty($recipes)) {
                    $recipes = $manager->findDishesfromStatus('R'); // R = ready to display
                    $message = "Nous n'avons pas pu trouver de recette - Voici toutes nos recettes";
                } else {
                    $message = 'Voici les résultats pour la recherche :  ' . $_POST['SearchFormHome'];

                }

                $myView = new View('homeRecipes');
                $myView->build(array('recipes' => $recipes, 'comments' => null, 'ingredients' => null, 'warningList' => null, 'message' => $message, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));


            } elseif (isset($_POST['SearchFormHome']) AND (empty($_POST['SearchFormHome']))) {
                $manager = new CookManager();

                $recipes = $manager->findDishesfromStatus('R'); // R = ready to display
                $message = "Nous n'avons pas pu trouver de recette - Voici toutes nos recettes";
                $myView = new View('homeRecipes');
                $myView->build(array('recipes' => $recipes, 'comments' => null, 'ingredients' => null, 'warningList' => null, 'message' => $message, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));

            }

    }


    /**
     * adminRecipesSearch()
     *
     *  call manager to find Recipes with all Status for search lblock in recipe admin
     */

    public function adminRecipesSearch()
    {
        $this->sessionStatus();
        if ($_SESSION['adminLevel']==1) {
            if (isset($_POST['adminRecipesFormSearch'])) {
                $manager = new CookManager();
                $recipes = $manager->findDishesSearch();//all status are called

                $myView = new View('adminRecipesSearch');

                $myView->build(array('recipes' => $recipes, 'ingredients' => null, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));
            } else {
                $manager = new CookManager();
                $recipes = $manager->findDishesSearch();//all status are called
                $myView = new View('adminRecipesSearch');
                $myView->build(array('recipes' => $recipes, 'ingredients' => null, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));
            }
        }else { // case of not session Admin logged
            $myView = new View('');
            $myView->redirect('admin.html');
        }
    }

        /**
         * adminRecipes
         *
         * call manager to find all recipes (all status) and call the view display them.
         *
         */
        public function adminRecipes()
    {
        $this->sessionStatus();
        if ($_SESSION['adminLevel']==1) {
            $manager = new CookManager();
            $recipes = $manager->findDishes();//all status are called
            $myView = new View('adminRecipes');

            $myView->build(array('recipes' => $recipes, 'ingredients' => null, 'comments' => null, 'warningList' => null, 'message' => null, 'HOST' => HOST, 'adminLevel' => $_SESSION['adminLevel']));
        }else { // case of not session Admin logged
            $myView = new View('');
            $myView->redirect('admin.html');
        }
    }

    /*
     * adminSearchComputeList()
     *
     *  this Method is in dev phase  it shall be used  for give aa list of ingredients in autocompletion mode of select 2
     *
     */

    public function adminSearchComputeList()
    {
        $this->sessionStatus();
        if ($_SESSION['adminLevel']==1) {
            if (isset($_POST['dishId']) && (ctype_digit($_POST['dishId']) == 1) && $_POST['dishId'] > 0) {
                echo $_POST['dishId'];
                $manager = new CookManager();
                $recipe = $manager->findDish($_POST['dishId']);
                $IngredientsList = $manager->findIngredientsList();// list of ingredient in db
                $IngredientsRecipes = $manager->findIngredientsRecipe($_POST['dishId']);
                $IngredientsListNotSelected = $this->findIngredientsListAlreadySelectioned($IngredientsList, $IngredientsRecipes);
                $ingred = new IngredientJson();
                $json = array();
                $cpt = 1;
                foreach ($IngredientsListNotSelected as $ing) {
                    // creation d'objet
                    $ingred = new IngredientJson();
                    $ingred->setId($cpt);
                    $ingred->setText($ing->getName());
                    $cpt = $cpt + 1;
                    //$tab[]=$ingred;
                    $tab['results'][] = ['id' => $ingred->getId(), 'text' => $ingred->getText()];
                }
                $tab['pagination'] = ['more' => false];
                $tab2 = json_encode($tab);
                var_dump($tab2);
            };
            return $tab2;
        }else { // case of not session Admin logged
            $myView = new View('');
            $myView->redirect('admin.html');
        }
    }

}