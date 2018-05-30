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
           // 'Id' => $row['IngredientId'],
            'RecipeId' => $row['RecipeId'],
            'IngredientId' => $row['IngredientId'],
            'Name' => $row['Name'],
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


}