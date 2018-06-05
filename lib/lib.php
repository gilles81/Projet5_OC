<?php
/**
 * Created by PhpStorm.
 * User: Gilles
 * Date: 07/05/2018
 * Time: 22:37
 */




/**
 * Class lib
 *
 * this is a librarie of common method
 *
 *  *
 */


class lib
{
    /**
     * public function sessionStatus()
     *
     * Set Session status in visitor level if a session is not created.
     *
     */

    public function sessionStatus()
    {
        if (!isset($_SESSION['Status']))
        {
            $_SESSION['Status'] = 1;
            $_SESSION['adminLevel'] = 0; // Direct in VISITOR MODE
        }
    }

    public function rowInArray( $row)
    {

        $donnees = array();
        $donnees = [
            'dishId' => $row['DishId'],
            'Name' => $row['Title'],
            'category' => $row['Category'],
            'author' =>$row['Author'],
            'creationDate' => $row['CreationDate'],
            'recipe' => $row['Recipe'],
            'portion' => $row['Portion'],
            'imagePathName' => $row['ImagePathName'],
            'origin' => $row['Origin'],
            'cookingTime' => $row['CookingTime'],
            'preparationTime' => $row['PreparationTime'],
            'ingredients' => $row['Ingredients'],
            'difficulty' => $row['Difficulty'],
            'featured' => $row['Featured'],
            'likes' => $row['lke'],
            'status' => $row['Status'],
            'cat1' => $row['Cat1'],
            'cat2' => $row['Cat2'],
            'cat3' => $row['Cat3'],
            'cat4' => $row['Cat4']
        ];
        return $donnees;
    }

    public function recipeIngredientsRowInArray($row)
    {
        $donnees = array();

        $donnees = [
            //'Id' => $row['Id'],
            'RecipeId' => $row['RecipeId'],
            'IngredientId' => $row['IngredientId'],
            'Name' => $row['Name'],
            'Quantity'=> $row['quantity'],
            'Unit'=> $row['unit']
        ];

        return $donnees;
    }
    public function ingredientsRowInArray($row)
    {

        $donnees = array();
        $donnees = [
            'Id' => $row['Id'],
            'Name' => $row['Name'],
            'Category' => $row['Category']
        ];
        return $donnees;

    }



    public function createRecipeDataEmpty($newRecipeEmpty)
    {

        $donnees = array();
        $donnees = [
            'dishId' => 0,
            'Name' => '',
            'category' => '',
            'author' =>'',
            'creationDate' => '',
            'recipe' => '',
            'portion' => '',
            'imagePathName' =>'',
            'origin' => '',
            'cookingTime' => '',
            'preparationTime' => '',
            'ingredients' =>'',
            'difficulty' => '',
            'featured' => '',
            'likes' => '',
            'status' => '',
            'cat1' => '',
            'cat2' => '',
            'cat3' => '',
            'cat4' => ''
        ];
        return $donnees;
    }


    public function verifyIdInList($idList,$dish){
        $IdInList=false;
        foreach ($idList as $element  ) {
            if ($dish->getDishId() == $element) {
               $IdInList=true;
            }
        }

        return $IdInList;
    }

    function upload($index,$destination,$maxsize=FALSE,$extensions=FALSE)
    {
        //Test1: fichier correctement uploadé
        if (!isset($_FILES[$index]) OR $_FILES[$index]['error'] > 0) return FALSE;
        //Test2: taille limite
        if ($maxsize !== FALSE AND $_FILES[$index]['size'] > $maxsize) return FALSE;
        //Test3: extension
        $ext = substr(strrchr($_FILES[$index]['name'],'.'),1);
        if ($extensions !== FALSE AND !in_array($ext,$extensions)) return FALSE;
        //Déplacement
        return move_uploaded_file($_FILES[$index]['tmp_name'],$destination);
    }

    function findIngredientsListAlreadySelectioned($ingredientsList, $ingredientsRecipes){
        $ingredientsAvailables =  array();
        foreach ($ingredientsList as $ingredient){

            $ingredientInList =false;
            foreach ($ingredientsRecipes as $ingredientInRecipe)
            {
                if ($ingredient->getId() == $ingredientInRecipe->getIngredientId()) {
                    $ingredientInList=true;
                }
            }
            if (!$ingredientInList){
                $IngredientsAvailables[]=$ingredient;
            }
        }

    return $IngredientsAvailables;
    }




}