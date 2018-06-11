<?php
/**
 *
 *Class CookManager
 *
 * M
 */


class CookManager extends BackManager
{
    private  $bdd;

    /**
     * CookManager constructor.
     */
    public function __construct()
    {
        $this->bdd = parent ::bddAssign();
    }

    /**
     *
     *  findDishes
     *
     * Get all Dishes in database return an array.
     *
     *

     * @return array
     */
    public function findDishes()
    {
        $bdd = $this->bdd;
        $perPage=8;
        if (!isset($_POST['adminRecipesFormSearch'])) {

            $req=$bdd->query('SELECT COUNT(*) AS total FROM dish');
            $result=$req->fetch();
            $total = $result['total'];

            $nbPage = ceil($total/$perPage);

            if ((isset ($_GET['page'])) &&  (!empty($_GET['page'])) && (ctype_digit($_GET['page']) ==1 )){
                if ($_GET['page'] > $nbPage) {
                    $current = $nbPage;
                }else {
                    $current = $_GET['page'];
                }
            }else {
                $current = 1;
            }
            $firstOfPage = ($current-1)*$perPage;


            /**
             * model access
             * */
            $query = "SELECT * FROM dish LIMIT $firstOfPage,$perPage ";
            $req = $bdd->prepare($query);
            $req->execute();
            $Dishes=  array();

            while ($row = $req-> fetch(PDO::FETCH_ASSOC))
            {
                $data = $this->rowInArray($row);
                $dish = new BasicDish( $data);
                $Dishes[] = $dish;
            }
            $dishToDisplay = array();
            $dishToDisplay = ['dishes'=>$Dishes ,'cPage'=> $current ,'nbPage'=>$nbPage ];

        }else {

        }





        return  $dishToDisplay;
    }

    /*
     * findDishesSearch()
     *
     * find dish for research block
     *
     */


    public function findDishesSearch()
    {
        $bdd = $this->bdd;
        $perPage=8;
            if (isset($_POST['adminRecipesFormSearch'])) {
                $_SESSION['adminTermSearch']=$_POST['adminRecipesFormSearch'];
                $term= $_SESSION['adminTermSearch'];

            }else {

                if (isset($_SESSION['adminTermSearch'])) {
                    $term= $_SESSION['adminTermSearch'];
                }else {
                    $term = "";
                }

            }


        $termToFind = '%'.$term.'%' ;
        $query="SELECT COUNT(*) AS total FROM dish  WHERE Title LIKE '$termToFind'";

        $req=$bdd->query($query);
        $result=$req->fetch();
        $total = $result['total'];

        $nbPage = ceil($total/$perPage);

        if ((isset ($_GET['page'])) &&  (!empty($_GET['page'])) && (ctype_digit($_GET['page']) ==1 )){
            if ($_GET['page'] > $nbPage) {
                $current = $nbPage;
            }else {
                $current = $_GET['page'];
            }
        }else {
            $current = 1;
        }
        $firstOfPage = ($current-1)*$perPage;

        //$term= $_POST['adminRecipesFormSearch'];
        $termToFind = '%'.$term.'%' ;
        $query = "SELECT * FROM dish WHERE Title LIKE '$termToFind'  LIMIT $firstOfPage,$perPage ";
        $req = $bdd->prepare($query);
        $req->execute();
        $Dishes=  array();

        while ($row = $req-> fetch(PDO::FETCH_ASSOC))
        {
            $data = $this->rowInArray($row);
            $dish = new BasicDish( $data);
            $Dishes[] = $dish;
        }
        $dishToDisplay = array();
        $dishToDisplay = ['dishes'=>$Dishes ,'cPage'=> $current ,'nbPage'=>$nbPage ];


        return  $dishToDisplay;
    }

/*
 * findIngredientsList()
 *
 * Find ingredients list in database
 */
    public function findIngredientsList()
    {
        $bdd = $this->bdd;
        /**
         * model access
         * */
        $query = "SELECT * FROM ingredients";
        $req = $bdd->prepare($query);
        $req->execute();
        $ingredients=  array();

        while ($row = $req-> fetch(PDO::FETCH_ASSOC))
        {
            $IngredientData = $this->ingredientsRowInArray($row);
            $ingredient = new Ingredient($IngredientData);
            $Ingredients[] = $ingredient;
        }


        return  $Ingredients ;
    }




    /**
     * findDishesFromStatus($)
     *
     * find a list of dishes from a  status
     *
     *
     * @return array
     */
    public function findDishesFromStatus($status)
    {
        $bdd = $this->bdd;
        /**
         * model access
         * */
        $query = "SELECT * FROM dish WHERE Status =:Status ";
        $req = $bdd->prepare($query);
        $req->bindValue(':Status', $status , PDO::PARAM_STR);
        $req->execute();

        $Dishes=  array();

        while ($row = $req-> fetch(PDO::FETCH_ASSOC))
        {
            $data = $this->rowInArray($row);
            $dish = new BasicDish( $data);
            $Dishes[] = $dish;

        }
        return $Dishes;
    }


    /**
     * findFeaturedDishes
     *
     * find Featured dishes
     *
     * Featured is  dishes  for a special day or week : Halloween , Noel , Mother day ..
     *
     * @return array
     *
     */
    public function findFeaturedDishes()
    {
        $bdd = $this->bdd;
        /**
         * model access
         * */
        $query = "SELECT * FROM dish WHERE Featured =:Featured AND Status ='R'";


        $req = $bdd->prepare($query);
        $req->bindValue(':Featured', 1 , PDO::PARAM_INT);
        $req->execute();

        $Dishes=  array();

        while ($row = $req-> fetch(PDO::FETCH_ASSOC))
        {
            $data = $this->rowInArray($row);
            $dish = new BasicDish( $data);
            $Dishes[] = $dish;

        }
        return $Dishes;
    }



    /**
     * findDish
     *
     * find a dish in database and return in a object
     *
     * @param $id
     * @return BasicDish
     */
    public function findDish($id)
    {
        /**
         * model access
         * */
        $bdd = $this->bdd;
        $query = "SELECT * FROM dish WHERE DishId =:id";

        $req = $bdd->prepare($query);
        $req->bindValue(':id', $id , PDO::PARAM_INT);
        $req->execute();
        $row= $req->fetch(PDO::FETCH_ASSOC);

        $data = $this->rowInArray($row);
        $dish = new BasicDish( $data);

        return $dish;
    }

    /**
     * findCategory
     *
     * find in db dishes from a categoprie and status
     *
     * @param $category
     * @param $status
     * @return array
     */
    public function findCategory($category ,$status )    {
        $bdd = $this->bdd;
        if ((!isset($status)) AND (($status ='D')  OR ($status ='R') OR ($status ='W') )) {
            $status = 'R';
        }
        $Dishes=  array();
        $idAlreadyInDishes=array();

        if ($category == 1) {
            $query = "SELECT * FROM dish WHERE Cat1 =1 AND Status ='R' ";
            $req = $bdd->prepare($query);
            $req->execute();
            while ($row = $req-> fetch(PDO::FETCH_ASSOC))
            {
                $data = $this->RowInArray($row);
                $dish = new BasicDish($data);

                $recipeDummy=$this->verifyIdInlist( $idAlreadyInDishes,$dish);

                if (!$recipeDummy){
                    $Dishes[] = $dish;
                }
            }
        }
        if ($category == 2) {
            $query = "SELECT * FROM dish WHERE Cat2 =1 AND Status ='R'";
            $req = $bdd->prepare($query);
            $req->execute();
            while ($row = $req-> fetch(PDO::FETCH_ASSOC))
            {
                $data = $this->RowInArray($row);
                $dish = new BasicDish($data);

                $recipeDummy=$this->verifyIdInlist( $idAlreadyInDishes,$dish);

                if (!$recipeDummy){
                    $Dishes[] = $dish;
                }
            }
        }
        if ($category == 3) {
            $query = "SELECT * FROM dish WHERE Cat3 =1 AND Status ='R'";
            $req = $bdd->prepare($query);
            $req->execute();

            while ($row = $req-> fetch(PDO::FETCH_ASSOC))
            {
                $data = $this->RowInArray($row);
                $dish = new BasicDish($data);

                $recipeDummy=$this->verifyIdInlist( $idAlreadyInDishes,$dish);

                if (!$recipeDummy){
                    $Dishes[] = $dish;
                }
            }
        }
        if ($category == 4) {

            $test ="SELECT * FROM dish WHERE Cat4 =1 AND Status ='R'";
            $query = $test ;
            $req = $bdd->prepare($query);
            $req->execute();

            while ($row = $req-> fetch(PDO::FETCH_ASSOC))
            {
                $data = $this->RowInArray($row);
                $dish = new BasicDish($data);

                $recipeDummy=$this->verifyIdInlist( $idAlreadyInDishes,$dish);

                if (!$recipeDummy){
                    $Dishes[] = $dish;
                }
            }
        }

        return $Dishes;

    }


    /**
     *  remove
     *
     * remove a comment from database
     *
     * @param $ComId
     */
    public function remove($ComId)
    {
        $bdd = $this->bdd;
        $req = $bdd->exec("DELETE FROM `Comments` WHERE `CommentId` = $ComId");

        if (!$req) {
            echo 'Erreur a la suppression du commentaire';
        }
    }

    /**
     *
     * adminCopyRecipe
     *
     * copy a relcipe in db
     *
     *
     * @param $currentDish
     */
    public function adminCopyRecipe( $currentDish)
    {

        $bdd = $this->bdd;
/*
        $query = "INSERT INTO `dish` (`DishId`, `Title`, `Category`, `Author`, `CreationDate`, `Recipe`, `Portion`, `ImagePathName`, `Origin`, `CookingTime`,
 `PreparationTime`, `Ingredients`, `Difficulty`, `Featured`, `Status`, `lke`,`cat1`,`cat2`,`cat3`,`cat4` )
                  SELECT  `DishId`, `Title`, `Category`, `Author`, `CreationDate`, `Recipe`, `Portion`, `ImagePathName`, `Origin`, `CookingTime`,
 `PreparationTime`, `Ingredients`, `Difficulty`, `Featured`, `Status`, `lke` ,`cat1`,`cat2`,`cat3`,`cat4`
                FROM `dish` WHERE 'DishId'=111";
*/

        $query = "INSERT INTO `dish` ( `CreationDate` )
                  SELECT  `CreationDate`
                FROM `dish` WHERE 'DishId'=111";
        echo $currentDish->getDishId();
        echo $query;

        $req = $bdd->prepare($query);
        $req->execute();


        /*
        INSERT INTO maTable(colonne1, colonne2, ..., colonneN)
SELECT colonne1, colonne2, ..., colonneN FROM maTable
WHERE id = 1;*/





    }

    /**
     * createEmptyRecipe
     *
     * create a new recipe in db
     *
     *
     */

    public function createEmptyRecipe()
    {
        $bdd = $this->bdd;

        $query = "INSERT INTO `dish` (`DishId`, `Title`, `Category`, `Author`, `CreationDate`, `Recipe`, `Portion`, `ImagePathName`, `Origin`, `CookingTime`,
 `PreparationTime`, `Ingredients`, `Difficulty`, `Featured`, `Status`, `lke`)
                  VALUES (NULL, 'Nouvelle recette ', '1', '', now(), '', '0' , :ImagePathName, '', '0', '0', '', '0', '0', 'D', '0');";

        $req = $bdd->prepare($query);
        $req->bindValue(':ImagePathName','NoPictures_1920_1080.jpg',PDO::PARAM_INT);
        $req->execute();
    }

    /**
     * createRecipeIngredient
     *
     * Create a line in dataBase for a recipe from IdIngredients
     *
     * @param $RecetteId
     * @param $IngredientsId
     */
    public function createRecipeIngredient($RecetteId, $IngredientsId,$quantity,$unit){
        var_dump($RecetteId);
        var_dump($IngredientsId);
        $bdd = $this->bdd;
        $query = "INSERT INTO `recipe_ingredients` (`RecipeId`, `IngredientId`,`quantity`,`unit`)
                  VALUES ( :RecipeId, :IngredientId,:quantity,:unit);";
        $req = $bdd->prepare($query);
        $req->bindValue(':RecipeId',$RecetteId,PDO::PARAM_INT);
        $req->bindValue(':IngredientId',$IngredientsId,PDO::PARAM_INT);
        $req->bindValue(':quantity',$quantity,PDO::PARAM_INT);
        $req->bindValue(':unit',$unit,PDO::PARAM_STR);

        $req->execute();
    }

    /**
     *
     * findIngredientsRecipe
     *
     *
     * find an ingredients for a recipe in db
     *
     *
     * @param $idrecipe
     * @return array
     */

    public function findIngredientsRecipe($idrecipe){


        $bdd = $this->bdd;

        $query =  "SELECT  recipe_ingredients.RecipeId,
                           recipe_ingredients.IngredientId,
                           recipe_ingredients.quantity,
                           recipe_ingredients.unit,
                           ingredients.Name
                           
                    FROM recipe_ingredients 
                    LEFT JOIN ingredients 
                    ON recipe_ingredients.IngredientId=ingredients.Id 
                    WHERE recipe_ingredients.RecipeId=$idrecipe";

        $req = $bdd->prepare($query);
        $req->execute();

        $recipeIngredients=array();


        while ($row = $req-> fetch(PDO::FETCH_ASSOC)) {
            $RecipeIngredientData = array();

            $RecipeIngredientData = $this->recipeIngredientsRowInArray($row);
            $recipeIngredient = new RecipeIngredient($RecipeIngredientData);
            $recipeIngredients[] = $recipeIngredient;
        }


        return $recipeIngredients;
    }


    /**
     * removeIngredientRecipe
     *
     * remove ingredients from recipeId and IngredientId In database recipe_ingredients
     *
     * @param $recipeId
     * @param $ingredientId
     */
    public function removeIngredientRecipe($recipeId,$ingredientId)
    {

        $bdd = $this->bdd;
        $req = $bdd->exec("DELETE FROM `recipe_ingredients` WHERE `RecipeId` = $recipeId AND `IngredientId` = $ingredientId" );
        if (!$req) {
            echo 'Erreur a la suppression du chapitre';
        }
    }

    /**
     *  addNewPictureRecipeInDB
     *
     *  add a new pics in in relcipe
     *
     * @param $dishId
     * @param $pics
     */

    public function addNewPictureRecipeInDB($dishId,$pics)
    {

      $bdd = $this->bdd;

      $query = "UPDATE dish SET ImagePathName=:ImagePathName WHERE DishId=:DishId" ;

      $req = $bdd->prepare($query);
      $req->bindValue(':DishId',$dishId,PDO::PARAM_INT);
      $req->bindValue(':ImagePathName',$pics,PDO::PARAM_STR);
      $req->execute();
    }


    /**
     *  removePost
     *
     * delette a post from database
     *
     * @param $PostId
     */
    public function removeDish( $dishId)
    {

        $bdd = $this->bdd;
        $req = $bdd->exec("DELETE FROM `dish` WHERE `DishId` = $dishId");

        if (!$req) {

            echo 'Erreur a la suppression du chapitre';

        }
    }


    /**
     *
     * UpdateRecipeName
     *
     * update a recipe Name  in db
     *
     *
     * @param $newRecipeName
     */


    public function UpdateRecipeName($newRecipeName)
    {
        $bdd = $this->bdd;
        $req = $bdd->prepare('UPDATE dish SET  Title =:Name WHERE DishId = :DishId ');
        $req->bindValue(':DishId',$newRecipeName->getDishId(),PDO::PARAM_INT);
        $req->bindValue(':Name',$newRecipeName->getName(),PDO::PARAM_STR);
        $req->execute();
    }

    /**
     *
     *  UpdateRecipePreparation
     *
     * Update recipe content in db
     *
     * @param $newRecipePreparation
     *
     *
     *
     */

    public function UpdateRecipePreparation($newRecipePreparation)
    {
        $bdd = $this->bdd;
        $req = $bdd->prepare('UPDATE dish SET  Recipe =:Name WHERE DishId = :DishId ');
        $req->bindValue(':DishId',$newRecipePreparation->getDishId(),PDO::PARAM_INT);
        $req->bindValue(':Name',$newRecipePreparation->getRecipe(),PDO::PARAM_STR);
        $req->execute();
    }

    /**
     * UpdateRecipeStatus
     *
     *
     * update status recipe  in Db
     * @param $newRecipe
     *
     *
     */

    public function UpdateRecipeStatus($newRecipe)
    {
        $bdd = $this->bdd;
        $req = $bdd->prepare('UPDATE dish SET  Status =:Status WHERE DishId = :DishId ');
        $req->bindValue(':DishId',$newRecipe->getDishId(),PDO::PARAM_INT);
        $req->bindValue(':Status',$newRecipe->getStatus(),PDO::PARAM_STR);
        $req->execute();
    }

    /**
     * UpdateRecipePortion
     *
     * Update recipe Portion in Db
     *
     *
     * @param $newRecipe
     *
     *
     */

    public function UpdateRecipePortion($newRecipe)
    {
        $bdd = $this->bdd;
        $req = $bdd->prepare('UPDATE dish SET  Portion=:Portion WHERE DishId = :DishId ');
        $req->bindValue(':DishId',$newRecipe->getDishId(),PDO::PARAM_INT);
        $req->bindValue(':Portion',$newRecipe->getPortion(),PDO::PARAM_STR);
        $req->execute();
    }

    /**
     *
     * UpdateRecipeOrigin
     *
     * Update  Recipe Origin in db
     * @param $newRecipe
     */
    public function UpdateRecipeOrigin($newRecipe)
    {
        $bdd = $this->bdd;
        $req = $bdd->prepare('UPDATE dish SET  Origin =:Origin WHERE DishId = :DishId ');
        $req->bindValue(':DishId',$newRecipe->getDishId(),PDO::PARAM_INT);
        $req->bindValue(':Origin',$newRecipe->getOrigin(),PDO::PARAM_STR);
        $req->execute();
    }

    /**
     * UpdateRecipeCookingTime
     *
     * update recipeCooking Time  in db
     *
     *
     * @param $newRecipe
     */

    public function UpdateRecipeCookingTime($newRecipe)
    {
        $bdd = $this->bdd;
        $req = $bdd->prepare('UPDATE dish SET  CookingTime =:CookingTime WHERE DishId = :DishId ');
        $req->bindValue(':DishId',$newRecipe->getDishId(),PDO::PARAM_INT);
        $req->bindValue(':CookingTime',$newRecipe->getCookingTime(),PDO::PARAM_STR);
        $req->execute();
    }

    /**
     * UpdateRecipePreparationTime
     *
     * Update Recipe Preparation time in db
     *
     * @param $newRecipe
     *
     */

    public function UpdateRecipePreparationTime($newRecipe)
    {
        $bdd = $this->bdd;
        $req = $bdd->prepare('UPDATE dish SET  PreparationTime =:PreparationTime WHERE DishId = :DishId ');
        $req->bindValue(':DishId',$newRecipe->getDishId(),PDO::PARAM_INT);
        $req->bindValue(':PreparationTime',$newRecipe->getPreparationTime(),PDO::PARAM_STR);
        $req->execute();
    }

    /**
     * UpdateRecipeDifficulty
     *
     * Update Recipe Difficulty in db
     *
     * @param $newRecipe
     *
     */
    public function UpdateRecipeDifficulty($newRecipe)
    {
        $bdd = $this->bdd;
        $req = $bdd->prepare('UPDATE dish SET  Difficulty =:Difficulty WHERE DishId = :DishId ');
        $req->bindValue(':DishId',$newRecipe->getDishId(),PDO::PARAM_INT);
        $req->bindValue(':Difficulty',$newRecipe->getDifficulty(),PDO::PARAM_INT);
        $req->execute();
    }


    /**
     *
     * UpdateRecipeCategory
     *
     * Update Recipe category (Main plate , dessert ..)
     *
     *
     * @param $newRecipe
     */



    public function UpdateRecipeCategory($newRecipe)
    {

        $bdd = $this->bdd;
        $req = $bdd->prepare('UPDATE dish SET  Cat1 =:Cat1  , Cat2 =:Cat2 ,Cat3 =:Cat3, Cat4 =:Cat4 WHERE DishId = :DishId ');
        $req->bindValue(':DishId',$newRecipe->getDishId(),PDO::PARAM_INT);
        $req->bindValue(':Cat1',$newRecipe->getCat1(),PDO::PARAM_INT);
        $req->bindValue(':Cat2',$newRecipe->getCat2(),PDO::PARAM_INT);
        $req->bindValue(':Cat3',$newRecipe->getCat3(),PDO::PARAM_INT);
        $req->bindValue(':Cat4',$newRecipe->getCat4(),PDO::PARAM_INT);

        $req->execute();
    }


    /**
     * findInDb
     *
     * find a term in db for search block
     *
     *
     * @param $term
     * @return array
     */

    public function findInDb($term){
        $bdd = $this->bdd;
        $Dishes=  array();
                $termToFind = '%'.$term.'%' ;

            $query = "SELECT * FROM dish 
                      WHERE Title LIKE  '$termToFind'  AND Status ='R'  
                      
                      ";
            $req = $bdd->prepare($query);
            $req->execute();
            while ($row = $req-> fetch(PDO::FETCH_ASSOC))
            {
                $data = $this->RowInArray($row);
                $dish = new BasicDish($data);
                $Dishes[]= $dish;
            }
            return $Dishes;
    }

}